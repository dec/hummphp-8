<?php

/**
 * This file implement the SitePaths system class.
 *
 * This class define a series of contants with useful
 * non localizables, case sensitive site URL paths.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System SitePaths class implementation.
 *
 * Used by UserSites system class this define a series
 * of non localizables, case sensitive constants with
 * information about user sites URL pahts.
 *
 */
final class SitePaths extends Unclonable {

  /**
   * Define the current site views URL relative path.
   */
  public const VIEWS_URL_PATH = 'Humm/Sites/%s/Views/';

  /**
   * Define the current site views files URL relative path.
   */
  public const VIEWS_FILES_URL_PATH = 'Humm/Sites/%s/Views/Files/';

  /**
   * Define the current site views images URL relative path.
   */
  public const VIEWS_IMAGES_URL_PATH = 'Humm/Sites/%s/Views/Images/';

  /**
   * Define the current site views styles URL relative path.
   */
  public const VIEWS_STYLES_URL_PATH = 'Humm/Sites/%s/Views/Styles/';

  /**
   * Define the current site views scripts URL relative path.
   */
  public const VIEWS_SCRIPTS_URL_PATH = 'Humm/Sites/%s/Views/Scripts/';

  /**
   * Define the current site procedural directory URL relative path.
   */
  public const PROCEDURAL_URL_PATH = 'Humm/Sites/%s/Procedural/';

  /**
   * Define the current site classes directory URL relative path.
   */
  public const CLASSES_URL_PATH = 'Humm/Sites/%s/Classes/';

  /**
   * Define the current site config directory URL relative path.
   */
  public const CONFIG_URL_PATH = 'Humm/Sites/%s/Config/';

  /**
   * Define the current site locale directory URL relative path.
   */
  public const LOCALE_URL_PATH = 'Humm/Sites/%s/Locale/';
}
