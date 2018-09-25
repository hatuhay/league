<?php

namespace Drupal\league_player\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Player entities.
 */
class PlayerViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['player']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Player'),
      'help' => $this->t('The Player ID.'),
    );

    return $data;
  }

}
