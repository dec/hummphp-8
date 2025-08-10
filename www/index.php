<?php

/**
 * This file implement the Humm PHP entry point.
 *
 * Every user request to a Humm PHP managed site
 * end here and then Humm initiates the boot strap.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

/**
 * Register our classes autoload.
 */
\spl_autoload_register(function (string $class_name) {

  $class_file_path = __DIR__ . \DIRECTORY_SEPARATOR .
   \str_replace('\\', \DIRECTORY_SEPARATOR, $class_name) . '.php';

  if (\file_exists($class_file_path)) {

    require_once $class_file_path;
  }
});

 /**
 * Initiates the system boot strap.
 */
\Humm\System\Classes\BootStrap::init(__DIR__);
