<?php

namespace Drupal\league_events\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Events entity.
 *
 * @ConfigEntityType(
 *   id = "events",
 *   label = @Translation("Events"),
 *   handlers = {
 *     "list_builder" = "Drupal\league_events\EventsListBuilder",
 *     "form" = {
 *       "add" = "Drupal\league_events\Form\EventsForm",
 *       "edit" = "Drupal\league_events\Form\EventsForm",
 *       "delete" = "Drupal\league_events\Form\EventsDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\league_events\EventsHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "events",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "weight" = "weight"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/events/{events}",
 *     "add-form" = "/admin/structure/events/add",
 *     "edit-form" = "/admin/structure/events/{events}/edit",
 *     "delete-form" = "/admin/structure/events/{events}/delete",
 *     "collection" = "/admin/structure/events"
 *   }
 * )
 */
class Events extends ConfigEntityBase implements EventsInterface {

  /**
   * The Events ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Events label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Events icon class.
   *
   * @var string
   */
  protected $icon;

  /**
   * The Events points.
   *
   * @var int
   */
  protected $points;

  /**
   * The Event is active.
   *
   * @var int
   */
  protected $active;

  /**
   * The Event is public.
   *
   * @var int
   */
  protected $public;

  /**
   * The Event apply to other team.
   *
   * @var int
   */
  protected $other;

  /**
   * The Event weight.
   *
   * @var int
   */
  protected $weight;

  /**
   * {@inheritdoc}
   */
  public function weight() {
    return $this->weight;
  }

}
