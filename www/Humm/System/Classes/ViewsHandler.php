<?php

/**
 * This file implement the ViewsHandler system class.
 *
 * This class is the responsible to looking for the user request
 * and finally to provide the appropiate user response.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System ViewsHandler class implementation.
 *
 * Part of the system boot strap this system class looking
 * for the appropiate view to be shown to user in response
 * to their request. This class do not contain useful stuff
 * from the user site point of view.
 *
 */
class ViewsHandler extends Unclonable {

  /**
   * Define the suffix which use all HummView classes.
   */
  public const VIEW_CLASS_SUFFIX = 'View';

  /**
   * Define the base class which all other views must inherit from.
   */
  private const HUMM_VIEW_BASE_CLASS = 'HummView';

  /**
   * Define the shared view class optionally placed in the shared site.
   */
  private const SHARED_SITE_SHARED_VIEW_CLASS = 'Humm\Sites\Shared\Classes\SharedView';

  /**
   * Define the system classes PHP namespace.
   */
  private const SYSTEM_CLASS_NAMESPACE = 'Humm\System\Classes\\';

  /**
   * Define the sites shared classes PHP namespace.
   */
  private const SITES_SHARED_CLASS_NAMESPACE = 'Humm\Sites\Shared\Classes\\';

  /**
   * Start the output buffer and display the requested view.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () {

    static $init = 0;

    if (!$init) {

      $init = 1;
      self::startBuffer();
      self::displayView();
    }
  }

  /**
   * Start the output buffer and filter it by plugins.
   *
   * @static
   */
  private static function startBuffer () : void {

    \ob_start(function($buffer) {

      return HummPlugins::applySimpleFilter(
        PluginFilters::BUFFER_OUTPUT, $buffer);
    });
  }

  /**
   * Display the requested view to the user.
   *
   * @static
   */
  private static function displayView () : void {

    $template = new HtmlTemplate();

    // Set the shared sites, sites and system directories
    // in which the HTML template can found views and helpers.
    TemplatePaths::setTemplatePaths($template);

    // Set the default view variables, available everyehere.
    TemplateVars::setDefaultSiteVars($template);
    TemplateVars::setDefaultSystemVars($template);

    // An optional shared view class (in user site) can be used if available.
    $userSiteSharedClass = UserSites::sharedViewClassName();
    if (self::isValidViewClass($userSiteSharedClass)) {
      $template->sharedView = new $userSiteSharedClass($template);
    }

    // An optional shared view class (in shared site) can be used if available.
    $sharedSiteSharedClass = self::SHARED_SITE_SHARED_VIEW_CLASS;
    if (self::isValidViewClass($sharedSiteSharedClass)) {
      $template->sharedSiteSharedView = new $sharedSiteSharedClass($template);
    }

    // Setup the current (requested) site class object instance.
    $view_name = RequestedView::getViewName($template);
    $template->siteView = self::getViewObject($view_name, $template);

    // Allow plugins to add stuff into the HTML template.
    HummPlugins::applySimpleFilter(
     PluginFilters::VIEW_TEMPLATE, $template);

    // Finally display the requested site view.
    $template->displayView($view_name);
  }

  /**
   * Get the optional view associated class.
   *
   * Views associated classes are optional but useful in order
   * to intereact with the view HTML template adding variables.
   *
   * System and also user sites can put availables views classes
   * by placing a class with the appropiate name into the system
   * or sites classes directories.
   *
   * All views associated classes must be named using the view
   * name (capitalized) and the "View" preffix. For example, the
   * view class which a Home view can implement must be named "HomeView",
   * the class for a possible "Contact" view can be "ContactView", etc.
   *
   * Also all the views associated classes must derive from the
   * system "HummView" class in order to be considered valid.
   *
   * @static
   * @param string $view_name View name to retrieve their associate class.
   * @param HtmlTemplate $template Reference to an HTML template object.
   * @return HummView object or null iof the specified view cannot be found.
   */
  private static function getViewObject (string $view_name, HtmlTemplate $template) : ?HummView {

    $viewObject = null;

    $sharedClass = self::SITES_SHARED_CLASS_NAMESPACE . $view_name . self::VIEW_CLASS_SUFFIX;

    $siteClass = UserSites::viewClassName($view_name);

    $systemClass = self::SYSTEM_CLASS_NAMESPACE . $view_name . self::VIEW_CLASS_SUFFIX;

    // Order matter here
    if (self::isValidViewClass($sharedClass)) {

      $viewObject = new $sharedClass($template);

    } else if (self::isValidViewClass($siteClass)) {

      $viewObject = new $siteClass($template);

    } else if (self::isValidViewClass($systemClass)) {

      $viewObject = new $systemClass($template);
    }

    return $viewObject;
  }

  /**
   * Determine if a class is a valid view class.
   *
   * @static
   * @param string $class_name Class name to check.
   * @return bool True if class is a valid view class, False if not
   */
  private static function isValidViewClass (string $class_name) : bool {

    return self::viewClassExists($class_name) &&
      self::isValidViewSubclass($class_name);
  }

  /**
   * Find if the specified view class exists.
   *
   * @static
   * @param string $view_class_name Class name to be checked.
   * @return bool True if the class exists, False if not.
   */
  private static function viewClassExists (string $view_class_name) : bool {

    $expectedPath = \str_replace(

      StrUtils::PHP_NS_SEPARATOR,
      \DIRECTORY_SEPARATOR,
      $view_class_name

    ) . FileExts::DOT_PHP;

    return \file_exists($expectedPath) && \class_exists($view_class_name);
  }

  /**
   * Find if a class is derived from the views base class.
   *
   * @static
   * @param string $class_name Class name to be checked.
   * @return bool True if the class parent is a HummView, False if not.
   */
  private static function isValidViewSubclass (string $class_name) : bool {

    return \is_subclass_of($class_name, __NAMESPACE__ .
     StrUtils::PHP_NS_SEPARATOR . self::HUMM_VIEW_BASE_CLASS);
  }
}
