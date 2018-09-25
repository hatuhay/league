<?php

namespace Drupal\league_game;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Game entity.
 *
 * @see \Drupal\league_game\Entity\Game.
 */
class GameAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\league_game\Entity\GameInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished game entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published game entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit game entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete game entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add game entities');
  }

}
