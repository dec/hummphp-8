<?php

/**
 * This file implement the LanguagesMap system class.
 *
 * This class offer an ISO_639-1 language codes/names map,
 * look for the available language codes and provide other
 * useful stuff internally used by the Language class.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System LanguagesMap class implementation.
 *
 * This is a system class internally used from the
 * system Languages class and user site stuff do not
 * need to use it directly.
 */
class LanguagesMap extends Unclonable {

  /**
   * Available language codes/names.
   *
   * @var array
   */
  private static array $map = [];

  /**
   * Available language codes.
   *
   * @var array
   */
  private static array $codes = [];

  /**
   * RTL language codes/names.
   *
   * @var array
   */
  private static array $rtl_map = [];

  /**
   * Retrieve the available language codes.
   *
   * @static
   * @return array Available language codes.
   */
  public static function getCodes () : array {

    if (empty(self::$codes)) {

      self::$codes = self::getSiteLocaleDirNames();

      if (!in_array(\HUMM_LANGUAGE, self::$codes)) {

        self::$codes[] = \HUMM_LANGUAGE;
      }
    }

    return self::$codes;
  }

  /**
   * List with the available language codes/names.
   *
   * @static
   * @link http://en.wikipedia.org/wiki/ISO_639-1
   * @return array ISO_639-1 language codes/names.
   */
  public static function getMap () : array {

    if (empty(self::$map)) {

      $map = [
        'en' => 'English',
        'aa' => 'Afar',
        'ab' => 'Abkhazian',
        'af' => 'Afrikaans',
        'am' => 'Amharic',
        'ar' => 'Arabic',
        'as' => 'Assamese',
        'ay' => 'Aymara',
        'az' => 'Azerbaijani',
        'ba' => 'Bashkir',
        'be' => 'Byelorussian',
        'bg' => 'Bulgarian',
        'bh' => 'Bihari',
        'bi' => 'Bislama',
        'bn' => 'Bengali/Bangla',
        'bo' => 'Tibetan',
        'br' => 'Breton',
        'ca' => 'Catalan',
        'co' => 'Corsican',
        'cs' => 'Czech',
        'cy' => 'Welsh',
        'da' => 'Danish',
        'de' => 'German',
        'dz' => 'Bhutani',
        'el' => 'Greek',
        'eo' => 'Esperanto',
        'es' => 'Español',
        'et' => 'Estonian',
        'eu' => 'Basque',
        'fa' => 'Persian',
        'fi' => 'Finnish',
        'fj' => 'Fiji',
        'fo' => 'Faeroese',
        'fr' => 'French',
        'fy' => 'Frisian',
        'ga' => 'Irish',
        'gd' => 'Scots/Gaelic',
        'gl' => 'Galician',
        'gn' => 'Guarani',
        'gu' => 'Gujarati',
        'ha' => 'Hausa',
        'hi' => 'Hindi',
        'hr' => 'Croatian',
        'hu' => 'Hungarian',
        'hy' => 'Armenian',
        'ia' => 'Interlingua',
        'ie' => 'Interlingue',
        'ik' => 'Inupiak',
        'in' => 'Indonesian',
        'is' => 'Icelandic',
        'it' => 'Italian',
        'iw' => 'Hebrew',
        'ja' => 'Japanese',
        'ji' => 'Yiddish',
        'jw' => 'Javanese',
        'ka' => 'Georgian',
        'kk' => 'Kazakh',
        'kl' => 'Greenlandic',
        'km' => 'Cambodian',
        'kn' => 'Kannada',
        'ko' => 'Korean',
        'ks' => 'Kashmiri',
        'ku' => 'Kurdish',
        'ky' => 'Kirghiz',
        'la' => 'Latin',
        'ln' => 'Lingala',
        'lo' => 'Laothian',
        'lt' => 'Lithuanian',
        'lv' => 'Latvian/Lettish',
        'mg' => 'Malagasy',
        'mi' => 'Maori',
        'mk' => 'Macedonian',
        'ml' => 'Malayalam',
        'mn' => 'Mongolian',
        'mo' => 'Moldavian',
        'mr' => 'Marathi',
        'ms' => 'Malay',
        'mt' => 'Maltese',
        'my' => 'Burmese',
        'na' => 'Nauru',
        'ne' => 'Nepali',
        'nl' => 'Dutch',
        'no' => 'Norwegian',
        'oc' => 'Occitan',
        'om' => '(Afan)/Oromoor/Oriya',
        'pa' => 'Punjabi',
        'pl' => 'Polish',
        'ps' => 'Pashto/Pushto',
        'pt' => 'Portuguese',
        'qu' => 'Quechua',
        'rm' => 'Rhaeto-Romance',
        'rn' => 'Kirundi',
        'ro' => 'Romanian',
        'ru' => 'Russian',
        'rw' => 'Kinyarwanda',
        'sa' => 'Sanskrit',
        'sd' => 'Sindhi',
        'sg' => 'Sangro',
        'sh' => 'Serbo-Croatian',
        'si' => 'Singhalese',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'sm' => 'Samoan',
        'sn' => 'Shona',
        'so' => 'Somali',
        'sq' => 'Albanian',
        'sr' => 'Serbian',
        'ss' => 'Siswati',
        'st' => 'Sesotho',
        'su' => 'Sundanese',
        'sv' => 'Swedish',
        'sw' => 'Swahili',
        'ta' => 'Tamil',
        'te' => 'Tegulu',
        'tg' => 'Tajik',
        'th' => 'Thai',
        'ti' => 'Tigrinya',
        'tk' => 'Turkmen',
        'tl' => 'Tagalog',
        'tn' => 'Setswana',
        'to' => 'Tonga',
        'tr' => 'Turkish',
        'ts' => 'Tsonga',
        'tt' => 'Tatar',
        'tw' => 'Twi',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'uz' => 'Uzbek',
        'vi' => 'Vietnamese',
        'vo' => 'Volapuk',
        'wo' => 'Wolof',
        'xh' => 'Xhosa',
        'yo' => 'Yoruba',
        'zh' => 'Chinese',
        'zu' => 'Zulu'
      ];

      foreach ($map as $code => $name) {

        if (\in_array($code, self::getCodes())) {

          self::$map[$code] = $name;
        }
      }

      \asort(self::$map);
    }

    return self::$map;
  }

  /**
   * Retrieve a map of RTL language codes/names.
   *
   * @static
   * @link http://en.wikipedia.org/wiki/Right-to-left
   * @return array RTL language codes/names.
   */
  public static function getRtlMap () : array {

    if (empty(self::$rtl_map)) {

      self::$rtl_map = [
        'ar'  => 'Arabic',
        'arc' => 'Aramaic',
        'bcc' => 'Southern Balochi',
        'bqi' => 'Bakthiari',
        'ckb' => 'Sorani',
        'dv'  => 'Dhivehi',
        'fa'  => 'Persian',
        'glk' => 'Gilaki',
        'he'  => 'Hebrew',
        'ku'  => 'Kurdish',
        'mzn' => 'Mazanderani',
        'pnb' => 'Western Punjabi',
        'ps'  => 'Pashto',
        'sd'  => 'Sindhi',
        'ug'  => 'Uyghur',
        'ur'  => 'Urdu',
        'yi'  => 'Yiddish'
      ];
    }

    return self::$rtl_map;
  }

  /**
   * Retrive the available site locale directory names.
   *
   * @static
   * @return array List of founded site locale directory names.
   */
  private static function getSiteLocaleDirNames () : array {

    $result = [];

    $siteLocaleDir = DirPaths::siteLocale();

    if (\file_exists($siteLocaleDir)) {

      foreach (new \DirectoryIterator($siteLocaleDir) as $file_info) {

        if (self::moFileExists($file_info)) {

          $result[] = $file_info->getBasename();
        }
      }
    }

    return $result;
  }

  /**
   * Find if a MO file exists or not.
   *
   * @static
   * @param \SplFileInfo $file_info File information.
   * @return bool True if the MO file exists, False if not
   */
  private static function moFileExists (\SplFileInfo $file_info) : bool {

    return $file_info->isDir() && \file_exists(self::getMOFilePath($file_info));
  }

  /**
   * Get an MO file absolute path.
   *
   * @static
   * @param \SplFileInfo $file_info File information.
   * @return string Absolute MO file path.
   */
  private static function getMOFilePath (\SplFileInfo $file_info) : string {

    return $file_info->getPath() . \DIRECTORY_SEPARATOR . $file_info->getBasename() .
            \DIRECTORY_SEPARATOR . $file_info->getBasename() . FileExts::DOT_MO;
  }
}
