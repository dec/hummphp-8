<?php

/**
 * This file implement the Configuration system class.
 *
 * Humm PHP use this class to setup the appropiate
 * system and user site configuration.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System Configuration class implementation.
 *
 * This is a system internal Humm PHP class and do not
 * contain useful stuff from the site point of view.
 */
final class Configuration extends Unclonable {

  /**
   * Setup the Humm PHP configuration.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      $site_config_file_path = FilePaths::siteConfig();

      if (\file_exists($site_config_file_path)) {

        require $site_config_file_path;
      }

      // Always after site config
      require FilePaths::systemConfig();
    }
  }
}
