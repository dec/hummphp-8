<?php

/**
 * This file implement the PluginArguments system class.
 *
 * This class is intended to be inherited by the system
 * ActionArguments and FilterArguments classes.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System PluginArguments class implementation.
 *
 * To be inherited by system ActionArguments and
 * FilterArguments classes provide the basic logic
 * for a plugin arguments object.
 *
 * Everytime the system want to perform a filter or an
 * action over the available plugins they prepare a bunch
 * of filter or action arguments into the appropiate
 * FilterArguments or ActionArguments classes.
 *
 * @abstract
 */
abstract class PluginArguments extends BaseClass {

  /**
   * Property name to store the bundle part of the arguments.
   */
  public const BUNDLE = 'bundle';

  /**
   * Property name to store the content part of the arguments.
   */
  public const CONTENT = 'content';

  /**
   * Plugin arguments bundle.
   *
   * @var mixed
   */
  public mixed $bundle = null;

  /**
   * Plugin arguments content.
   *
   * @var mixed
   */
  public mixed $content = null;

  /**
   * Construct a PluginArguments object.
   *
   * @param array $arguments Associative array with arguments.
   */
  public function __construct (array $arguments = []) {

    $this->bundle = null;
    $this->content = null;

    // Put the array arguments as this object properties
    foreach ($arguments as $prop_name => $prop_value) {
      $this->$prop_name = $prop_value;
    }
  }

  /**
   * Magic method for direct access this object properties.
   *
   * @param string $var_name Variable name.
   * @return mixed Object property value.
   */
  public function __get (string $var_name) : mixed {

    return $this->$var_name;
  }
}
