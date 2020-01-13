<?php

namespace Drupal\rw_people\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Person entities.
 */
class PersonEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
