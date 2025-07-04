<?php

/**
 * This file implement the Humm plugin Sample.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\Plugins\Sample;

use
  \Humm\System\Classes\HummPlugin,
  \Humm\System\Classes\PluginFilters,
  \Humm\System\Classes\PluginActions,
  \Humm\System\Classes\FilterArguments,
  \Humm\System\Classes\ActionArguments;

final class Sample extends HummPlugin {

  public function execAction (ActionArguments $arguments) {

    switch ($arguments->action) {

      case PluginActions::PLUGINS_LOADED:
        break;

      case PluginActions::CHECK_REQUERIMENTS:
        break;

      case PluginActions::DATABASE_CONNECTED:
        break;

      case PluginActions::SCRIPT_SHUTDOWN:
        break;
    }
  }

  public function applyFilter (FilterArguments $arguments) {

    switch ($arguments->filter) {

      case PluginFilters::DATABASE_SQL:
        break;

      case PluginFilters::VIEW_TEMPLATE:
        break;

      case PluginFilters::BUFFER_OUTPUT:
        break;
    }

    // Filtered or not
    return $arguments->content;
  }
}
