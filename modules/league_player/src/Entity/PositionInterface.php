<?php

namespace Drupal\league_player\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Position entities.
 */
interface PositionInterface extends ConfigEntityInterface {

  /**
   * Gets the Position Weight.
   *
   * @return int
   *   Weight of the position.
   */
  public function weight();

  /**
   * Sets the Position weight.
   *
   * @param int $weight
   *   The Position weight.
   *
   * @return \Drupal\league_player\Entity\PositionInterface
   *   The called Position weight.
   */
  public function setWeight($weight);

  }
