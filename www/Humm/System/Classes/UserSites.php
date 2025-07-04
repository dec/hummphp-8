<?php

/**
 * This file implement the UserSites system class.
 *
 * This class made possible the Humm PHP multisites
 * support, discovering and preparing the appropiate
 * information about the site currently used.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System UserSites class implementation.
 *
 * Altough this class is mainly for internal use by other
 * Humm PHP system classes, contain public methos which may
 * can be useful too for site classes, views and plugins.
 */
class UserSites extends Unclonable {

  /**
   * Define an specific view class of the current site.
   */
  private const VIEW_CLASS = 'Humm\Sites\%s\Classes\%s%s';

  /**
   * Define the optional site shared view class.
   */
  private const SHARED_VIEW_CLASS = 'Humm\Sites\%s\Classes\SharedView';

  /**
   * Store the current site directory name.
   *
   * @var string
   */
  private static string $dir_name = '';

  /**
   * Initialize some class members.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      self::$dir_name = self::siteDirFromUrl();

      if (!self::siteDirExists(self::$dir_name)) {

        self::$dir_name = DirNames::MAIN_SITE;
      }
    }
  }

  /**
   * Retrieve the current site directory name.
   *
   * @static
   * @return string Current site directory name.
   */
  public static function siteDirName () : string {

    return self::$dir_name;
  }

  /**
   * Retrieve the current site config directory URL relative path.
   *
   * @static
   * @return string Current site config directory URL relative path.
   */
  public static function configUrlPath () : string {

    return \sprintf(SitePaths::CONFIG_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site locale directory URL relative path.
   *
   * @static
   * @return string Current site locale directory URL relative path.
   */
  public static function localeUrlPath () : string {

    return \sprintf(SitePaths::LOCALE_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site classes directory URL relative path.
   *
   * @static
   * @return string Current site classes directory URL relative path.
   */
  public static function classesUrlPath () : string {

    return \sprintf(SitePaths::CLASSES_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site procedural directory URL relative path.
   *
   * @static
   * @return string Current site procedural directory URL relative path.
   */
  public static function proceduralUrlPath () : string {

    return \sprintf(SitePaths::PROCEDURAL_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site views URL relative path.
   *
   * @static
   * @return string Current site views URL relative path.
   */
  public static function viewsUrlPath () : string {

    return \sprintf(SitePaths::VIEWS_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site views files URL relative path.
   *
   * @static
   * @return string Current site views files URL relative path.
   */
  public static function viewsFilesUrlPath () : string {

    return \sprintf(SitePaths::VIEWS_FILES_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site views images URL relative path.
   *
   * @static
   * @return string Current site views images URL relative path.
   */
  public static function viewsImagesUrlPath () : string {

    return \sprintf(SitePaths::VIEWS_IMAGES_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site views styles URL relative path.
   *
   * @static
   * @return string Current site views styles URL relative path.
   */
  public static function viewsStylesUrlPath () : string {

    return \sprintf(SitePaths::VIEWS_STYLES_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve the current site views scripts URL relative path.
   *
   * @static
   * @return string Current site views scripts URL relative path.
   */
  public static function viewsScriptsUrlPath () : string {

    return \sprintf(SitePaths::VIEWS_SCRIPTS_URL_PATH, self::$dir_name);
  }

  /**
   * Retrieve a current site view class name.
   *
   * @static
   * @param string $view_name Site view name.
   * @return string Current site view class name.
   */
  public static function viewClassName (string $view_name) : string {

    return \sprintf(self::VIEW_CLASS, self::$dir_name,
            $view_name, ViewsHandler::VIEW_CLASS_SUFFIX);
  }

  /**
   * Get the optional site shared view class name.
   *
   * @static
   * @return string Optional site shared view class name.
   */
  public static function sharedViewClassName () : string {

    return \sprintf(self::SHARED_VIEW_CLASS, self::$dir_name);
  }

  /**
   * Retrieve the expected user site from the server URL.
   *
   * Note this function can determine the right site directory
   * from the server URL including possible subdomains and also
   * complete numeric domains or domain which start by a number.
   *
   * From an URL like this:
   *
   * http://www.mysite.com/
   *
   * The site directory are "Mysite".
   *
   * From an URL like this:
   *
   * http://www.subdomain.mysite.com/
   *
   * The site directory are "SubdomainMysite".
   *
   * For an URL like this:
   *
   * http://www.1001.com/
   *
   * The site directory are "Onzezeon".
   *
   * For an URL like this:
   *
   * http://www.10abc.com/
   *
   * The site directory are "Onzeabc".
   *
   * For an URL like this:
   *
   * http://www.abc10.com/
   *
   * The site directory are "Abc10".
   *
   * @static
   * @return string The found site directory name.
   */
  private static function siteDirFromUrl () : string {

    $matches = [];
    $siteDir = StrUtils::EMPTY_STRING;
    $serverUrl = self::sanitizedServerUrl();
    \preg_match_all('#(.+)\.(.+)#', $serverUrl, $matches);

    if (isset($matches[1]) && isset($matches[1][0])) {

      $siteDir = self::siteDirFromUrlMatches($matches);
    }

    return $siteDir;
  }

  /**
   * Just a helper function for siteDirFromUrl.
   *
   * @static
   * @see self::siteDirFromUrl()
   * @param array $matches Domain parts found in the URL.
   * @return string Site directory name based in the URL.
   */
  private static function siteDirFromUrlMatches (array $matches) : string {

    $site_dir_path = StrUtils::EMPTY_STRING;

    foreach(\explode(StrUtils::DOT, $matches[1][0]) as $dir_part) {

      if (\is_numeric($dir_part[0]) || \is_numeric($dir_part)) {

        $site_dir_path .= \ucfirst(self::numToChars($dir_part));

      } else {

        $site_dir_path .= \ucfirst($dir_part);
      }
    }

    return $site_dir_path;
  }

  /**
   * Sanitize the server URL removing protocol and www.
   *
   * @static
   * @return string Sanitized server URL.
   */
  private static function sanitizedServerUrl () : string {

    return \str_replace(
      ['http://', 'https://', 'www.'],
      StrUtils::EMPTY_STRING,
      ServerInfo::url());
  }

  /**
   * Find if a site directory name exists.
   *
   * @static
   * @param string $site_dir_name Site directory name
   * @return bool True if directory exists, False if not
   */
  private static function siteDirExists (string $site_dir_name) : bool {

    return !StrUtils::isTrimEmpty($site_dir_name) &&
             \is_dir(DirPaths::humm() . DirNames::SITES . \DIRECTORY_SEPARATOR . $site_dir_name);
  }

  /**
   * Get an string representation of a number.
   *
   * @static
   * @param int $number The number to be converted
   * @return string The entered number as chars
   */
  private static function numToChars (int $number) : string {

    $result = '';
    $string = (string)$number;
    $str_len = \strlen($string);

    for ($i = 0; $i < $str_len; $i++) {

      switch ($string[$i]) {

        case '0': $result .= 'ze'; break;
        case '1': $result .= 'on'; break;
        case '2': $result .= 'tw'; break;
        case '3': $result .= 'th'; break;
        case '4': $result .= 'fo'; break;
        case '5': $result .= 'fi'; break;
        case '6': $result .= 'si'; break;
        case '7': $result .= 'se'; break;
        case '8': $result .= 'ei'; break;
        case '9': $result .= 'ni'; break;

        default: $result .= $string[$i]; break;
      }
    }

    return $result;
  }
}
