<?php

namespace Drupal\levchik\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\levchik\Entity\Guest;

/**
 * Provides LevchikController class for guests page.
 */
class LevchikController extends ControllerBase {

  /**
   * Build the response.
   */
  public function build() {
    \Drupal::service('page_cache_kill_switch')->trigger();
    $entity = Guest::create();
    $storage = \Drupal::entityTypeManager()->getStorage('guest');
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder('guest');
    $guest_entities = $storage->loadMultiple();
    $guests_rendered = [];
    foreach ($guest_entities as $guest) {
      $guests_rendered[] = $view_builder->view($guest);
    }
    return [
      'header' => [
        '#type' => 'markup',
        '#markup' => $this->t('Greetings, our dear guest. Here you can publish your feedback about this site.'),
      ],
      'form' => \Drupal::service('entity.form_builder')->getForm($entity, 'default'),
      'hr' => [
        '#markup' => "<hr/>",
      ],
      'guests' => empty($guests_rendered) ? [
        '#markup' => $this->t('<h2>Sorry, no one published feedback yet. You can be the first!</h2>'),
      ] : array_reverse($guests_rendered),
    ];
  }

}
