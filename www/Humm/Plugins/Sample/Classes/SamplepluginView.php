<?php

/**
 * This file implement a view provided by the Sample plugin.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\Plugins\Sample\Classes;

use
  \Humm\System\Classes\HummView,
  \Humm\System\Classes\HtmlTemplate;

/**
 * Sample plugin view implementation.
 *
 * This class is instantiated automatically by the system
 * when the "sample-plugin" view is required.
 *
 */
final class SamplePluginView extends HummView {

  public function __construct (HtmlTemplate $template) {

    parent::__construct($template);

    $this->template->headerTitle = 'Sample plugin!';
  }
}
