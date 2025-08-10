<?php

/**
 * This file implement the HummPlugins system class.
 *
 * This is the system and site plugins manager class,
 * which is responsible to load the plugins and execute
 * the available plugin actions and filters.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

namespace Humm\System\Classes;

/**
 * System HummPlugins class implementation.
 *
 * Manage the available plugins and provide useful
 * methods to execute actions, filters and more.
 */
final class HummPlugins extends Unclonable {

  /**
   * Define the plugins base class name.
   */
  private const PLUGIN_BASE_CLASS = 'HummPlugin';

  /**
   * Define the plugins priority method.
   */
  private const PRIORITY_METHOD = 'priority';

  /**
   * Define the plugins execute action method.
   */
  private const EXEC_ACTION_METHOD = 'execAction';

  /**
   * Define the plugins apply filter method.
   */
  private const APPLY_FILTER_METHOD = 'applyFilter';

  /**
   * Define the active plugins separator.
   */
  private const ACTIVE_PLUGINS_SEPARATOR = ',';

  /**
   * List of HummPlugin objects.
   *
   * @var array
   */
  private static array $plugins = [];

  /**
   * Load the available system and site plugins.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      if (!StrUtils::isTrimEmpty(\HUMM_ACTIVE_PLUGINS)) {

        self::loadPlugins();
      }
    }
  }

  /**
   * Retrieve the loaded plugins as HummPlugin class objects.
   *
   * @static
   * @return array Loaded HummPlugin class objects.
   */
  public static function getPlugins () : array {

    return self::$plugins;
  }

  /**
   * Apply a simple filter over the plugins.
   *
   * A simple filter is a filter which is composed only
   * with a filter ID and their content. So instead create
   * the appropiate FilterArguments object and prepare it,
   * let this method to apply simple filters like that.
   *
   * @static
   * @param int $filter_id Filter ID to be applied.
   * @param mixed $content Content to be filter it.
   * @return mixed Filtered or untouched filter argument content.
   */
  public static function applySimpleFilter (int $filter_id, mixed $content) : mixed {

    return self::applyFilter(new FilterArguments([
      FilterArguments::FILTER =>  $filter_id,
      FilterArguments::CONTENT => $content
    ]));
  }

  /**
   * Execute a simple action over the plugins.
   *
   * A simple action is an action which is composed only
   * by their ID and do not need any other argument. So instead
   * create the appropiate ActionArguments object and prepare it,
   * let this method to execute simple actions like that.
   *
   * @static
   * @param int $action_id Action ID to be called.
   */
  public static function execSimpleAction (int $action_id) : void {

    self::execAction(new ActionArguments([
      ActionArguments::ACTION => $action_id
    ]));
  }

  /**
   * Apply certain filter over the plugins.
   *
   * The contents to be filter are always stored into the
   * $arguments->content property. We pass to the plugin this
   * value in order to be filtered and always return such value
   * filtered or untouched.
   *
   * The value of the filter content depend of the filter and in
   * fact are a mixed value: an string, an array, and object, etc.
   *
   * @static
   * @param FilterArguments $arguments Plugin filter arguments.
   * @return mixed Filtered or untouched filter argument content.
   */
  public static function applyFilter (FilterArguments $arguments) : mixed {

    foreach (self::$plugins as $plugin) {

      if (\method_exists($plugin, self::APPLY_FILTER_METHOD)) {

        $arguments->content = \call_user_func(
          [$plugin, self::APPLY_FILTER_METHOD],
          $arguments
        );
      }
    }

    return $arguments->content;
  }

  /**
   * Execute certain action over the plugins.
   *
   * Thanks to this method we can tell the plugins about various
   * system actions in the way that the plugins can react and do
   * some tasks when the appropiate action occur.
   *
   * @static
   * @param ActionArguments $arguments Plugin action arguments.
   */
  public static function execAction (ActionArguments $arguments) : void {

    foreach (self::$plugins as $plugin) {

      if (\method_exists($plugin, self::EXEC_ACTION_METHOD)) {
        \call_user_func(
          [$plugin, self::EXEC_ACTION_METHOD],
          $arguments
        );
      }
    }
  }

  /**
   * Load and instantiate all available plugins.
   *
   * @static
   */
  private static function loadPlugins () :void {

    $prioritized_plugins = [];
    $unprioritized_plugins = [];

    foreach (self::getPluginDirs() as $plugin_dir_path) {

      $pluginClass = self::getPluginClass($plugin_dir_path);

      if (self::isValidPluginClass($pluginClass)) {
        $unprioritized_plugins[] = new $pluginClass;
      }
    }

    foreach ($unprioritized_plugins as $plugin) {
      $prioritized_plugins[\call_user_func([$plugin, self::PRIORITY_METHOD])][] = $plugin;
    }

    \krsort($prioritized_plugins);

    foreach ($prioritized_plugins as $priority => $plugins) {
      foreach ($plugins as $plugin) {
        self::$plugins[] = $plugin;
      }
    }

    // Notify the plugins
    self::execSimpleAction(PluginActions::PLUGINS_LOADED);
  }

  /**
   * Retrieve all paths in which plugins can reside.
   *
   * @static
   * @return array Plugins directories paths.
   */
  private static function getPluginDirs () : array {

    $result = [];

    $plugins_dir_path = DirPaths::plugins();

    if (\is_dir($plugins_dir_path)) {

      foreach (new \DirectoryIterator($plugins_dir_path) as $file_info) {

        if (self::pluginIsActive($file_info) && self::pluginFileExists($file_info)) {

          $result[] = $file_info->getPathName();
        }
      }
    }

    return $result;
  }

  /**
   * Find if a plugin is currently active or not.
   *
   * @static
   * @param SplFileInfo $file_info Object with file information.
   * @return bool True if the plugin is active, False if not.
   */
  private static function pluginIsActive (\SplFileInfo $file_info) : bool {

    return \in_array(
      $file_info->getBasename(),
      \explode(self::ACTIVE_PLUGINS_SEPARATOR, \HUMM_ACTIVE_PLUGINS));
  }

  /**
   * Find if the specified file info have an existing plugin file.
   *
   * @static
   * @param SplFileInfo $file_info Object with file information.
   * @return bool True if the plugin file exists, False if not.
   */
  private static function pluginFileExists (\SplFileInfo $file_info) : bool {

    return !$file_info->isDot() && $file_info->isDir() &&
     \file_exists($file_info->getPathName() . \DIRECTORY_SEPARATOR .
      $file_info->getBasename() . FileExts::DOT_PHP);
  }

  /**
   * Retrieve the appropiate plugin class from their directory.
   *
   * @static
   * @param string $plugin_dir_path Plugin directory path.
   * @return string Plugin class name.
   */
  private static function getPluginClass (string $plugin_dir_path) : string {

    return \str_replace(

      [DirPaths::root(), \DIRECTORY_SEPARATOR],
      [StrUtils::EMPTY_STRING, StrUtils::PHP_NS_SEPARATOR],
      $plugin_dir_path

    ) . StrUtils::PHP_NS_SEPARATOR.\basename($plugin_dir_path);
  }

  /**
   * Find if the specified class name is a valid plugin class.
   *
   * @static
   * @param string $class_name Plugin class name to be validated.
   * @return bool True if the plugin class is valid, False if not.
   */
  private static function isValidPluginClass (string $class_name) : bool {

    return \get_parent_class($class_name) === __NAMESPACE__ .
     StrUtils::PHP_NS_SEPARATOR . self::PLUGIN_BASE_CLASS;
  }
}
