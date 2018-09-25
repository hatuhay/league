<?php

namespace Drupal\league_events;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Game events entity.
 *
 * @see \Drupal\league_events\Entity\GameEvents.
 */
class GameEventsAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\league_events\Entity\GameEventsInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished game events entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published game events entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit game events entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete game events entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add game events entities');
  }

}
