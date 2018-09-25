<?php

namespace Drupal\league_player\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Player entities.
 *
 * @ingroup league_player
 */
interface PlayerInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Player name.
   *
   * @return string
   *   Name of the Player.
   */
  public function getName();

  /**
   * Sets the Player name.
   *
   * @param string $name
   *   The Player name.
   *
   * @return \Drupal\league_player\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setName($name);

  /**
   * Gets the Player creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Player.
   */
  public function getCreatedTime();

  /**
   * Sets the Player creation timestamp.
   *
   * @param int $timestamp
   *   The Player creation timestamp.
   *
   * @return \Drupal\league_player\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Player published status indicator.
   *
   * Unpublished Player are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Player is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Player.
   *
   * @param bool $published
   *   TRUE to set this Player to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_player\Entity\PlayerInterface
   *   The called Player entity.
   */
  public function setPublished($published);

}
