<?php

/**
 * This file implement the ActionArguments system class.
 *
 * Humm PHP use this class when a plugin action is execued:
 * this class encapsulate the available action arguments.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

namespace Humm\System\Classes;

/**
 * System ActionArguments class implementation.
 *
 * This class can be used by system and site plugins
 * to access the executed actions arguments.
 */
final class ActionArguments extends PluginArguments {

  /**
   * Define the name of the action ID property.
   *
   * We use this when need to provide the appropiate
   * plugin action ID for the executing plugin action.
   */
  public const ACTION = 'action';

  /**
   * Plugin arguments action ID.
   *
   * @var ?int The action ID, null by default.
   */
  public ?int $action = null;

  /**
   * Construct an ActionArguments object.
   *
   * @param array $arguments Action arguments associated array
   */
  public function __construct (array $arguments = []) {

    $this->action = null;
    parent::__construct($arguments);
  }
}
