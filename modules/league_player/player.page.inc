<?php

/**
 * @file
 * Contains player.page.inc.
 *
 * Page callback for Player entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Player templates.
 *
 * Default template: player.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_player(array &$variables) {
  // Fetch Player Entity Object.
  $player = $variables['elements']['#player'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
