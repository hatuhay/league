<?php

namespace Drupal\league_player\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class PositionForm.
 *
 * @package Drupal\league_player\Form
 */
class PositionForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $position = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $position->label(),
      '#description' => $this->t("Label for the Position."),
      '#required' => TRUE,
    );

    $form['weight'] = array(
      '#type' => 'weight',
      '#title' => $this->t('Weight'),
      '#default_value' => $position->weight(),
      '#description' => $this->t("Weight for position purposes."),
      '#delta' => 10,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $position->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\league_player\Entity\Position::load',
      ),
      '#disabled' => !$position->isNew(),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $position = $this->entity;
    $status = $position->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Position.', [
          '%label' => $position->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Position.', [
          '%label' => $position->label(),
        ]));
    }
    $form_state->setRedirectUrl($position->urlInfo('collection'));
  }

}
