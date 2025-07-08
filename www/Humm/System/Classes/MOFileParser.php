<?php

/**
 * This file implement the MOFileParser system class.
 *
 * This class are used by the system Languages to parse
 * text domain MO files and extract their string messages.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

use Closure;

/**
 * System MOFileParser class implementation.
 *
 * This class is intented to be used internally by the Languages
 * system class and user sites code do not need to use it.
 *
 * Credits for this class code go to Danilo Segan <danilo@kvota.net>
 * which writen it (if I am not wrong) for the PHP-Gettext project.
 */
final class MOFileParser extends Unclonable {

  /**
   * Extract the string messages from an MO file.
   *
   * @static
   * @param string $file_path MO file path.
   * @param string $text_domain Text domain in which store the messages.
   * @param array $messages Reference variable to store the messages.
   * @param ?object $plural_func_object Reference variable to store the plural function.
   * @return bool True on success, False on failure.
   */
  public static function parseFile (string $file_path, string $text_domain, array &$messages, ?object &$plural_func_object) : bool {

    $result = false;
    $file_data = self::getFileData($file_path);
    $file_header = self::getFileHeader($file_path, $file_data);

    if (($file_data !== null) && ($file_header !== null)) {

      self::fillMessages($file_data, $file_header, $text_domain, $messages);

      if (isset($messages[$text_domain]) && \count($messages[$text_domain]) > 0) {

        $result = true;
        $text_file_header = $messages[$text_domain][''][1][0];
        $plural_func_object = self::getPluralFunc($text_file_header);
      }
    }

    return $result;
  }

  /**
   * Retrieve the data of a MO file.
   *
   * This method also validate if the file data have the
   * appropiate "revision" and length.
   *
   * @static
   * @param string $file_path MO file path.
   * @return ?string File data on success or null in other case.
   */
  private static function getFileData (string $file_path) : ?string {

    $result = null;

    if (\is_readable($file_path) && \filesize($file_path) > 24) {

      $file_handle = \fopen($file_path, 'rb');
      $file_data = \fread($file_handle, \filesize($file_path));
      \fclose($file_handle);

      if (\strlen($file_data) >= 20) {
        $result = $file_data;
      }
    }

    return $result;
  }

  /**
   * Find if the MO file data is in little endian.
   *
   * @static
   * @param string $file_data MO file data.
   * @return bool True if data is little endian, False when not.
   */
  private static function isLittleEndian (string $file_data) : bool {

    $result = false;
    $unpack = \unpack('V1', \substr($file_data, 0, 4));

    $magic = isset($unpack[1]) ? $unpack[1] : false;

    switch ($magic & 0xFFFFFFFF) {

      case (int)0x950412de:
        $result = true;
        break;

      case (int)0xde120495:
        $result = false;
        break;
    }

    return $result;
  }

  /**
   * Get the header of a MO file.
   *
   * This method also validate the file header.
   *
   * @static
   * @param string $file_path MO file path.
   * @param string $file_data MO file data.
   * @return ?array Unpacked MO file header on success or null.
   */
  private static function getFileHeader (string $file_path, ?string $file_data) : ?array {

    $result = null;

    if ($file_data !== null) {

      $l = self::isLittleEndian($file_data) ? 'V' : 'N';

      $file_header = \unpack(
        "{$l}1msgcount/{$l}1msgblock/{$l}1transblock",
        \substr($file_data, 8, 12)
      );

      if (($file_header['msgblock'] + ($file_header['msgcount'] - 1) * 8) < \filesize($file_path)) {

        $result = $file_header;
      }
    }

    return $result;
  }

  /**
   * Retrieve the messages from a MO file.
   *
   * @static
   * @param string $file_data MO file data.
   * @param array $file_header Unpacked MO file header.
   * @param string $text_domain Text domain in which store the messages.
   * @param array $messages Reference variable to store the messages.
   */
  private static function fillMessages (?string $file_data, array $file_header, string $text_domain, array &$messages) : void {

    $l = self::isLittleEndian($file_data) ? 'V' : 'N';

    $lo = "{$l}1length/{$l}1offset";

    for ($msg_index = 0; $msg_index < $file_header['msgcount']; $msg_index++) {

      $msg_info = \unpack($lo, \substr($file_data,
       $file_header['msgblock'] + $msg_index * 8, 8));

      $msgids = \explode('\0', \substr($file_data,
       $msg_info['offset'], $msg_info['length']));

      $trans_info = \unpack($lo, \substr($file_data,
       $file_header['transblock'] + $msg_index * 8, 8));

      $trans_ids = \explode('\0', \substr($file_data,
       $trans_info['offset'], $trans_info['length']));

      $messages[$text_domain][$msgids[0]] = [$msgids, $trans_ids];
    }
  }

  /**
   * Find a MO file defined plurals function and get it.
   *
   * @static
   * @param string $text_file_header MO file header.
   * @param array $matches Reference for the matched strings.
   * @return bool True if a plural function is found, False if not.
   */
  private static function matchPluralFunc (string $text_file_header, array &$matches) : bool {

    return \preg_match('/plural-forms: (.*)/i', $text_file_header, $matches) &&
     \preg_match('/^\s*nplurals\s*=\s*(\d+)\s*;\s*plural=(.*)/', $matches[1], $matches);
  }

  /**
   * Retrieve the MO file defined plurals function.
   *
   * @static
   * @param string $text_file_header MO file header.
   * @return string MO file defined function or the default function.
   */
  private static function getPluralFunc (string $text_file_header) : mixed {

    $matches = [];

    $result = self::defaultPluralFunc();

    if (self::matchPluralFunc($text_file_header, $matches)) {

      $func_body = self::getPluralFuncBody($matches);

      $result = function ($n) use ($func_body) {
        return eval($func_body);
      };
    }

    return $result;
  }

  /**
   * Get the default plurals function.
   *
   * @static
   * @return Closure Plural function closure.
   */
  private static function defaultPluralFunc () : \Closure {

    return function ($n) {

      $nplurals = 2;
      $plural = ((int)$n === 1 ? 0 : 1);

      return ($plural >= $nplurals ? $nplurals - 1 : $plural);
    };
  }

  /**
   * Retrieve the plurals function from MO file matches.
   *
   * @static
   * @param array $matches Plurals function matches.
   * @return string Body for the plurals function.
   */
  private static function getPluralFuncBody (array $matches) : string {

    $nPlurals = \preg_replace('/[^0-9]/', '', $matches[1]);
    $plural = \preg_replace('/[^n0-9:\(\)\?\|\&=!<>+*\/\%\-]/','',$matches[2]);

    $func_body = \str_replace(
      ['plural', 'n', '$n$plurals'],
      ['$plural', '$n', '$nPlurals'],
      'nplurals=' . $nPlurals.'; plural=' . $plural);

    return self::fixPluralFuncBody($func_body) .
     'return ($plural >= $nPlurals ? $nPlurals - 1: $plural);';
  }

  /**
   * Fix the plural function body.
   *
   * @static
   * @param string $body func_body function body.
   * @return string Plural function body fixed.
   */
  private static function fixPluralFuncBody (string $func_body) : string {

    $p = 0;
    $res = '';
    $func_body .= ';';

    for ($i = 0; $i < \strlen($func_body); $i++) {

      switch ($func_body[$i]) {

        case '?':
          $res.= ' ? (';
          $p++;
          break;

        case ':':
          $res.= ') : (';
          break;

        case ';':
          $res.= \str_repeat(')', $p).';';
          $p = 0;
          break;

        default:
          $res.= $func_body[$i];
          break;
      }
    }

    return $res;
  }
}
