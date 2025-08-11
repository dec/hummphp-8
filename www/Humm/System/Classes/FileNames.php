<?php

/**
 * This file implement the FileNames system class.
 *
 * Humm PHP use this class to define not localizables,
 * case sensitive file names of Humm PHP.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System FileNames class implementation.
 *
 * Define certain not localizables, case sensitive
 * sytem and user sites file names.
 */
final class FileNames extends Unclonable {

  /**
   * Define the configurations files name.
   */
  public const CONFIG = 'Config.php';

  /**
   * Define the system version file name.
   */
  public const VERSION = 'Version.php';

  /**
   * Define the system I18n functions file name.
   */
  public const I18N_FUNCTIONS = 'I18nFunctions.php';

  /**
   * Define an index PHP file: like Humm PHP entry point.
   */
  public const PHP_INDEX = 'index.php';
}
