<?php

/**
 * This file implement the ServerInfo system class.
 *
 * This class provide information about the server in
 * which Humm PHP is executed.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System ServerInfo class implementation.
 *
 * This class is internally used by the system and their
 * stuff can also be useful for user sites.
 *
 */
final class ServerInfo extends Unclonable {

  /**
   * Define the localhost IP address.
   */
  private const LOCALHOST_ADDRESS = '127.0.0.1';

  /**
   * Store the server root URL.
   *
   * @var string
   */
  private static string $url = '';

  /**
   * Retrieve the current server URI.
   *
   * @static
   * @return string Current server URI.
   */
  public static function uri () : string {

    return UserInput::server('REQUEST_URI');
  }

  /**
   * Retrieve the server script name.
   *
   * @static
   * @return string Current server script name.
   */
  public static function script () : string {

    return UserInput::server('SCRIPT_NAME');
  }

  /**
   * Retrieve the server document root path.
   *
   * @static
   * @return string Current server document root path.
   */
  public static function docRoot () : string {

    return UserInput::server('DOCUMENT_ROOT');
  }

  /**
   * Find if the server is a localhost or not.
   *
   * @static
   * @return bool True if the server is local, False if not.
   */
  public static function isLocal () : bool {

    return UserInput::server('SERVER_ADDR') === self::LOCALHOST_ADDRESS;
  }

  /**
   * Retrieve the server root URL.
   *
   * @static
   * @return string Server root URL.
   */
  public static function url () : string {

    if (self::$url === '') {

      $protocol = 'http';

      if (UserInput::server('HTTPS') !== null && UserInput::server('HTTPS') !== 'off') {
        $protocol .= 's';
      }

      self::$url = \sprintf('%s://%s', $protocol, UserInput::server('SERVER_NAME'));
    }

    return self::$url;
  }
}
