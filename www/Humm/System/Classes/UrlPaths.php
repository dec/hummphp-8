<?php

/**
 * This file implement the UrlPaths system class.
 *
 * This class is intended to offer a convenient way
 * to deal with system and user site URLs.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System UrlPaths class implementation.
 *
 * Provide stuff to work with system and user site URLs like
 * what is the root URL for the Humm PHP place and others.
 *
 */
class UrlPaths extends Unclonable {

  /**
   * Root URL in which Humm PHP reside.
   *
   * @var string
   */
  private static string $root = '';

  /**
   * Retrieve the root URL in which Humm PHP reside.
   *
   * We can use this method to get the root URL (which
   * corresponde with the site home) and conform other
   * site URLs from the root URL.
   *
   * @static
   * @return string Root URL for the Humm copy.
   */
  public static function root () : string
  {
    if (self::$root === '') {

      self::$root = ServerInfo::url() . \str_replace(FileNames::PHP_INDEX, StrUtils::EMPTY_STRING, ServerInfo::script());
    }

    return self::$root;
  }

  /**
   * Retrieve the current request URL.
   *
   * @static
   * @return string Current request URL.
   */
  public static function current () : string {

    return ServerInfo::url() . ServerInfo::uri();
  }

  /**
   * Get an absolute Humm PHP URL from a relative path.
   *
   * @static
   * @param string $relative_url_path URL path to be appended to the root URL.
   * @param string $end URL part to be appended to the final URL.
   * @return string Absolute URL pointing to the provided path.
   */
  public static function path (string $relative_url_path) : string {

    return self::root() . $relative_url_path;
  }

  /**
   * Retrieve the URL for the system directory.
   *
   * @return string URL for the system directory.
   */
  public static function system () : string {

    return self::path(DirNames::HUMM . StrUtils::URL_SEPARATOR.
            DirNames::SYSTEM . StrUtils::URL_SEPARATOR);
  }

  /**
   * Retrieve the URL for the system config directory.
   *
   * @return string URL for the system config directory.
   */
  public static function systemConfig () : string {

    return self::system() . DirNames::CONFIG . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system locale directory.
   *
   * @return string URL for the system locale directory.
   */
  public static function systemLocale () : string {

    return self::system() . DirNames::LOCALE . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system classes directory.
   *
   * @return string URL for the system classes directory.
   */
  public static function systemClasses () : string {

    return self::system() . DirNames::CLASSES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system version directory.
   *
   * @return string URL for the system version directory.
   */
  public static function systemVersion () : string {

    return self::system() . DirNames::VERSION . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system procedural directory.
   *
   * @return string URL for the system procedural directory.
   */
  public static function systemProcedural () : string {

    return self::system() . DirNames::PROCEDURAL . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system views directory.
   *
   * @return string URL for the system views directory.
   */
  public static function systemViews () : string {

    return self::system() . DirNames::VIEWS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system views files directory.
   *
   * @return string URL for the system views files directory.
   */
  public static function systemViewsFiles () : string {

    return self::systemViews() . DirNames::FILES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system views helpers directory.
   *
   * @return string URL for the system views helpers directory.
   */
  public static function systemViewsHelpers () : string {

    return self::systemViews() . DirNames::HELPERS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system views images directory.
   *
   * @return string URL for the system views images directory.
   */
  public static function systemViewsImages () : string {

    return self::systemViews() . DirNames::IMAGES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system views styles directory.
   *
   * @return string URL for the system views styles directory.
   */
  public static function systemViewsStyles () : string {

    return self::systemViews() . DirNames::STYLES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the system views scripts directory.
   *
   * @return string URL for the system views scripts directory.
   */
  public static function systemViewsScripts () : string {

    return self::systemViews() . DirNames::SCRIPTS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the site classes directory.
   *
   * @return string URL for the site classes directory.
   */
  public static function siteClasses () : string {

    return self::path(UserSites::classesUrlPath());
  }

  /**
   * Retrieve the URL for the site procedural directory.
   *
   * @return string URL for the site procedural directory.
   */
  public static function siteProcedural () : string {

    return self::path(UserSites::proceduralUrlPath());
  }

  /**
   * Retrieve the URL for the site config directory.
   *
   * @return string URL for the site config directory.
   */
  public static function siteConfig () : string {

    return self::path(UserSites::configUrlPath());
  }

  /**
   * Retrieve the URL for the site views directory.
   *
   * @return string URL for the site views directory.
   */
  public static function siteViews () : string {

    return self::path(UserSites::viewsUrlPath());
  }

  /**
   * Retrieve the URL for the site views files directory.
   *
   * @return string URL for the site views files directory.
   */
  public static function siteViewsFiles () : string {

    return self::path(UserSites::viewsFilesUrlPath());
  }

  /**
   * Retrieve the URL for the site views images directory.
   *
   * @return string URL for the site views images directory.
   */
  public static function siteViewsImages () : string {

    return self::path(UserSites::viewsImagesUrlPath());
  }

  /**
   * Retrieve the URL for the site views styles directory.
   *
   * @return string URL for the site views styles directory.
   */
  public static function siteViewsStyles () : string {

    return self::path(UserSites::viewsStylesUrlPath());
  }

  /**
   * Retrieve the URL for the site views scripts directory.
   *
   * @return string URL for the site views scripts directory.
   */
  public static function siteViewsScripts () : string {

    return self::path(UserSites::viewsScriptsUrlPath());
  }

  /**
   * Retrieve the URL for the sites shared directory.
   *
   * @return string URL for the sites shared directory.
   */
  public static function sitesShared () : string {

    return self::path(DirNames::HUMM . StrUtils::URL_SEPARATOR . DirNames::SITES .
     StrUtils::URL_SEPARATOR . DirNames::SHARED . StrUtils::URL_SEPARATOR);
  }

  /**
   * Retrieve the URL for the sites shared locale directory.
   *
   * @return string URL for the sites shared locale directory.
   */
  public static function sitesSharedLocale () : string {

    return self::sitesShared() . DirNames::LOCALE . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared classes directory.
   *
   * @return string URL for the sites shared classes directory.
   */
  public static function sitesSharedClasses () : string {

    return self::sitesShared() . DirNames::CLASSES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared procedural directory.
   *
   * @return string URL for the sites shared procedural directory.
   */
  public static function sitesSharedProcedural () : string {

    return self::sitesShared() . DirNames::PROCEDURAL . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared views directory.
   *
   * @return string URL for the sites shared views directory.
   */
  public static function sitesSharedViews () : string {

    return self::sitesShared() . DirNames::VIEWS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared views files directory.
   *
   * @return string URL for the sites shared views files directory.
   */
  public static function sitesSharedViewsFiles () : string {

    return self::sitesSharedViews() . DirNames::FILES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared views helpers directory.
   *
   * @return string URL for the sites shared views helpers directory.
   */
  public static function sitesSharedViewsHelpers () : string {

    return self::sitesSharedViews() . DirNames::HELPERS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared views images directory.
   *
   * @return string URL for the sites shared views images directory.
   */
  public static function sitesSharedViewsImages () : string {

    return self::sitesSharedViews() . DirNames::IMAGES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared views styles directory.
   *
   * @return string URL for the sites shared views styles directory.
   */
  public static function sitesSharedViewsStyles () : string {

    return self::sitesSharedViews() . DirNames::STYLES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the URL for the sites shared views scripts directory.
   *
   * @return string URL for the sites shared views scripts directory.
   */
  public static function sitesSharedViewsScripts () : string {

    return self::sitesSharedViews() . DirNames::SCRIPTS . StrUtils::URL_SEPARATOR;
  }
}
