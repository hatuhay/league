<?php

namespace Drupal\league_team;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class TeamStorage extends SqlContentEntityStorage implements TeamStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(TeamInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {team_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {team_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(TeamInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {team_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('team_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
