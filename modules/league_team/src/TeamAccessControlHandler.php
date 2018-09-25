<?php

namespace Drupal\league_team;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Team entity.
 *
 * @see \Drupal\league_team\Entity\Team.
 */
class TeamAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\league_team\Entity\TeamInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished team entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published team entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit team entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete team entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add team entities');
  }

}
