<?php

/**
 * This file implement the HtmlTemplate system class.
 *
 * This class is used by Humm PHP views to construct
 * their HTML templates in a simple but powerful way.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System HtmlTemplate class implementation.
 *
 * This class provide methods to assign variables into
 * the HTML template, add views paths and therefore display
 * the views, which can use the assigned template variables.
 */
class HtmlTemplate extends BaseClass {

  /**
   * Internal variables stack.
   *
   * @var array
   */
  private array $vars_stack = [];

  /**
   * Views directory paths.
   *
   * @var array
   */
  private array $views_dirs_paths = [];

  /**
   * A convenient magic way to assign variables to the template.
   *
   * @param string $var_name Variable name.
   * @param mixed $var_value Variable value.
   */
  public function  __set (string $var_name, mixed $var_value) : void {

    $this->vars_stack[$var_name] = $var_value;
  }

  /**
   * A convenient magic way to retrieve template variable values.
   *
   * @param string $var_name Variable name.
   * @return mixed Variable value or null if not exists.
   */
  public function  __get (string $var_name) : mixed {

    $result = null;

    if (isset($this->vars_stack[$var_name])) {

      $result = $this->vars_stack[$var_name];
    }

    return $result;
  }

  /**
   * A convenient magic way to find if template variables exists.
   *
   * @param string $var_name Variable name.
   * @return bool True if template variable exists, False if not.
   */
  public function  __isset (string $var_name) : bool {

    return isset($this->vars_stack[$var_name]);
  }

  /**
   * A convenient magic way to unset template variables.
   *
   * @param string $var_name Variable name.
   */
  public function  __unset (string $var_name) : void {

    if (isset($this->vars_stack[$var_name])) {
      unset($this->vars_stack[$var_name]);
    }
  }

  /**
   * Assign template variables from an associative array.
   *
   * If you want to assign just a variable remember you
   * can assign it directly as a property of this object
   * since the use of the __set() magic method.
   *
   * @param array $vars_keys_values Associative array containing names/values
   */
  public function assign (array $vars_keys_values) : void {

    foreach ($vars_keys_values as $key => $value) {
      $this->vars_stack[$key] = $value;
    }
  }

  /**
   * Extract the template variables and display the specified view.
   *
   * @param string $view_name View name you want to display.
   */
  public function displayView (string $view_name) : void {

    if (\file_exists($this->getViewFilePath($view_name))) {

      \extract($this->vars_stack, \EXTR_OVERWRITE);

      require $this->getViewFilePath($view_name);
    }
  }

  /**
   * Retrieve the HTML template variables stack.
   *
   * @return array HTML template variables stack.
   */
  public function getVariables () : array {

    return $this->vars_stack;
  }

  /**
   * Clear the HTML template variables stack.
   */
  public function clearVariables () : void {

    $this->vars_stack = [];
  }

  /**
   * Retrieve the HTML template views directory paths.
   *
   * @return array HTML template views directory paths.
   */
  public function getViewsDirPaths () : array {

    return $this->views_dirs_paths;
  }

  /**
   * Clear the HTML template views directory paths.
   */
  public function clearViewsDirPaths () : void {

    $this->views_dirs_paths = [];
  }

  /**
   * Set a directory path in which views resides.
   *
   * @param string $dir_path Views directory path.
   */
  public function addViewsDirPath (string $dir_path) : void {

    if (!\in_array($dir_path, $this->views_dirs_paths)) {
      $this->views_dirs_paths[] = $dir_path;
    }
  }

  /**
   * Set more than one directory path in which views resides.
   *
   * @param array $dirPaths Bunch of views directory paths.
   */
  public function addViewsDirPaths (array $dir_paths) : void {

    foreach ($dir_paths as $dir_path) {
      $this->addViewsDirPath($dir_path);
    }
  }

  /**
   * Find if the specified view file exists or not.
   *
   * @param string $aViewName View name to looking for.
   * @return bool True if the view file exists, False if not.
   */
  public function viewFileExists (string $view_name) : bool {

    // We use ucfirst() to follow the views names convention
    return \file_exists($this->getViewFilePath(\ucfirst($view_name)));
  }

  /**
   * Retrieve the file path of the specified view.
   *
   * Note that view files names must be capitalized.
   *
   * @param string $aViewName View name to looking for.
   * @return string The specified view file path.
   */
  private function getViewFilePath (string $view_name) : string {

    $result = $view_name;

    foreach ($this->views_dirs_paths as $path) {

      if (\file_exists($path . $view_name . FileExts::DOT_PHP)) {

        $result = $path . $view_name . FileExts::DOT_PHP;
        break;
      }
    }

    return $result;
  }
}
