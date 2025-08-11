<?php

/**
 * This file implement the Localization system class.
 *
 * This class offer a way to works with locale data like
 * months and days in a convenient way.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System Localization class implementation.
 *
 * System and user site can use this class to works
 * with locale data, for example, retrieving month
 * and day names well localized.
 */
final class Localization extends Unclonable {

  /**
   * Locale data information.
   *
   * @var array
   */
  private static $map = [];

  /**
   * Store the locale data information.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      self::$map = LocalizationMap::getMap();
    }
  }

  /**
   * Retrieve a localized day name (english by default).
   *
   * @static
   * @param int $day_number Day number.
   * @return ?string Localized day name or null.
   */
  public static function getDayName (int $day_number) : ?string {

    if (isset(self::$map[LocalizationMap::DAYS][$day_number])) {
      return self::$map[LocalizationMap::DAYS][$day_number];
    }

    return null;
  }

  /**
   * Retrieve localized day names (english by default).
   *
   * @static
   * @return ?array Localized day names or null.
   */
  public static function getDayNames () : ?array {

    if (isset(self::$map[LocalizationMap::DAYS])) {
      return self::$map[LocalizationMap::DAYS];
    }

    return null;
  }

  /**
   * Retrieve a localized day abbreviation (english by default).
   *
   * @static
   * @param int $day_name Localized day name.
   * @return ?string Localized day abbreviation.
   */
  public static function getDayAbbr (string $day_name) : ?string {

    if (isset(self::$map[LocalizationMap::DAYS_ABBR][$day_name])) {
      return self::$map[LocalizationMap::DAYS_ABBR][$day_name];
    }

    return null;
  }

  /**
   * Retrieve a localized day initial (english by default).
   *
   * @static
   * @param int $day_name Localized day name.
   * @return ?string Localized day initial.
   */
  public static function getDayInitial (string $day_name) : ?string {

    if (isset(self::$map[LocalizationMap::DAYS_INIT][$day_name])) {
      return self::$map[LocalizationMap::DAYS_INIT][$day_name];
    }

    return null;
  }

  /**
   * Retrieve localized month names (english by default).
   *
   * @static
   * @return array Localized month names or null.
   */
  public static function getMonthNames () : ?array {

    if (isset(self::$map[LocalizationMap::MONTHS])) {
      return self::$map[LocalizationMap::MONTHS];
    }

    return null;
  }

  /**
   * Retrieve a localized month name (english by default).
   *
   * @static
   * @param int $month_number Month number.
   * @return ?string Localized month name.
   */
  public static function getMonthName (int $month_number) : ?string {

    if (isset(self::$map[LocalizationMap::MONTHS][$month_number])) {
      return self::$map[LocalizationMap::MONTHS][$month_number];
    }

    return null;
  }

  /**
   * Retrieve a localized month abbreviation.
   *
   * @static
   * @param int $month_number Month number.
   * @return ?string Localized month abbreviation or null.
   */
  public static function getMonthAbbr ($month_number) : ?string {

    if (isset(self::$map[LocalizationMap::MONTHS_ABBR][$month_number])) {
      return self::$map[LocalizationMap::MONTHS_ABBR][$month_number];
    }

    return null;
  }

  /**
   * Retrieve a localized meridiem.
   *
   * The meridiem param can be one of the Localization::MERIDIEM_* constants.
   *
   * @static
   * @param string $meridiem English lower or uppercase meridiam.
   * @return ?string Localized meridiam.
   */
  public static function getMeridiem ($meridiem) : ?string {

    if (isset(self::$map[LocalizationMap::MERIDIAMS][$meridiem])) {
      return self::$map[LocalizationMap::MERIDIAMS][$meridiem];
    }

    return null;
  }
}
