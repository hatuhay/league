<?php

namespace Drupal\league_events\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class EventsForm.
 *
 * @package Drupal\league_events\Form
 */
class EventsForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $events = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $events->label(),
      '#description' => $this->t("Label for the Events."),
      '#required' => TRUE,
    ];

    $form['icon'] = [
      '#type' => 'machine_name',
      '#title' => t('Class icon'),
      '#default_value' => isset($event_type->class_icon) ? $event_type->class_icon : '',
      '#description' => t('CSS class for icon of the event type, only allowed characters and underscores, no spaces.'),
      '#maxlength' => 255,
      '#machine_name' => array(
        'exists' => FALSE, //'league_event_type_class_exists',
       ),
      '#required' => TRUE,
    ];

    $form['points'] = [
      '#type' => 'number',
      '#title' => $this->t('Points'),
      '#default_value' => $events->points(),
      '#description' => $this->t("Number of points given for this event."),
      '#required' => TRUE,
    ];

    $form['active'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Is Active'),
      '#default_value' => $events->isActive(),
      '#description' => $this->t("Is the event active."),
      '#required' => TRUE,
    ];

    $form['public'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Is Public'),
      '#default_value' => $events->isPublic(),
      '#description' => $this->t("Public or private type event."),
      '#required' => TRUE,
    ];

    $form['other'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Is Other Team'),
      '#default_value' => $events->isOther(),
      '#description' => $this->t("Event for other team like Own Goal."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $events->id(),
      '#machine_name' => [
        'exists' => '\Drupal\league_events\Entity\Events::load',
      ],
      '#disabled' => !$events->isNew(),
    ];

    $form['weight'] = array(
      '#type' => 'weight',
      '#title' => $this->t('Weight'),
      '#default_value' => $events->weight(),
      '#description' => $this->t("Weight for position purposes."),
      '#delta' => 10,
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $events = $this->entity;
    $status = $events->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Events.', [
          '%label' => $events->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Events.', [
          '%label' => $events->label(),
        ]));
    }
    $form_state->setRedirectUrl($events->toUrl('collection'));
  }

}
