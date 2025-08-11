<?php

/**
 * This file implement the BaseClass system class.
 *
 * Humm PHP use this class as a base for almost all
 * other system classes.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System BaseClass class implementation.
 *
 * This class can be used by system and site classes
 * as a convenient PHP base class for use in Humm PHP.
 *
 * @abstract
 */
abstract class BaseClass extends \StdClass {

  /**
   * Retrieve the calling class directory URL.
   *
   * @return string The calling class directory URL.
   */
  protected function getClassDirUrl () : string {

    return self::doGetClassDirUrl(\get_class($this));
  }

  /**
   * Retrieve the calling class directory path.
   *
   * @return string The calling class directory path.
   */
  protected function getClassDirPath () : string {

    return self::doGetClassDirPath(\get_class($this));
  }

  /**
   * Retrieve the calling class directory URL.
   *
   * @static
   * @return string The calling class directory path.
   */
  protected static function getClassDirUrlEx () : string {

    return self::doGetClassDirUrl(\get_called_class());
  }

  /**
   * Retrieve the calling class directory path.
   *
   * @static
   * @return string The calling class directory path.
   */
  protected static function getClassDirPathEx () : string {

    return self::doGetClassDirPath(\get_called_class());
  }

  /**
   * Retrieve the directory URL for the specified class.
   *
   * @static
   * @param string $class_name Qualified class name.
   * @return string The class directory path.
   */
  private static function doGetClassDirUrl(string $class_name) : string {

    return UrlPaths::root() .
     \str_replace(
       StrUtils::PHP_NS_SEPARATOR,
       StrUtils::URL_SEPARATOR,
       \trim($class_name, \basename($class_name)));
  }

  /**
   * Retrieve the directory path for the specified class.
   *
   * @static
   * @param string $class_name Qualified class name.
   * @return string The class directory path.
   */
  private static function doGetClassDirPath (string $class_name) : string {

    return DirPaths::root() .
     \str_replace(
       StrUtils::PHP_NS_SEPARATOR,
       \DIRECTORY_SEPARATOR,
       \trim($class_name, \basename($class_name)));
  }
}
