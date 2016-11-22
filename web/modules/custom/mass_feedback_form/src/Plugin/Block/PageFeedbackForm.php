<?php

namespace Drupal\mass_feedback_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'PageFeedbackForm' block.
 *
 * @Block(
 *  id = "page_feedback_form",
 *  admin_label = @Translation("Page feedback form"),
 * )
 */
class PageFeedbackForm extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#attached' => array(
        'library' => array(
          'mass_feedback_form/feedback-form-css',
        ),
      ),
      '#theme' => 'block--mass-feedback-form',
    );
  }

}
