<?php

/**
 * This file implement the Languages system class.
 *
 * Even when this class exposed methods for string translations,
 * we use instead certain I18n short functions when need to
 * translate strings.
 *
 * This refered functions are t(), e(), n() and ne() and
 * are implemented into the ShortFunctions.php file, which
 * is required by this class whenn initialized.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

namespace Humm\System\Classes;

/**
 * System Languages class implementation.
 *
 * This class are used internally by the system to deal with
 * the site internationalization but also provided with useful
 * methods from the user sites point of view.
 *
 * However then you need to translate strings from site classes,
 * plugins and views, remember that the best choice is to use
 * the short I18n functions: t(), e(), n() and ne().
 */
final class Languages extends Unclonable {

  /**
   * Define the main (default) text I18n text domain.
   */
  public const DEFAULT_DOMAIN = 'Main';

  /**
   * Define the left to right languages identifier.
   */
  private const LEFT_TO_RIGHT_LANG = 'ltr';

  /**
   * Define the right to left languages identifier.
   */
  private const RIGHT_TO_LEFT_LANG = 'rtl';

  /**
   * List of parsed MO file paths.
   *
   * @var ?array
   */
  private static ?array $mo_files_paths = null;

  /**
   * List of messages from parsed MO files.
   *
   * @var ?array
   */
  private static ?array $messages = null;

  /**
   * Associative array with language codes/names.
   *
   * @var ?array
   */
  private static ?array $langs_map = null;

  /**
   * List of available site language codes.
   *
   * @var ?array
   */
  private static ?array $lang_codes = null;

  /**
   * Function to be used when translate plurals.
   *
   * @var ?object
   */
  private static ?object $plural_func_object = null;

  /**
   * Initialize the I18n system stuff.
   *
   * Put availables the I18n short functions; initialize
   * the languages maps and load the right text domains.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;
      self::$messages = [];
      self::$mo_files_paths = [];
      self::$plural_func_object = null;

      require FilePaths::systemI18nFunctions();

      // After require the I18n functions
      self::$langs_map = LanguagesMap::getMap();
      self::$lang_codes = LanguagesMap::getCodes();
      self::loadTextDomain(FilePaths::siteTextDomain());
      self::loadTextDomain(FilePaths::sitesSharedTextDomain());
      self::loadTextDomain(FilePaths::systemTextDomain());
    }
  }

  /**
   * Retrieve the available language codes and names.
   *
   * @static
   * @return array Available codes and language names.
   */
  public static function getLanguages () : array {

    return self::$langs_map;
  }

  /**
   * Retrieve the currently used language code.
   *
   * @static
   * @return string Currently used language code.
   */
  public static function getCurrentLanguage () : string {

    $result = \HUMM_LANGUAGE;

    $lang_code = UserInput::session(ClientSession::HUMM_LANGUAGE);

    if (self::languageExists($lang_code)) {
      $result = $lang_code;
    }

    return $result;
  }

  /**
   * Set the language to be use by the system and site.
   *
   * Note that we change the language storing it into the
   * user session, but in fact the changes do not take effect
   * until the next user request.
   *
   * The recommended approach when change the language is
   * to refresh the user request, of course with attention
   * to do not enter in a infinite loop.
   *
   * For example, supose you have an HTML form to change the
   * site language. This form action URL can be like this:
   *
   * http://www.yoursite.com/?newLanguage=es
   *
   * So in your HomeView class (which is the recommended
   * way instead of use the view template file itself) you
   * can check for the "newLanguage" input code, set the new
   * language using this class method, and finally redirect
   * the user to the home URL:
   *
   * http://www.yoursite.com/
   *
   * So at that time the language has been established, and
   * since the "newLanguage" user input do not exists, your
   * check file and therefore cannot redirect it again.
   *
   * @static
   * @param string $lang_code Valid language code to be set.
   * @return bool True if the language to be set exist, False if not.
   */
  public static function setCurrentLanguage (string $lang_code) : bool {

    $result = false;

    if (self::languageExists($lang_code)) {

      $result = true;

      ClientSession::setVar(ClientSession::HUMM_LANGUAGE, $lang_code);
    }

    self::reset();

    return $result;
  }

  /**
   * Find if a language code is available to use.
   *
   * @static
   * @param ?string $lang_code Language code to be validated.
   * @return bool True on available languages, False when not.
   */
  public static function languageExists (?string $lang_code) : bool {

    return \in_array($lang_code, self::$lang_codes);
  }

  /**
   * Load a text domain into the messages stack.
   *
   * @static
   * @param string $mo_file_path MO file file path.
   * @param string $text_domain Messages text domain.
   * @return bool True on success, False on failure.
   */
  public static function loadTextDomain (string $mo_file_path, string $text_domain = Languages::DEFAULT_DOMAIN) : bool {

    return self::loadMOFile($mo_file_path, $text_domain);
  }

  /**
   * Returns an string translation or the original one.
   *
   * Remember you can use the short function t() which
   * is an alias for this class method.
   *
   * @static
   * @param string $message String to be translated.
   * @param string $text_domain Messages text domain.
   * @return string Translated string or the original one.
   */
  public static function translate(string $message, string $text_domain = Languages::DEFAULT_DOMAIN) : string {

    if (isset(self::$messages[$text_domain][$message])) {

      $message = self::$messages[$text_domain][$message][1][0];
    }

    return $message;
  }

  /**
   * Returns the singular or plural version of a message.
   *
   * Remember you can use the short function n() which
   * is an alias for this class method.
   *
   * @static
   * @param string $singular Message in singular version.
   * @param string $plural Message in plural version.
   * @param int $count Number to determine what version retrieve.
   * @param string $text_domain Message text domain.
   * @return string Singular or plural message version.
   */
  public static function nTranslate (string $singular, string $plural, int $count, string $text_domain = Languages::DEFAULT_DOMAIN) : string {

    $result = (int)$count === 1 ? $singular : $plural;

    if (isset(self::$messages[$text_domain][$singular])) {

      $fn = self::$plural_func_object;

      $n = $fn($count);

      if (isset(self::$messages[$text_domain][$singular][1][$n])) {

        $result = self::$messages[$text_domain][$singular][1][$n];
      }
    }

    return $result;
  }

  /**
   * Retrieve the direction of the current language.
   *
   * This function result can be used directly in HTML "dir"
   * element attributes to specify the language direction.
   *
   * @static
   * @return string Language direction identifier.
   */
  public static function getLanguageDirection () : string {

    $result = self::LEFT_TO_RIGHT_LANG;

    if (\in_array(self::getCurrentLanguage(),
     \array_keys(LanguagesMap::getRtlMap()))) {
       $result = self::RIGHT_TO_LEFT_LANG;
    }

    return $result;
  }

  /**
   * Load messages from a MO file into the specified text domain.
   *
   * @static
   * @param string $mo_file_path Text domain MO file.
   * @param string $text_domain Messages text domain.
   * @return bool True on success, False on failure.
   */
  private static function loadMOFile (string $mo_file_path, string $text_domain) : bool {

    $result = true;

    if (!\in_array($mo_file_path, self::$mo_files_paths)) {

      if (MOFileParser::parseFile($mo_file_path, $text_domain, self::$messages, self::$plural_func_object)) {

         // To avoid load twice
         self::$mo_files_paths[] = $mo_file_path;

      } else {

        $result = false;
      }
    }

    return $result;
  }

  /**
   * This method is intended to be called by self::setCurrentLanguage(),
   * in order to properly apply the language change.
   *
   * @static
   */
  private static function reset () : void {

    self::$messages = [];
    self::$mo_files_paths = [];

    self::loadTextDomain(FilePaths::siteTextDomain());
    self::loadTextDomain(FilePaths::sitesSharedTextDomain());
    self::loadTextDomain(FilePaths::systemTextDomain());
  }
}
