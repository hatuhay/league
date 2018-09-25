<?php

namespace Drupal\league_game;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\league_game\Entity\GameInterface;

/**
 * Defines the storage handler class for Game entities.
 *
 * This extends the base storage class, adding required special handling for
 * Game entities.
 *
 * @ingroup league_game
 */
interface GameStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Game revision IDs for a specific Game.
   *
   * @param \Drupal\league_game\Entity\GameInterface $entity
   *   The Game entity.
   *
   * @return int[]
   *   Game revision IDs (in ascending order).
   */
  public function revisionIds(GameInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Game author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Game revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\league_game\Entity\GameInterface $entity
   *   The Game entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(GameInterface $entity);

  /**
   * Unsets the language for all Game with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
