<?php

/**
 * This file implement the StrUtils system class.
 *
 * This class is intended to encapsulate string utils stuff
 * like constants and methods for string manipulation.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System StrUtils class implementation.
 *
 * This system class can be used both in system and
 * user sites for string manipulation.
 *
 */
final class StrUtils extends Unclonable {

  /**
   * Define a dot.
   */
  public const DOT = '.';

  /**
   * Define an empty string.
   */
  public const EMPTY_STRING = '';

  /**
   * Define an URL separator.
   */
  public const URL_SEPARATOR = '/';

  /**
   * Define a PHP namespace separator.
   */
  public const PHP_NS_SEPARATOR = '\\';

  /**
   * Find if the specified string is empty.
   *
   * @static
   * @param string $string String to be evaluated.
   * @return bool True if string is empty, False if not.
   */
  public static function isEmpty (string $string) : bool {

    return $string === self::EMPTY_STRING;
  }

  /**
   * Find if the specified string is empty after trim.
   *
   * @static
   * @param string $string String to be evaluated.
   * @return bool True if string is empty, False if not.
   */
  public static function isTrimEmpty (string $string) : bool {

    return \trim($string) === self::EMPTY_STRING;
  }
}
