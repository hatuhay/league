<?php

namespace Drupal\league_events\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Game events entities.
 *
 * @ingroup league_events
 */
interface GameEventsInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Game events name.
   *
   * @return string
   *   Name of the Game events.
   */
  public function getName();

  /**
   * Sets the Game events name.
   *
   * @param string $name
   *   The Game events name.
   *
   * @return \Drupal\league_events\Entity\GameEventsInterface
   *   The called Game events entity.
   */
  public function setName($name);

  /**
   * Gets the Game events creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Game events.
   */
  public function getCreatedTime();

  /**
   * Sets the Game events creation timestamp.
   *
   * @param int $timestamp
   *   The Game events creation timestamp.
   *
   * @return \Drupal\league_events\Entity\GameEventsInterface
   *   The called Game events entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Game events published status indicator.
   *
   * Unpublished Game events are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Game events is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Game events.
   *
   * @param bool $published
   *   TRUE to set this Game events to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_events\Entity\GameEventsInterface
   *   The called Game events entity.
   */
  public function setPublished($published);

}
