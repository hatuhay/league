<?php

/**
 * @file
 * Definition of Drupal\prestamos_biblioteca\Plugin\views\field\LoanOutDate.
 */

namespace Drupal\prestamos_biblioteca\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\FilterPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Filters by given list of node title options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("loan_outdate")
 */
class LoanOutDate extends FilterPluginBase {

  /**

   * {@inheritdoc}

   */

  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Loan Out Date');
  }

  public function query() {
    $this->query->addWhere(
      $this->options['group'],
      db_or()
        ->condition(
		  db_and()->condition('prestamos_field_data.status', FALSE)
                  ->condition('prestamos_field_data.id', 'NOT NULL'))
        ->condition(
		  db_and()->condition('prestamos_field_data.status', FALSE)
                  ->condition('prestamos_field_data.id', 'NOT NULL')));
  }
}
