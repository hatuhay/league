<?php

namespace Drupal\league_game\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'league_game_result' field type.
 *
 * @FieldType(
 *   id = "league_game_result",
 *   label = @Translation("League game result"),
 *   description = @Translation("Score A and Score B field"),
 *   default_widget = "league_game_result",
 *   default_formatter = "league_game_result_formatter"
 * )
 */
class LeagueGameResult extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'main_score' => TRUE,
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['score_a'] = DataDefinition::create('integer')
      ->setLabel(t('Score A'))
      ->setDescription("Stores the day of the week's numeric representation (0-6)");
    $properties['score_b'] = DataDefinition::create('integer')
      ->setLabel(t('Score B'))
      ->setDescription("Stores the start hours value");

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'score_a' => [
          'type' => 'int',
          'unsigned' => TRUE,
          'default' => 0,
        ],
        'score_b' => [
          'type' => 'int',
          'unsigned' => TRUE,
          'default' => 0,
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $values['score_a'] = rand(0, 3);
    $values['score_b'] = rand(0, 3);
    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $elements['main_score'] = [
      '#type' => 'radios',
      '#title' => t('Main Score'),
      '#default_value' => $this->getSetting('main_score'),
      '#required' => TRUE,
      '#description' => t('Define if this score is main or partial.'),
      '#options' => array(0 => $this->t('Partial score'), 1 => $this->t('Main score')),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if (
      $this->get('score_a')->getValue() == '' ||
      $this->get('score_b')->getValue() == ''
    ) {
      return TRUE;
    }
    return FALSE;
  }

}
