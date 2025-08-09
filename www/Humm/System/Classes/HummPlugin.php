<?php

/**
 * This file implement the HummPlugin system class.
 *
 * Every system or site plugin class must derived from
 * this in order to be considerer a valid Humm PHP plugin.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System HummPlugin class implementation.
 *
 * This is the base class for Humm PHP plugins and contain
 * useful methods to be use by inherited classes.
 *
 * @abstract
 */
abstract class HummPlugin extends BaseClass {

  /**
   * Construct an HummPlugin object.
   *
   */
  public function __construct () {

    // Automatically load plugin text domains
    Languages::loadTextDomain(FilePaths::pluginTextDomain($this->getClassDirPath()));
  }

  /**
   * Get the priority of a plugin.
   *
   * This method is intented to be overwriten in child classes
   * but we implement here to provide a default priority.
   *
   * @return int The plugin priority.
   */
  public function priority () : int {

    return PluginPriorities::LOWER;
  }

  /**
   * Retrieve the plugin directory URL.
   *
   * @return string Plugin directory URL.
   */
  public function rootUrl () : string {

    return $this->getClassDirUrl();
  }

  /**
   * Retrieve the plugin classes directory URL.
   *
   * @return string Plugin classes directory URL.
   */
  public function classesUrl () : string {

    return $this->rootUrl() . DirNames::CLASSES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin locale directory URL.
   *
   * @return string Plugin locale directory URL.
   */
  public function localeUrl () : string {

    return $this->rootUrl() . DirNames::LOCALE . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin procedural directory URL.
   *
   * @return string Plugin procedural directory URL.
   */
  public function proceduralUrl () : string {

    return $this->rootUrl() . DirNames::PROCEDURAL . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin views directory URL.
   *
   * @return string Plugin views directory URL.
   */
  public function viewsUrl () : string {

    return $this->rootUrl() . DirNames::VIEWS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin views files directory URL.
   *
   * @return string Plugin views files directory URL.
   */
  public function viewsFilesUrl () : string {

    return $this->viewsUrl() . DirNames::FILES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin views helpers directory URL.
   *
   * @return string Plugin views helpers directory URL.
   */
  public function viewsHelpersUrl () : string {

    return $this->viewsUrl() . DirNames::HELPERS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin views styles directory URL.
   *
   * @return string Plugin views styles directory URL.
   */
  public function viewsStylesUrl () : string {

    return $this->viewsUrl() . DirNames::STYLES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin views images directory URL.
   *
   * @return string Plugin views images directory URL.
   */
  public function viewsImagesUrl () : string {

    return $this->viewsUrl() . DirNames::IMAGES . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin views scripts directory URL.
   *
   * @return string Plugin views scripts directory URL.
   */
  public function viewsScriptsUrl () : string {

    return $this->viewsUrl() . DirNames::SCRIPTS . StrUtils::URL_SEPARATOR;
  }

  /**
   * Retrieve the plugin directory path.
   *
   * @return string Plugin directory path.
   */
  public function rootDir () : string {

    return $this->getClassDirPath();
  }

  /**
   * Retrieve the plugin classes directory path.
   *
   * @return string Plugin classes directory path.
   */
  public function classesDir () : string {

    return $this->rootDir() . DirNames::CLASSES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin locale directory path.
   *
   * @return string Plugin locale directory path.
   */
  public function localeDir () : string {

    return $this->rootDir() . DirNames::LOCALE . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin procedural directory path.
   *
   * @return string Plugin procedural directory path.
   */
  public function proceduralDir () : string {

    return $this->rootDir() . DirNames::PROCEDURAL . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin views directory path.
   *
   * @return string Plugin views directory path.
   */
  public function viewsDir () : string {

    return $this->rootDir() . DirNames::VIEWS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin views files directory path.
   *
   * @return string Plugin views files directory path.
   */
  public function viewsFilesDir () : string {

    return $this->viewsDir() . DirNames::FILES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin views helpers directory path.
   *
   * @return string Plugin views helpers directory path.
   */
  public function viewsHelpersDir () : string {

    return $this->viewsDir() . DirNames::HELPERS . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin views styles directory path.
   *
   * @return string Plugin views styles directory path.
   */
  public function viewsStylesDir () : string {

    return $this->viewsDir() . DirNames::STYLES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin views images directory path.
   *
   * @return string Plugin views images directory path.
   */
  public function viewsImagesDir () : string {

    return $this->viewsDir() . DirNames::IMAGES . \DIRECTORY_SEPARATOR;
  }

  /**
   * Retrieve the plugin views scripts directory path.
   *
   * @return string Plugin views scripts directory path.
   */
  public function viewsScriptsDir () : string {

    return $this->viewsDir() . DirNames::SCRIPTS . \DIRECTORY_SEPARATOR;
  }
}
