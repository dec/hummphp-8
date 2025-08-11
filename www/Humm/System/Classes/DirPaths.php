<?php

/**
 * This file implement the DirPaths system class.
 *
 * Humm PHP use this class to discover and use absolute
 * paths of well know directories.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System DirPaths class implementation.
 *
 * This class can be used by user site classes, views
 * and plugins to retrieve well know directory paths.
 */
final class DirPaths extends Unclonable {

  /**
   * Store the Humm PHP root absolute directory path.
   *
   * @static
   * @var ?string
   */
  private static ?string $root_dir_path = null;

  /**
   * Store the Humm PHP root directory path.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   * @param string $root_dir_path Humm PHP root absolute directory path.
   * @param string Humm PHP directory path.
   */
  public static function init (string $root_dir_path) : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      self::$root_dir_path = $root_dir_path;
    }
  }

  /**
   * Retrieve the root directory path.
   *
   * @static
   * @return string Root absolute directory path.
   */
  public static function root () : string {

    return self::$root_dir_path . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the root/humm directory path.
   *
   * @static
   * @return string Root/humm absolute directory path.
   */
  public static function humm () : string {

    return self::root() . DirNames::HUMM . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the version directory path.
   *
   * @static
   * @return string Version absolute directory path.
   */
  public static function version () : string {

    return self::system() . DirNames::VERSION . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a Humm PHP plugins directory path.
   *
   * @static
   * @return string Humm PHP plugins absolute directory path.
   */
  public static function plugins () : string {

    return self::humm() . DirNames::PLUGINS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a plugin locale directory path.
   *
   * @static
   * @param string $plugin_dir_path Plugin directory name.
   * @return string Plugin locale absolute directory path.
   */
  public static function pluginLocale (string $plugin_dir_path) : string {

    return $plugin_dir_path . DirNames::LOCALE . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system directory path.
   *
   * @static
   * @return string System absolute directory path.
   */
  public static function system () : string {

    return self::humm() . DirNames::SYSTEM . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system config directory path.
   *
   * @static
   * @return string System config absolute directory path.
   */
  public static function systemConfig () : string {

    return self::system() . DirNames::CONFIG . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system locale directory path.
   *
   * @static
   * @return string System locale absolute directory path.
   */
  public static function systemLocale () : string {

    return self::system() . DirNames::LOCALE . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system classes directory path.
   *
   * @static
   * @return string System classes absolute directory path.
   */
  public static function systemClasses () : string {

    return self::system() . DirNames::CLASSES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system procedural directory path.
   *
   * @static
   * @return string System procedural absolute directory path.
   */
  public static function systemProcedural () : string {

    return self::system() . DirNames::PROCEDURAL . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system views directory path.
   *
   * @static
   * @return string System views absolute directory path.
   */
  public static function systemViews () : string {

    return self::system() . DirNames::VIEWS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system files directory path.
   *
   * @static
   * @return string System files absolute directory path.
   */
  public static function systemViewsFiles () : string {

    return self::systemViews() . DirNames::FILES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system helpers directory path.
   *
   * @static
   * @return string System helpers absolute directory path.
   */
  public static function systemViewsHelpers () : string {

    return self::systemViews() . DirNames::HELPERS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system images directory path.
   *
   * @static
   * @return string System images absolute directory path.
   */
  public static function systemViewsImages () : string {

    return self::systemViews() . DirNames::IMAGES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system styles directory path.
   *
   * @static
   * @return string System styles absolute directory path.
   */
  public static function systemViewsStyles () : string {

    return self::systemViews() . DirNames::STYLES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the system scripts directory path.
   *
   * @static
   * @return string System scripts absolute directory path.
   */
  public static function systemViewsScripts () {

    return self::systemViews() . DirNames::SCRIPTS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site config directory path.
   *
   * @static
   * @return string Site config absolute directory path.
   */
  public static function siteConfig () : string {

    return self::site() . DirNames::CONFIG . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site locale directory path.
   *
   * @static
   * @return string Site locale absolute directory path.
   */
  public static function siteLocale () : string {

    return self::site() . DirNames::LOCALE . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site classes directory path.
   *
   * @static
   * @return string Site classes absolute directory path.
   */
  public static function siteClasses () : string {

    return self::site() . DirNames::CLASSES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the site procedural directory path.
   *
   * @static
   * @return string site procedural absolute directory path.
   */
  public static function siteProcedural () : string {

    return self::site() . DirNames::PROCEDURAL . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the site directory path.
   *
   * @static
   * @return string Site absolute directory path.
   */
  public static function site () : string {

    return self::humm() . DirNames::SITES .\DIRECTORY_SEPARATOR .
     UserSites::siteDirName() . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a user site directory path.
   *
   * @static
   * @return string User site absolute directory path.
   */
  public static function siteViews () : string {

    return self::site() . DirNames::VIEWS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site files directory path.
   *
   * @static
   * @return string Site files absolute directory path.
   */
  public static function siteViewsFiles () : string {

    return self::siteViews() . DirNames::FILES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site helpers directory path.
   *
   * @static
   * @return string Site helpers absolute directory path.
   */
  public static function siteViewsHelpers () : string {

    return self::siteViews() . DirNames::HELPERS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site images directory path.
   *
   * @static
   * @return string Site images absolute directory path.
   */
  public static function siteViewsImages () : string {

    return self::siteViews() . DirNames::IMAGES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site scripts directory path.
   *
   * @static
   * @return string Site scripts absolute directory path.
   */
  public static function siteViewsScripts () : string {

    return self::siteViews() . DirNames::SCRIPTS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve a site styles directory path.
   *
   * @static
   * @return string Site styles absolute directory path.
   */
  public static function siteViewsStyles () : string {

    return self::siteViews() . DirNames::STYLES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared directory path.
   *
   * @static
   * @return string Sites shared absolute directory path.
   */
  public static function sitesShared () : string {

    return self::humm() . DirNames::SITES . \DIRECTORY_SEPARATOR.
            DirNames::SHARED . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared locale directory path.
   *
   * @static
   * @return string Sites shared locale absolute directory path.
   */
  public static function sitesSharedLocale () : string {

    return self::sitesShared() . DirNames::LOCALE . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared classes directory path.
   *
   * @static
   * @return string Sites shared classes absolute directory path.
   */
  public static function sitesSharedClasses () : string {

    return self::sitesShared() . DirNames::CLASSES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared procedural directory path.
   *
   * @static
   * @return string Sites shared procedural absolute directory path.
   */
  public static function sitesSharedProcedural () : string {

    return self::sitesShared() . DirNames::PROCEDURAL . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared views directory path.
   *
   * @static
   * @return string Sites shared views absolute directory path.
   */
  public static function sitesSharedViews () : string {

    return self::sitesShared() . DirNames::VIEWS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared files directory path.
   *
   * @static
   * @return string Sites shared files absolute directory path.
   */
  public static function sitesSharedViewsFiles () : string {

    return self::sitesSharedViews() . DirNames::FILES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared helpers directory path.
   *
   * @static
   * @return string Sites shared helpers absolute directory path.
   */
  public static function sitesSharedViewsHelpers () : string {

    return self::sitesSharedViews() . DirNames::HELPERS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared images directory path.
   *
   * @static
   * @return string Sites shared images absolute directory path.
   */
  public static function sitesSharedViewsImages () : string {

    return self::sitesSharedViews() . DirNames::IMAGES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared styles directory path.
   *
   * @static
   * @return string Sites shared styles absolute directory path.
   */
  public static function sitesSharedViewsStyles () : string {

    return self::sitesSharedViews() . DirNames::STYLES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the sites shared scripts directory path.
   *
   * @static
   * @return string Sites shared scripts absolute directory path.
   */
  public static function sitesSharedViewsScripts () : string {

    return self::sitesSharedViews() . DirNames::SCRIPTS . \DIRECTORY_SEPARATOR;
  }
}
