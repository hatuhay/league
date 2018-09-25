<?php

namespace Drupal\league_team;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\league_team\Entity\TeamInterface;

/**
 * Defines the storage handler class for Team entities.
 *
 * This extends the base storage class, adding required special handling for
 * Team entities.
 *
 * @ingroup league_team
 */
interface TeamStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Team revision IDs for a specific Team.
   *
   * @param \Drupal\league_team\Entity\TeamInterface $entity
   *   The Team entity.
   *
   * @return int[]
   *   Team revision IDs (in ascending order).
   */
  public function revisionIds(TeamInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Team author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Team revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\league_team\Entity\TeamInterface $entity
   *   The Team entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(TeamInterface $entity);

  /**
   * Unsets the language for all Team with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
