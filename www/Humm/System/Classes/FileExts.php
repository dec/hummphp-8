<?php

/**
 * This file implement the FileExts system class.
 *
 * Humm PHP use this class to define not localizables,
 * case sensitive file extensions of Humm PHP.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System FileExts class implementation.
 *
 * Define certain not localizables, case sensitive of the
 * sytem and also the user sites file extensions.
 */
final class FileExts extends Unclonable {

  /**
   * Define a PHP file extension.
   */
  public const PHP = 'php';

  /**
   * Define a MO file dotted extension.
   */
  public const DOT_MO = '.mo';

  /**
   * Define a PHP file dotted extension.
   */
  public const DOT_PHP = '.php';
}
