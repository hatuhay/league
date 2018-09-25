<?php

namespace Drupal\league_game\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'league_game_result' widget.
 *
 * @FieldWidget(
 *   id = "league_game_result",
 *   label = @Translation("League game result"),
 *   field_types = {
 *     "league_game_result"
 *   }
 * )
 */
class LeagueGameResult extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['score_a'] = [
      '#type' => 'number',
      '#title' => $this->t('A'),
      '#default_value' => isset($items[$delta]->score_a) ? $items[$delta]->score_a : 0,
      '#size' => 4,
    ];
    $element['score_b'] = [
      '#type' => 'number',
      '#title' => $this->t('B'),
	  '#default_value' => isset($items[$delta]->score_b) ? $items[$delta]->score_b : 0,
      '#size' => 4,
    ];
    $element += [
      '#type' => 'fieldset',
      '#attributes' => array(
        'class' => 'container-inline',
      ),
    ];

    return $element;
  }

}
