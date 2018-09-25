<?php

namespace Drupal\league\Form;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure bootstrap_library settings for this site.
 */
class LeagueSettingsForm extends ConfigFormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'league_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'league.settings',
    ];
  }

  /**
   * Defines the settings form for Game entities.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('league.settings');

    $form['league_settings']['#markup'] = 'Settings for league module.';

    $form['league_settings']['points'] = array(
      '#type' => 'fieldset',
      '#title' => t('Points for matches'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );
    $form['league_settings']['points']['win'] = array(
      '#type' => 'textfield',
      '#title' => t('Winner points'),
      '#default_value' => $config->get('win'),
      '#description' => t('Points for winner'),
      '#size' => 3,
      '#maxlength' => 1,
    );
    $form['league_settings']['points']['tie'] = array(
      '#type' => 'textfield',
      '#title' => t('Tie points'),
      '#default_value' => $config->get('tie'),
      '#description' => t('Points for tie'),
      '#size' => 3,
      '#maxlength' => 1,
    );
    $form['league_settings']['points']['loose'] = array(
      '#type' => 'textfield',
      '#title' => t('Looser points'),
      '#default_value' => $config->get('loose'),
      '#description' => t('Points for looser'),
      '#size' => 3,
      '#maxlength' => 1,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
   public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!is_numeric($form_state->getValue('win'))) {
      $form_state->setErrorByName('Win Points', $this->t('Winning points must be integer.'));
    }
    if (!is_numeric($form_state->getValue('tie'))) {
      $form_state->setErrorByName('Tie Points', $this->t('Tie points must be integer.'));
    }
    if (!is_numeric($form_state->getValue('loose'))) {
      $form_state->setErrorByName('Loose Points', $this->t('Loose points must be integer.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('league.settings')
      ->set('win', $form_state->getValue('win'))
      ->set('tie', $form_state->getValue('tie'))
      ->set('loose', $form_state->getValue('loose'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
