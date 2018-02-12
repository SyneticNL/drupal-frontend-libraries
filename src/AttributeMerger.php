<?php

namespace synetic\DrupalFrontendTools;

use Drupal\Core\Template\Attribute;
use Drupal\Core\Template\AttributeArray;

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
  public function merge($attributes, $additional_attributes = []) {
    if(!isset($attributes)) {
      $attributes = new Attribute();
    }
    foreach ($additional_attributes as $key => $value) {
      if (is_string($value)) {
        $value = [$value];
      }
      if(is_object($value) && $value instanceof AttributeArray) {
        /** @var AttributeArray $value */
        $value = $value->getIterator()->getArrayCopy();
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