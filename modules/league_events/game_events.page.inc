<?php

/**
 * @file
 * Contains game_events.page.inc.
 *
 * Page callback for Game events entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Game events templates.
 *
 * Default template: game_events.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_game_events(array &$variables) {
  // Fetch GameEvents Entity Object.
  $game_events = $variables['elements']['#game_events'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
