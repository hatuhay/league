<?php

namespace Drupal\prestamos_biblioteca\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Plugin\views\field\LinkBase;
use Drupal\views\ResultRow;

/**
 * Field handler to present a link to register loan.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("register_loan_node")
 */
class LoanRegisterNode extends LinkBase {


  /**
   * {@inheritdoc}
   */
  protected function getUrlInfo(ResultRow $row) {
    $node = $this->getEntity($row);
    $parameters = array(
      'query' => array(
	    'book_id' => $node->id(),
      ),
    );
    return Url::fromRoute('entity.prestamos.add_form', , $parameters);
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['text']['#title'] = $this->t('Link label');
    $form['text']['#required'] = TRUE;
    $form['text']['#default_value'] = empty($this->options['text']) ? $this->getDefaultLabel() : $this->options['text'];
  }

  /**
   * {@inheritdoc}
   */
  protected function renderLink(ResultRow $row) {
    $entity = $this->getEntity($row);

    $this->options['alter']['make_link'] = TRUE;
    $this->options['alter']['url'] = $this->getUrlInfo($row);

    $title = $this->t('Contact %node', array('%node' => $entity->label()));
    $this->options['alter']['attributes'] = array('title' => $title);

    if (!empty($this->options['text'])) {
      return $this->options['text'];
    }
    else {
      return $title;
    }
  }


  /**
   * {@inheritdoc}
   */
  protected function getDefaultLabel() {
    return $this->t('Register Loan');
  }

}
