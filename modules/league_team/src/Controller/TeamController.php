<?php

namespace Drupal\league_team\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\league_team\Entity\TeamInterface;

/**
 * Class TeamController.
 *
 *  Returns responses for Team routes.
 *
 * @package Drupal\league_team\Controller
 */
class TeamController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Team  revision.
   *
   * @param int $team_revision
   *   The Team  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($team_revision) {
    $team = $this->entityManager()->getStorage('team')->loadRevision($team_revision);
    $view_builder = $this->entityManager()->getViewBuilder('team');

    return $view_builder->view($team);
  }

  /**
   * Page title callback for a Team  revision.
   *
   * @param int $team_revision
   *   The Team  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($team_revision) {
    $team = $this->entityManager()->getStorage('team')->loadRevision($team_revision);
    return $this->t('Revision of %title from %date', array('%title' => $team->label(), '%date' => format_date($team->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Team .
   *
   * @param \Drupal\league_team\Entity\TeamInterface $team
   *   A Team  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(TeamInterface $team) {
    $account = $this->currentUser();
    $langcode = $team->language()->getId();
    $langname = $team->language()->getName();
    $languages = $team->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $team_storage = $this->entityManager()->getStorage('team');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $team->label()]) : $this->t('Revisions for %title', ['%title' => $team->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all team revisions") || $account->hasPermission('administer team entities')));
    $delete_permission = (($account->hasPermission("delete all team revisions") || $account->hasPermission('administer team entities')));

    $rows = array();

    $vids = $team_storage->revisionIds($team);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\league_team\TeamInterface $revision */
      $revision = $team_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $team->getRevisionId()) {
          $link = $this->l($date, new Url('entity.team.revision', ['team' => $team->id(), 'team_revision' => $vid]));
        }
        else {
          $link = $team->link($date);
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
              Url::fromRoute('team.revision_revert_translation_confirm', ['team' => $team->id(), 'team_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('team.revision_revert_confirm', ['team' => $team->id(), 'team_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('team.revision_delete_confirm', ['team' => $team->id(), 'team_revision' => $vid]),
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

    $build['team_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
