<?php

/**
 * This file implement the FilePaths system class.
 *
 * This class is used internally by Humm PHP and also
 * can be used by site classes, views and plugins to
 * retrieve Humm PHP related file paths.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System FilePaths class implementation.
 *
 * Although this class is internally used by other
 * Humm PHP system classes, contain stuff which can
 * also be useful from the user site point of view.
 */
final class FilePaths extends Unclonable {

  /**
   * Retrieve the system configuration file path.
   *
   * @static
   * @return string System configuration file path.
   */
  public static function systemConfig () : string {

    return DirPaths::systemConfig() . FileNames::CONFIG;
  }

  /**
   * Retrieve the system version file path.
   *
   * @static
   * @return string System version file path.
   */
  public static function systemVersion () : string {

    return DirPaths::version() . FileNames::VERSION;
  }

  /**
   * Retrieve the system text domain or MO file path.
   *
   * @static
   * @return string System text domain or MO file path.
   */
  public static function systemTextDomain () : string {

    $lang_code = Languages::getCurrentLanguage();

    return DirPaths::systemLocale() . $lang_code .
     \DIRECTORY_SEPARATOR . $lang_code . FileExts::DOT_MO;
  }

  /**
   * Retrieve the current site configuration file path.
   *
   * @static
   * @return string Current site configuration file path.
   */
  public static function siteConfig () : string {

    return DirPaths::siteConfig() . FileNames::CONFIG;
  }

  /**
   * Retrieve the current site text domain or MO file path.
   *
   * @static
   * @return string Current site text domain or MO file path.
   */
  public static function siteTextDomain () : string {

    $lang_code = Languages::getCurrentLanguage();

    return DirPaths::siteLocale() . $lang_code .
     \DIRECTORY_SEPARATOR . $lang_code . FileExts::DOT_MO;
  }

  /**
   * Retrieve the sites shared text domain or MO file path.
   *
   * @static
   * @return string sites shared text domain or MO file path.
   */
  public static function sitesSharedTextDomain () : string {

    $lang_code = Languages::getCurrentLanguage();

    return DirPaths::sitesSharedLocale() . $lang_code .
     \DIRECTORY_SEPARATOR . $lang_code . FileExts::DOT_MO;
  }

  /**
   * Retrieve the system I18n functions file path.
   *
   * @static
   * @return string System I18n functions file path.
   */
  public static function systemI18nFunctions () : string {

    return DirPaths::systemProcedural() . FileNames::I18N_FUNCTIONS;
  }

  /**
   * Retrieve a plugin text domain or MO file path.
   *
   * @static
   * @param String $plugin_dir_path Absolute plugin directory path.
   * @return string Plugin text domain or MO file path.
   */
  public static function pluginTextDomain (string $plugin_dir_path) : string {

    $lang_code = Languages::getCurrentLanguage();

    return DirPaths::pluginLocale($plugin_dir_path) . $lang_code .
     \DIRECTORY_SEPARATOR . $lang_code . FileExts::DOT_MO;
  }
}
