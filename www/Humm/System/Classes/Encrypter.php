<?php

/**
 * This file implement the Encrypter system class.
 *
 * Humm PHP offers this class to be useful in the sites.
 * The code is enterely based in the PHP help:
 *
 * https://www.php.net/manual/en/function.openssl-encrypt.php
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System Encrypter class implementation.
 *
 * This is another useful class to be used in the
 * Humm PHP managed sites.
 */
final class Encrypter extends Unclonable {

  /**
   * Encrypt the specified text string.
   *
   * This method encrypt the specified text string using
   * the also provided "secret key" and "secret IV".
   *
   * @static
   * @param string $clear_text String to be encrypted
   * @param string $secret_key The secret key to be used
   * @param string $cipher The cipher algorithm to be used
   * @return string The encrypted text in base64 codification
   */
  public static function encrypt (string $clear_text, string $secret_key, string $cipher = 'AES-256-CBC') : string {

    if (!\in_array(\strtolower($cipher), \openssl_get_cipher_methods())) {
      throw new \Exception('Non available cipher.');
    }

    $base64_secret_key = \base64_encode($secret_key);

    $ivlen = \openssl_cipher_iv_length($cipher);

    $iv = \openssl_random_pseudo_bytes($ivlen);

    $ciphertext_raw = \openssl_encrypt($clear_text, $cipher, $base64_secret_key, \OPENSSL_RAW_DATA, $iv);

    $hmac = \hash_hmac('sha256', $ciphertext_raw, $base64_secret_key, true);

    return \base64_encode($iv . $hmac . $ciphertext_raw);
  }

  /**
   * Decrypt the specified previously encrypted string.
   *
   * This method decrypt the specified previously encrypted text
   * string using the also provided "secret key" and "secret IV".
   *
   * @static
   * @param string $clear_text Base64 codified string to be decrypted
   * @param string $secret_key The secret key used when encrypt
   * @param string $cipher The cipher algorithm to be used
   * @return string|null The decrypted text or null if an error occur
   */
  public static function decrypt (string $clear_text, string $secret_key, string $cipher = 'AES-256-CBC') : string|null {

    if (!\in_array(\strtolower($cipher), \openssl_get_cipher_methods())) {
      throw new \Exception('Non available cipher.');
    }

    $decoded_clear_text = base64_decode($clear_text);

    $base64_secret_key = \base64_encode($secret_key);

    $ivlen = \openssl_cipher_iv_length($cipher);

    $iv = \substr($decoded_clear_text, 0, $ivlen);

    $hmac = \substr($decoded_clear_text, $ivlen, $sha2len=32);

    $ciphertext_raw = \substr($decoded_clear_text, $ivlen+$sha2len);

    $original_clear_text = \openssl_decrypt($ciphertext_raw, $cipher, $base64_secret_key, \OPENSSL_RAW_DATA, $iv);

    $calcmac = \hash_hmac('sha256', $ciphertext_raw, $base64_secret_key, true);

    if (\hash_equals($hmac, $calcmac)) {
      return $original_clear_text;
    }

    return null;
  }
}
