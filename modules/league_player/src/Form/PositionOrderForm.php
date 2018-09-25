<?php

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\String;
use Drupal\Core\Url;

/**
 * Form constructor for the administrative listing/overview form.
 * https://www.drupal.org/node/1876710
 * https://api.drupal.org/api/drupal/core%21modules%21block%21src%21BlockListBuilder.php/8.2.x
 */
function league_player_position_overview_form($form, FormStateInterface $form_state) {
  $form['mytable'] = array(
    '#type' => 'table',
    '#header' => array(t('Label'), t('Machine name'), t('Weight'), t('Operations')),
    '#empty' => t('There are no items yet. Add an item.', array(
      '@add-url' => Url::fromRoute('mymodule.manage_add'),
    )),
    // TableSelect: Injects a first column containing the selection widget into
    // each table row.
    // Note that you also need to set #tableselect on each form submit button
    // that relies on non-empty selection values (see below).
    '#tableselect' => TRUE,
    // TableDrag: Each array value is a list of callback arguments for
    // drupal_add_tabledrag(). The #id of the table is automatically prepended;
    // if there is none, an HTML ID is auto-generated.
    '#tabledrag' => array(
      array(
        'action' => 'order',
        'relationship' => 'sibling',
        'group' => 'mytable-order-weight',
      ),
    ),
  );
  // Build the table rows and columns.
  // The first nested level in the render array forms the table row, on which you
  // likely want to set #attributes and #weight.
  // Each child element on the second level represents a table column cell in the
  // respective table row, which are render elements on their own. For single
  // output elements, use the table cell itself for the render element. If a cell
  // should contain multiple elements, simply use nested sub-keys to build the
  // render element structure for drupal_render() as you would everywhere else.
  foreach ($entities as $id => $entity) {
    // TableDrag: Mark the table row as draggable.
    $form['mytable'][$id]['#attributes']['class'][] = 'draggable';
    // TableDrag: Sort the table row according to its existing/configured weight.
    $form['mytable'][$id]['#weight'] = $entity->get('weight');

    // Some table columns containing raw markup.
    $form['mytable'][$id]['label'] = array(
      '#plain_text' => $entity->label(),
    );
    $form['mytable'][$id]['id'] = array(
      '#plain_text' => $entity->id(),
    );

    // TableDrag: Weight column element.
    $form['mytable'][$id]['weight'] = array(
      '#type' => 'weight',
      '#title' => t('Weight for @title', array('@title' => $entity->label())),
      '#title_display' => 'invisible',
      '#default_value' => $entity->get('weight'),
      // Classify the weight element for #tabledrag.
      '#attributes' => array('class' => array('mytable-order-weight')),
    );

    // Operations (dropbutton) column.
    $form['mytable'][$id]['operations'] = array(
      '#type' => 'operations',
      '#links' => array(),
    );
    $form['mytable'][$id]['operations']['#links']['edit'] = array(
      'title' => t('Edit'),
      'url' => Url::fromRoute('mymodule.manage_edit', array('id' => $id)),
    );
    $form['mytable'][$id]['operations']['#links']['delete'] = array(
      'title' => t('Delete'),
      'url' => Url::fromRoute('mymodule.manage_delete', array('id' => $id)),
    );
  }
  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save changes'),
    // TableSelect: Enable the built-in form validation for #tableselect for
    // this form button, so as to ensure that the bulk operations form cannot
    // be submitted without any selected items.
    '#tableselect' => TRUE,
  );
  return $form;
}