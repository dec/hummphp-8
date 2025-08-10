<?php

/**
 * This file implement the PluginPriorities system class.
 *
 * This class is intended to define constants to be
 * used as Humm plugins priorities identifiers.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

namespace Humm\System\Classes;

/**
 * System PluginPriorities class implementation.
 *
 * This class is intended to define constants to be
 * used as Humm plugins priorities identifiers.
 */
final class PluginPriorities extends Unclonable {

  /**
   * Define the plugins lower priority.
   */
  public const LOWER = 3001;

  /**
   * Define the plugins low priority.
   */
  public const LOW = 3002;

  /**
   * Define the plugins normal priority.
   */
  public const NORMAL = 3003;

  /**
   * Define the plugins higher priority.
   */
  public const HIGHER = 3004;

  /**
   * Define the plugins highest priority.
   */
  public const HIGHEST = 3005;

  /**
   * Define the plugins critical priority.
   */
  public const CRITICAL = 3006;
}
