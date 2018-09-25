<?php

namespace Drupal\league_game\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Game entities.
 *
 * @ingroup league_game
 */
interface GameInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Game name.
   *
   * @return string
   *   Name of the Game.
   */
  public function getName();

  /**
   * Sets the Game name.
   *
   * @param string $name
   *   The Game name.
   *
   * @return \Drupal\league_game\Entity\GameInterface
   *   The called Game entity.
   */
  public function setName($name);

  /**
   * Gets the Game creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Game.
   */
  public function getCreatedTime();

  /**
   * Sets the Game creation timestamp.
   *
   * @param int $timestamp
   *   The Game creation timestamp.
   *
   * @return \Drupal\league_game\Entity\GameInterface
   *   The called Game entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Game published status indicator.
   *
   * Unpublished Game are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Game is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Game.
   *
   * @param bool $published
   *   TRUE to set this Game to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_game\Entity\GameInterface
   *   The called Game entity.
   */
  public function setPublished($published);

  /**
   * Gets the Game revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Game revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\league_game\Entity\GameInterface
   *   The called Game entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Game revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Game revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\league_game\Entity\GameInterface
   *   The called Game entity.
   */
  public function setRevisionUserId($uid);

}
