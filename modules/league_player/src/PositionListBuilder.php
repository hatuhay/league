<?php

namespace Drupal\league_player;

use Drupal\Core\Config\Entity\DraggableListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\String;
/**
 * Provides a listing of Position entities.
 */
class PositionListBuilder extends DraggableListBuilder {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'position_list_form';
  }

   /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Position');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    // You probably want a few more properties here...
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
 
    drupal_set_message(t('The position list has been saved.'));
  }
  
}
