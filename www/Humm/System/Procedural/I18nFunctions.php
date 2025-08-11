<?php

/**
 * This file implement the short I18n functions.
 *
 * Instead of use the Languages system class to translate string
 * we implement here (into the global namespace) convenient and
 * short I18n functions for string translation.
 *
 * This file is required by the system Languages class when
 * it's initialized in order to put this functions availables.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

use
  \Humm\System\Classes\Languages;

/**
 * Get an string translation or the original one.
 *
 * @param string $message String to be translated.
 * @param string $text_domain Optional messages text domain.
 * @return string Translated or untouched string.
 */
function t (string $message, string $text_domain = Languages::DEFAULT_DOMAIN) : string {

  return Languages::translate($message, $text_domain);
}

/**
 * Print a string translation or the original one.
 *
 * @param string $message String to be translated.
 * @param string $text_domain Optional messages text domain.
 */
function e (string $message, string $text_domain = Languages::DEFAULT_DOMAIN) : void {

  echo Languages::translate($message, $text_domain);
}

/**
 * Get a singular or plural translation or the original string.
 *
 * @param string $singular Singular version of the message.
 * @param string $plural Plural version of the message.
 * @param int $count Number which determine what version use.
 * @param string $text_domain Optional messages text domain.
 * @return string Translated or untouched singular or plural version.
 */
function n (string $singular, string $plural, int $count, string $text_domain = Languages::DEFAULT_DOMAIN) : string {

  return Languages::nTranslate($singular, $plural, $count, $text_domain);
}

/**
 * Print a singular or plural translation or the original string.
 *
 * @param string $singular Singular version of the message.
 * @param string $plural Plural version of the message.
 * @param int $count Number which determine what version use.
 * @param string $text_domain Optional messages text domain.
 */
function ne (string $singular, string $plural, int $count, string $text_domain = Languages::DEFAULT_DOMAIN) : void {

  echo Languages::nTranslate($singular, $plural, $count, $text_domain);
}
