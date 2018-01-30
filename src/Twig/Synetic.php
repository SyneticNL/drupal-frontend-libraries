<?php

namespace syneticnl\DrupalFrontendLibraries\Twig;

use Drupal\Core\Template\Attribute;
use syneticnl\DrupalFrontendLibraries\BemGenerator;

/**
 * Class DefaultService.
 *
 * @package Drupal\MyTwigModule
 */
class Synetic extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'bem';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('bem',
        [$this, 'bem'],
        ['is_safe' => ['html']]),
      new \Twig_SimpleFunction('add_attributes',
        [$this, 'addAttributes'],
        ['is_safe' => ['html']]),
    ];
  }

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
  public function bem($base_class, $modifiers = [], $blockname = '', $extra = []) {
    $bem = new BemGenerator();
    return $bem->generate($base_class, $modifiers, $blockname, $extra);
  }

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
  public function addAttributes(Attribute $attributes, $additional_attributes = []) {
    foreach ($additional_attributes as $key => $value) {
      if (is_array($value)) {
        foreach ($value as $index => $item) {
          // Handle bem() output.
          if ($item instanceof Attribute) {
            // Remove the item.
            unset($value[$index]);
            $value = array_merge($value, $item->toArray()[$key]);
          }
        }
      }
      else {
        // Handle bem() output.
        if ($value instanceof Attribute) {
          $value = $value->toArray()[$key];
        }
        elseif (is_string($value)) {
          $value = [$value];
        }
        else {
          continue;
        }
      }
      // Merge additional attribute values with existing ones.
      if ($attributes->offsetExists($key)) {
        $existing_attribute = $attributes->offsetGet($key)->value();
        $value = array_merge($existing_attribute, $value);
      }

      $attributes->setAttribute($key, $value);
    }

    return $attributes;
  }

}
