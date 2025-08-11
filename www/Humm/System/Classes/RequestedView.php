<?php

/**
 * This file implement the RequestedView system class.
 *
 * This class is the responsible to find the requested
 * site view and offer information about it.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System RequestedView class implementation.
 *
 * Just a helper to the ViewsHandler system class which find
 * the appropiate requested site view and offer information
 * and more about it.
 *
 */
final class RequestedView extends Unclonable {

  /**
   * Define the default view name for site home.
   */
  private const SITE_HOME_VIEW = 'Home';

  /**
   * Define a fall out view when missing the site home view.
   */
  public const SYSTEM_HOME_VIEW = 'SystemHome';

  /**
   * Store all availables views directory paths.
   *
   * @var array
   */
  private static array $views_dirs_paths = [];

  /**
   * Get the appropiate view to be displayed.
   *
   * @static
   * @param HtmlTemplate $template Reference to an HTML template object.
   * @return string The URL requested view.
   */
  public static function getViewName (HtmlTemplate $template) : string {

    /**
     * Now Humm PHP can support "deep" views from the URL, something
     * like in this one: http://www.server.com/admin/user/profile
     *
     * Previously this change Humm PHP determine that the above URL
     * end into the "admin" view and optional class to be loaded.
     *
     * The below code allows Humm PHP to support "deep" views and
     * optional classes, so the above URL end into the "AdminUserProfile"
     * view and optional class ("AdminUserProfileView") to be loaded.
     */
    $view = self::getDeepView($template);

    // Check the existence of a possible "deep" view
    if (!self::isMainView($view) || !$template->viewFileExists($view)) {

      $arg = \str_replace(['-', '_'], '', UrlArguments::get(0) !== null ? UrlArguments::get(0) : '');

      /**
       * The below code is for backward compatibility: as is mentioned above,
       * previously to support "deep" views, Humm PHP only support one main
       * view, which corresponde with the first URL argument, in the above
       * URL sample the "admin" view.
       *
       * So the below code try to take the view from the first URL argument.
       */
      if (self::isMainView($arg) &&
       $template->viewFileExists($arg)) {

        $view = $arg;

      } else if (self::isMainView(self::SITE_HOME_VIEW) &&
       $template->viewFileExists(self::SITE_HOME_VIEW)) {

        $view = self::SITE_HOME_VIEW;
      }
    }

    // Fallback to the Humm PHP system's home view.
    if ($view === '') {
      $view = self::SYSTEM_HOME_VIEW;
    }

    return \ucfirst($view);
  }

  /**
   * Try to find a possible deep view from the URL.
   *
   * @static
   * @param HtmlTemplate $template The current template
   * @return string The possible deep view name
   */
  private static function getDeepView (HtmlTemplate $template) : string {

    $view = '';
    $result = '';
    $views = [];
    $args = UrlArguments::getAll();

    foreach ($args as $arg) {
      /**
       * We continue supporting URLs which don't use the Apache's rewrite
       * module, for example (other servers provides something similar).
       *
       * Then the below URLs works if we use the Apache rewrite module:
       *
       * http://www.server.com/admin/user/profile
       * http://www.server.com/admin/user/profile/?var=value
       *
       * And this other URL also works as expected without rewrite module:
       *
       * http://www.server.com/?admin/user/profile
       *
       * Note that this other URL also works as expected:
       *
       * http://www.server.com/?admin/user/profile/&var=value
       *
       */
      if ((\substr($arg, 0, 1) !== '?') && (\substr($arg, 0, 1) !== '&')) {
        $arg = \str_replace(['-', '_'], '', $arg);
        $view .= \ucfirst($arg);
      }

      if (!\in_array($view, $views)) {
        $views[] = $view;
      }
    }

    /**
     * We must return here the first existing view according with the
     * URL arguments, for example, supose the below URL:
     *
     * http://www.site.com/forum/section/12
     *
     * The above URL causes we have three possible views & views' classes:
     *
     * Forum
     * ForumSection
     * ForumSection12
     *
     * Instead of fallback to the home view if "ForumSection12" did not
     * exists, we want to use the ForumSection view.
     *
     * In this way we can provide more arguments into the URL and always
     * use the expected view and view's class, for example:
     *
     * http://www.site.com/forum/section/id/12
     *
     * Probably we don't wanted a view & class like "ForumSectionId", but
     * wanted to use the ForumSection view & class.
     *
     * We can provide an ForumSectionId if we wanted that, of course.
     *
     */

    $total_views = \count($views);

    for ($i = $total_views - 1; $i >= 0; $i--) {
      if (self::isMainView($views[$i]) &&
       $template->viewFileExists($views[$i])) {
         $result = $views[$i];
         break;
      }
    }

    return $result;
  }

  /**
   * Find if a view is a main view or not.
   *
   * Main views corresponded with URL arguments. On the
   * contrary we count also with views helpers, which are
   * also views but do not corresponde with URL arguments
   * and are intended to use as views helpers.
   *
   * @static
   * @param string $view_name The view name to be checked.
   * @return bool True if the view is a main view, False if not.
   */
  private static function isMainView (string $view_name) : bool {

    // By convention views files must be first capitalized.
    return in_array(\ucfirst($view_name), self::getMainViewsDirs());
  }

  /**
   * Retrieve the directory paths in which views can resides.
   *
   * @static
   * @return array Directory paths for all possible main views.
   */
  private static function getMainViewsDirs () : array {

    if (empty(self::$views_dirs_paths)) {

      // Order matter here:

      // 1º Shared sites
      // 2º Site specific
      // 3º System specific
      // 4º Plugins specific

      // Prepare the plugins views here, but, add it at the end as you see below.
      $plugins_views = [];
      foreach (HummPlugins::getPlugins() as $plugin) {
        foreach (self::getDirectoryViews($plugin->viewsDir()) as $plugin_view) {
          $plugins_views[] = $plugin_view;
        }
      }

      self::$views_dirs_paths = \array_unique(\array_merge(
        self::getDirectoryViews(DirPaths::sitesSharedViews()),
        self::getDirectoryViews(DirPaths::siteViews()),
        self::getDirectoryViews(DirPaths::systemViews()),
        $plugins_views
      ));
    }

    return self::$views_dirs_paths;
  }

  /**
   * Get the views files of the specified directory.
   *
   * @static
   * @param string $dir_path Directory in which views resides.
   * @return array Directory views file paths.
   */
  private static function getDirectoryViews (string $dir_path) : array {

    $views = [];

    if (\file_exists($dir_path)) {

      foreach (new \DirectoryIterator($dir_path) as $file_info) {

        if (self::isMainViewFile($file_info)) {

          $views[] = self::getMainViewName($file_info);
        }
      }
    }

    return $views;
  }

  /**
   * Find if a file can be considered a view file.
   *
   * In fact all PHP files in a views directory are
   * considered valid views, but not others like HTML
   * files or others.
   *
   * @static
   * @param SplFileInfo $file_info File information.
   * @return bool True if a file is considered a view.
   */
  private static function isMainViewFile (\SplFileInfo $file_info) : bool {

    return $file_info->isFile() && ($file_info->getExtension() === FileExts::PHP);
  }

  /**
   * Extract the view name from a view file path.
   *
   * @static
   * @param SplFileInfo $file_info File information.
   * @return string View name.
   */
  private static function getMainViewName (\SplFileInfo $file_info) : string {

    return \str_replace(
      FileExts::DOT_PHP,
      StrUtils::EMPTY_STRING,
      $file_info->getBasename()
    );
  }
}
