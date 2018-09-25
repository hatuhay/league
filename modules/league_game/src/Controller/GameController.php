<?php

namespace Drupal\league_game\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\league_game\Entity\GameInterface;

/**
 * Class GameController.
 *
 *  Returns responses for Game routes.
 *
 * @package Drupal\league_game\Controller
 */
class GameController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Game  revision.
   *
   * @param int $game_revision
   *   The Game  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($game_revision) {
    $game = $this->entityManager()->getStorage('game')->loadRevision($game_revision);
    $view_builder = $this->entityManager()->getViewBuilder('game');

    return $view_builder->view($game);
  }

  /**
   * Page title callback for a Game  revision.
   *
   * @param int $game_revision
   *   The Game  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($game_revision) {
    $game = $this->entityManager()->getStorage('game')->loadRevision($game_revision);
    return $this->t('Revision of %title from %date', array('%title' => $game->label(), '%date' => format_date($game->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Game .
   *
   * @param \Drupal\league_game\Entity\GameInterface $game
   *   A Game  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(GameInterface $game) {
    $account = $this->currentUser();
    $langcode = $game->language()->getId();
    $langname = $game->language()->getName();
    $languages = $game->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $game_storage = $this->entityManager()->getStorage('game');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $game->label()]) : $this->t('Revisions for %title', ['%title' => $game->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all game revisions") || $account->hasPermission('administer game entities')));
    $delete_permission = (($account->hasPermission("delete all game revisions") || $account->hasPermission('administer game entities')));

    $rows = array();

    $vids = $game_storage->revisionIds($game);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\league_game\GameInterface $revision */
      $revision = $game_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $game->getRevisionId()) {
          $link = $this->l($date, new Url('entity.game.revision', ['game' => $game->id(), 'game_revision' => $vid]));
        }
        else {
          $link = $game->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->revision_log_message->value, '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('game.revision_revert_translation_confirm', ['game' => $game->id(), 'game_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('game.revision_revert_confirm', ['game' => $game->id(), 'game_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('game.revision_delete_confirm', ['game' => $game->id(), 'game_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['game_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
