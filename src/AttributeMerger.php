<?php

namespace synetic\DrupalFrontendTools;

use Drupal\Core\Template\Attribute;

/**
 * Class AttributeMerger
 *
 * @package synetic\DrupalFrontendTools
 */
class AttributeMerger {

  /**
   * Merge Attribute() with additional array of attributes by key value pairs.
   *
   * @param Drupal\Core\Template\Attribute $attributes
   *
   * @return \Drupal\Core\Template\Attribute
   */
  public function merge(Attribute $attributes, $additional_attributes = []) {
    foreach ($additional_attributes as $key => $value) {
      if (is_string($value)) {
        $value = [$value];
      }
      if ($attributes->offsetExists($key)) {
        $existing_attribute = $attributes->offsetGet($key)->value();
        $value = array_merge($existing_attribute, $value);
      }

      $attributes->setAttribute($key, $value);
    }

    return $attributes;
  }
}