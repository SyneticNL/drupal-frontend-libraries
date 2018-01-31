<?php

namespace synetic\DrupalFrontendTools;

use Drupal\Core\Template\Attribute;

/**
 * Class BemGenerator
 *
 * @package Drupal\synetic_frontend
 */
class Bem {

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
  public function generate($base_class, $modifiers = [], $blockname = '', $extra = []) {
    // If using a blockname to override default class.
    if (!empty($blockname)) {
      // Set blockname class.
      $base_class = $blockname . '__' . $base_class;
    }

    $classes = $this->processModifiers($base_class, $modifiers);

    // If extra non-BEM classes are added.
    if (!empty($extra) && is_array($extra)) {
      foreach ($extra as $extra_class) {
        $classes[] = $extra_class;
      }
    }

    return $this->convertToAttribute($classes);
  }

  /**
   * Convert classes and context into Attribute object.
   *
   * @param $classes
   *
   * @return \Drupal\Core\Template\Attribute
   */
  protected function convertToAttribute($classes) {
    $attributes = new Attribute();

    // Add class attribute.
    if (!empty($classes)) {
      $attributes->setAttribute('class', $classes);
    }
    return $attributes;
  }

  /**
   * Process base class with modifiers into bem classes.
   *
   * @return array
   */
  protected function processModifiers($base_class, $modifiers) {
    // Set base class.
    $classes = [
      $base_class,
    ];

    // Set base--modifier class for each modifier.
    if (isset($modifiers) && is_array($modifiers)) {
      foreach ($modifiers as $modifier) {
        $classes[] = $base_class . '--' . $modifier;
      };
    }

    return $classes;
  }
}