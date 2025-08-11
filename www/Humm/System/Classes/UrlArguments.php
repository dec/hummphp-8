<?php

/**
 * This file implement the UrlArguments system class.
 *
 * This class extract from the current URL the user request
 * arguments in order to provide the right response.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System UrlArguments class implementation.
 *
 * Humm PHP do not use any MOD REWRITE module, since
 * is desined to be completely server independent.
 *
 * However Humm PHP offers to the users friendly URLs
 * using arguments from the user request URL.
 *
 * Here are samples of Humm PHP managed sites URLs:
 *
 * http://www.yoursite.com/
 *
 * This URL have no arguments and therefore the
 * system shown to the user the default Home view.
 *
 * http://www.yoursite.com/?contact
 *
 * The above URL contain one argument from the system
 * point of view. The argument is "contact" and then
 * the system looking for a view named "Contact", and,
 * if found, display it to the user.
 *
 * http://www.yoursite.com/?search/page/10
 *
 * The above URL contains three arguments from the system
 * point of view. The first argument always determine the
 * view to shown the user so in this case the system try
 * to prepare a "Search" view to be displayed.
 *
 * The URL contains also two more arguments: "page" and
 * "10", which can therefore used by the "Search" view and
 * more propertly in the associated view class in order to
 * provide the right response to that URL request.
 *
 * Optionally, you can use a "rewrite module", for example,
 * the Apache rewrite module, adding an ".htaccess" file
 * with a content like this:
 *
 * RewriteCond %{REQUEST_FILENAME} !-f
 * RewriteCond %{REQUEST_FILENAME} !-d
 * RewriteRule ^.*$ index.php
 *
 * Put the file in your Humm root installation directory,
 * and then, Humm PHP automatically recognize and deal
 * with URL like these:
 *
 * http://www.yoursite.com/contact
 *
 * http://www.yoursite.com/search/page/10
 *
 * Everything works like expected in this case: the same
 * URL arguments, arguments count, etc.
 *
 */
final class UrlArguments extends Unclonable {

  /**
   * Define the chars to be trimmed from the current URI.
   */
  private const URI_TRIMMING_CHARS = '?/';

  /**
   * Request URL arguments.
   *
   * @var array
   */
  private static array $arguments = [];

  /**
   * Parse the current URI to extract the arguments.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;
      self::$arguments = [];

      $uri = self::sanitizedUri();

      if (!StrUtils::isTrimEmpty($uri)) {

        self::$arguments = \explode(StrUtils::URL_SEPARATOR, $uri);
      }
    }
  }

  /**
   * Retrieve the total arguments count.
   *
   * @static
   * @return int Arguments count.
   */
  public static function count () : int {

    return \count(self::$arguments);
  }

  /**
   * Retrieve all the arguments list.
   *
   * @static
   * @return array List of arguments.
   */
  public static function getAll () : array {

    return self::$arguments;
  }

  /**
   * Get an specific argument by their index.
   *
   * @static
   * @param int $arg_index Argument index to be retrieved.
   * @return ?string URL argument or null if not found.
   */
  public static function get (int $arg_index) : ?string {

    $result = null;

    if (isset(self::$arguments[$arg_index])) {
      $result = self::$arguments[$arg_index];
    }

    return $result;
  }

  /**
   * Sanitize the current URI for easy arguments extraction.
   *
   * @static
   * @return string Current URI well sanitized.
   */
  private static function sanitizedUri () : string {

    // This objective of the normalized uri is to allow Humm PHP
    // installation in root but also any level of subdirectories,
    // then we need to avoid to picking subdirs as URL arguments.

    $sanitized_root_dir_path = \str_replace(\DIRECTORY_SEPARATOR, '/', DirPaths::root());

    $normalized_uri = \str_replace(ServerInfo::docRoot(), '', $sanitized_root_dir_path);

    // Find in certain Linux server with subdomain working inside a Windows WM machine (rare to me)
    if ($normalized_uri === $sanitized_root_dir_path) {

      $normalized_uri = \str_replace(\dirname(UserInput::server('SCRIPT_NAME')), '', ServerInfo::uri());
    // The below one is the path works in Windows and Linux, including subdomains in both systems

    } else if (($normalized_uri !== '') && ($normalized_uri !== '/')) {

      $normalized_uri = \str_replace($normalized_uri, '', ServerInfo::uri());
      // This fallback has been tested too in Windows and Linux, including subdomains, but
      // do not work if $normalized_uri and $sanitized_root_dir_path are equals

    } else {

      $normalized_uri = ServerInfo::uri();
    }

    return \trim($normalized_uri, self::URI_TRIMMING_CHARS);
  }
}
