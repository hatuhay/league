<?php

namespace Drupal\league_team\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Team entities.
 *
 * @ingroup league_team
 */
interface TeamInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Team name.
   *
   * @return string
   *   Name of the Team.
   */
  public function getName();

  /**
   * Sets the Team name.
   *
   * @param string $name
   *   The Team name.
   *
   * @return \Drupal\league_team\Entity\TeamInterface
   *   The called Team entity.
   */
  public function setName($name);

  /**
   * Gets the Team creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Team.
   */
  public function getCreatedTime();

  /**
   * Sets the Team creation timestamp.
   *
   * @param int $timestamp
   *   The Team creation timestamp.
   *
   * @return \Drupal\league_team\Entity\TeamInterface
   *   The called Team entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Team published status indicator.
   *
   * Unpublished Team are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Team is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Team.
   *
   * @param bool $published
   *   TRUE to set this Team to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\league_team\Entity\TeamInterface
   *   The called Team entity.
   */
  public function setPublished($published);

  /**
   * Gets the Team revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Team revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\league_team\Entity\TeamInterface
   *   The called Team entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Team revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Team revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\league_team\Entity\TeamInterface
   *   The called Team entity.
   */
  public function setRevisionUserId($uid);

}
