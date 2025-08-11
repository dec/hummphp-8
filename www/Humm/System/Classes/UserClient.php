<?php

/**
 * This file implement the UserClient system class.
 *
 * This class is intended to offer a convenient way
 * to get information about the current user client.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System UserClient class implementation.
 *
 * This class can be used by both system and user site
 * in order to retrieve information of the user client.
 *
 */
final class UserClient extends Unclonable {

  /**
   * Store the user client IP address.
   *
   * @var ?string
   */
  private static ?string $ip_address = null;

  /**
   * Redirect the user to certain URL.
   *
   * This method exit the script execution
   * after the redirection is performed.
   *
   * @static
   * @param string $url To redirecting.
   */
  public static function redirectTo (string $url) : void {

    \header("Location: {$url}");
    exit;
  }

  /**
   * Redirect the user to the current site home.
   *
   * @static
   */
  public static function redirectToHome () : void {

    self::redirectTo(UrlPaths::root());
  }

  /**
   * Retrieve the user client two language code.
   *
   * @static
   * @return string User client two letters language code.
   */
  public static function language () : string {

    return \substr(UserInput::server(
     'HTTP_ACCEPT_LANGUAGE', \HUMM_LANGUAGE), 0, 2);
  }

  /**
   * Retrieve the user client IP address.
   *
   * @static
   * @return string User client IP address.
   */
  public static function ipAddress () : string {

    if (self::$ip_address === null) {

      self::$ip_address = StrUtils::EMPTY_STRING;

      if (UserInput::server('REMOTE_ADDR') !== null) {

        self::$ip_address = UserInput::server('REMOTE_ADDR');

      } else if (UserInput::server('HTTP_CLIENT_IP') !== null) {

        self::$ip_address = UserInput::server('HTTP_CLIENT_IP');

      } else if (UserInput::server('HTTP_X_FORWARDED_FOR') !== null) {

        self::$ip_address = UserInput::server('HTTP_X_FORWARDED_FOR');

      } else if (UserInput::server('HTTP_VIA') !== null) {

        self::$ip_address = UserInput::server('HTTP_VIA');
      }
    }

    return self::$ip_address;
  }
}
