<?php

/**
 * This file implement the DirNames system class.
 *
 * Humm PHP use this class to define not localizables,
 * case sensitive directory names of Humm PHP.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

namespace Humm\System\Classes;

/**
 * System DirNames class implementation.
 *
 * Define certain not localizables, case sensitive
 * sytem and user sites directory names.
 */
final class DirNames extends Unclonable {

  /**
   * Define the root directory name.
   */
  public const HUMM = 'Humm';

  /**
   * Define the sites directory name.
   */
  public const SITES = 'Sites';

  /**
   * Define the shared directory name.
   */
  public const SHARED = 'Shared';

  /**
   * Define the Humm PHP main site directory name.
   */
  public const MAIN_SITE = 'Main';

  /**
   * Define the system directory name.
   */
  public const SYSTEM = 'System';

  /**
   * Define the system classes name.
   */
  public const CLASSES = 'Classes';

  /**
   * Define the config directory name.
   */
  public const CONFIG = 'Config';

  /**
   * Define the locale directory name.
   */
  public const LOCALE = 'Locale';

  /**
   * Define the plugins directory name.
   */
  public const PLUGINS = 'Plugins';

  /**
   * Define the version directory name.
   */
  public const VERSION = 'Version';

  /**
   * Define the procedural directory name.
   */
  public const PROCEDURAL = 'Procedural';

  /**
   * Define the views directory name.
   */
  public const VIEWS = 'Views';

  /**
   * Define the helpers name.
   */
  public const FILES = 'Files';

  /**
   * Define the helpers name.
   */
  public const HELPERS = 'Helpers';

  /**
   * Define the styles directory name.
   */
  public const STYLES = 'Styles';

  /**
   * Define the scripts directory name.
   */
  public const SCRIPTS = 'Scripts';

  /**
   * Define the images directory name.
   */
  public const IMAGES = 'Images';
}
