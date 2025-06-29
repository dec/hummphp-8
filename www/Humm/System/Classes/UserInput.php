<?php

/**
 * This file implement the UserInput system class.
 *
 * This class is intended to offer a convenient way
 * to access diferents user input variables.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System UserInput class implementation.
 *
 * Provide stuff to deal with user input variables using the
 * appropiate input filters instead of accessing it directly.
 *
 */
class UserInput extends Unclonable {

  /**
   * Retrieve an INPUT_GET variable or execute a filter.
   *
   * @static
   * @param string $var_name Variable name to be retrieved.
   * @param mixed $default_value Default value to fall out.
   * @param int $filter Input filter to be applied.
   * @param int|array $options Options be used.
   * @return mixed The resulted variable value or filter result.
   */
  public static function get (string $var_name, mixed $default_value = null, int $filter = \FILTER_DEFAULT, int|array $options = 0) : mixed {

    return self::getVariable($var_name, \INPUT_GET, $default_value, $filter, $options);
  }

  /**
   * Retrieve an INPUT_POST variable or execute a filter.
   *
   * @static
   * @param string $var_name Variable name to be retrieved.
   * @param mixed $default_value Default value to fall out.
   * @param int $filter Input filter to be applied.
   * @param int|array $options Options be used.
   * @return mixed The resulted variable value or filter result.
   */
  public static function post (string $var_name, mixed $default_value = null, int $filter = \FILTER_DEFAULT, int|array $options = 0) : mixed {

    return self::getVariable($var_name, \INPUT_POST, $default_value, $filter, $options);
  }

  /**
   * Retrieve an INPUT_SERVER variable or execute a filter.
   *
   * @todo Use the filter input instead of $_SERVER direct access.
   * @static
   * @param string $var_name Variable name to be retrieved.
   * @param mixed $default_value Default value to fall out.
   * @param int $filter Input filter to be applied.
   * @param int|array $options Options be used.
   * @return mixed The resulted variable value or filter result.
   */
  public static function server (string $var_name, mixed $default_value = null, int $filter = \FILTER_DEFAULT, int|array $options = 0) : mixed {

    $result = $default_value;

    // For some reason we cannot use filter_input with
    // INPUT_SERVER in certain PHP versions or servers... (?)
    if (isset($_SERVER[$var_name])) {

      $result = \filter_var($_SERVER[$var_name], $filter, $options);
    }

    return $result;
  }

  /**
   * Retrieve an INPUT_SESSION variable or execute a filter.
   *
   * @todo Use the filter input instead of $_SESSION direct access.
   * @static
   * @param string $var_name Variable name to be retrieved.
   * @param mixed $default_value Default value to fall out.
   * @param int $filter Input filter to be applied.
   * @param int|array $options Options be used.
   * @return mixed The resulted variable value or filter result.
   */
  public static function session (string $var_name, mixed $default_value = null, int $filter = \FILTER_DEFAULT, int|array $options = 0) : mixed {

    // For some reason we cannot use filter_input with
    // INPUT_SESSION in certain PHP versions or servers... (?)
    $result = $default_value;

    if (isset($_SESSION[$var_name])) {

      $result = \filter_var($_SESSION[$var_name], $filter, $options);
    }

    return $result;
  }

  /**
   * Retrieve an INPUT_COOKIE variable or execute a filter.
   *
   * @static
   * @param string $var_name Variable name to be retrieved.
   * @param mixed $default_value Default value to fall out.
   * @param int $filter Input filter to be applied.
   * @param int|array $options Options be used.
   * @return mixed The resulted variable value or filter result.
   */
  public static function cookie (string $var_name, mixed $default_value = null, int $filter = \FILTER_DEFAULT, int|array $options = 0) : mixed {

    return self::getVariable($var_name, \INPUT_COOKIE, $default_value, $filter, $options);
  }

  /**
   * Retrieve a variable from the specified INPUT type.
   *
   * @param string $var_name Variable name to be retrieved.
   * @param int $input_type One of the availables input filter.
   * @param mixed $default_value Default value to fall out.
   * @param int $filter Input filter to be applied.
   * @param int $options Options be used.
   * @return mixed The resulted variable value or filter result.
   */
  private static function getVariable (string $var_name, int $input_type, mixed $default_value = null, int $filter = \FILTER_DEFAULT, int|array $options = 0) : mixed {

    $result = $default_value;

    if (\filter_has_var($input_type, $var_name)) {

      $result = \filter_input($input_type, $var_name, $filter, $options);
    }

    return $result;
  }
}
