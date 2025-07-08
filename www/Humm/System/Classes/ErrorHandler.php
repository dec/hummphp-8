<?php

/**
 * This file implement the ErrorHandler system class.
 *
 * This class is used internally by Humm PHP to handle
 * the PHP errors, exceptions and shutdown.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System ErrorHandler class implementation.
 *
 * This class is used internally by Humm PHP and do not offer
 * any useful stuff from the user site point of view.
 */
final class ErrorHandler extends Unclonable {

  /**
   * Define the system error view name.
   */
  private const ERROR_VIEW = 'SystemError';

  /**
   * Define this class method name to handle errors.
   */
  private const ERROR_HANDLER = 'onError';

  /**
   * Define this class method name to handle shutdown.
   */
  private const SHUTDOWN_HANDLER = 'onShutdown';

  /**
   * Define this class method name to handle exceptions.
   */
  private const EXCEPTION_HANDLER = 'onException';

  /**
   * List of ErrorInfo objects.
   *
   * @var ?array
   */
  private static ?array $errors = null;

  /**
   * Register the needed PHP handlers.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      self::$errors = [];

      \set_error_handler([__CLASS__, self::ERROR_HANDLER]);
      \set_exception_handler([__CLASS__, self::EXCEPTION_HANDLER]);
      \register_shutdown_function([__CLASS__, self::SHUTDOWN_HANDLER]);
    }
  }

  /**
   * Handle the possible PHP errors.
   *
   * @static
   * @param int $code Error code.
   * @param string $message Error message.
   * @param string $file File path in which error occur.
   * @param int $line_num Number of the line in which error occur.
   * @return bool True indicating we effectively handle the error.
   */
  final public static function onError (int $code, string $message, string $file, int $line_num) : true {

    self::$errors[] = new ErrorInfo($code, $message, $file, $line_num);

    // Tells PHP don't continue executing the PHP internal error handler
    return true;
  }

  /**
   * Handle the possible PHP exceptions.
   *
   * @static
   * @param \Exception|\Throwable $exception Throwed exception object. in PHP < 7
   */
  final public static function onException (\Exception|\Throwable $exception) : void {

    // $e can be null according the PHP help.
    if ($exception !== null) {

      self::$errors[] = new ErrorInfo($exception->getCode(),
       $exception->getMessage(), $exception->getFile(), $exception->getLine());
    }
  }

  /**
   * Handle the PHP shutdown function.
   *
   * @static
   */
  final public static function onShutdown () : void {

    if (!empty(self::$errors)) {

      \ob_end_clean();
      self::displayView();
    }

    HummPlugins::execSimpleAction(
     PluginActions::SCRIPT_SHUTDOWN);
  }

  /**
   * Display the system error view to the user.
   *
   * @static
   */
  private static function displayView () : void {

    $template = new HtmlTemplate();
    self::setViewTemplatePaths($template);
    self::setDefaultTemplateVars($template);

    if (\HUMM_SHOW_ERRORS) {
      $template->displayView(self::ERROR_VIEW);
    }
  }

  /**
   * Add the appropiate views to an HtmlTemplate object.
   *
   * @static
   * @param HtmlTemplate $template Object instance.
   */
  private static function setViewTemplatePaths (HtmlTemplate $template) : void {

    $template->addViewsDirPaths([
      // Order matter here
      DirPaths::systemViews(),
      DirPaths::systemViewsHelpers()
    ]);
  }

  /**
   * Add default variables to the system view HTML template.
   *
   * @static
   * @param HtmlTemplate $template Object instance
   */
  private static function setDefaultTemplateVars (HtmlTemplate $template) : void {

    $template->errors = self::$errors;

    $template->hummVersion = \HUMM_VERSION_STRING;
    $template->hummRelease = \HUMM_VERSION_RELEASE;

    $template->viewName = self::ERROR_VIEW;
    $template->viewClass = new SystemErrorView($template);

    $template->requestUri = UrlPaths::current();
    $template->siteLanguages = Languages::getLanguages();
    $template->siteLanguage = Languages::getCurrentLanguage();
    $template->siteLanguageDir = Languages::getLanguageDirection();

    $template->siteUrl = UrlPaths::root();
    $template->systemViewsUrl = UrlPaths::systemViews();
    $template->systemViewsImagesUrl = UrlPaths::systemViewsImages();
    $template->systemViewsStylesUrl = UrlPaths::systemViewsStyles();
    $template->systemViewsScriptsUrl = UrlPaths::systemViewsScripts();
  }
}
