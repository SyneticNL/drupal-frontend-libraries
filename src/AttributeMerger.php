<?php

namespace synetic\DrupalFrontendTools;

use Drupal\Core\Template\Attribute;

/**
 * Class BemGenerator
 *
 * @package Drupal\synetic_frontend
 */
class AttributeMerger {

  /**
   * Generate an Attribute object with BEM classes.
   *
   * @param string $base_class
   * @param array $modifiers
   * @param string $blockname
   * @param array $extra
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