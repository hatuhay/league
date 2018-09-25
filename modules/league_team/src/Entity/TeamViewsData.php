<?php

namespace Drupal\league_team\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Team entities.
 */
class TeamViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
