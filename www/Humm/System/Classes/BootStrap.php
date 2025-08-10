<?php

/**
 * This file implement the BootStrap system class.
 *
 * Humm PHP use this class in their unique entry
 * point (index.php) to prepare the user response.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

namespace Humm\System\Classes;

/**
 * System BootStrap class implementation.
 *
 * This is a system internal Humm PHP class and do not
 * contain useful stuff from the site point of view.
 */
final class BootStrap extends Unclonable {

  /**
   * Initialize the Humm PHP boot strap.
   *
   * This method is the responsible to initialize all other
   * neccesary Humm PHP system classes in the right order
   * and finally provide the appropiate user response.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   * @param string $root_dir_path Humm PHP root directory path.
   */
  public static function init (string $root_dir_path) : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      DirPaths::init($root_dir_path);

      // After DirPaths
      ErrorHandler::init();
      UserSites::init();
      HummVersion::init();
      UrlArguments::init();
      Configuration::init();

      // After Configuration
      Languages::init();

      // After Languages
      Localization::init();
      HummPlugins::init();

      // After HummPlugins
      Requeriments::init();
      Database::init();
      ViewsHandler::init();
    }

    // Everything is done.
    exit;
  }
}
