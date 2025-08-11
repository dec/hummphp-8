<?php

/**
 * This file implement the Shared view class for all sites.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\Sites\Shared\Classes;

use
  \Humm\System\Classes\HummView,
  \Humm\System\Classes\HtmlTemplate;

final class SharedView extends HummView {

  public function __construct (HtmlTemplate $template) {

    parent::__construct($template);
  }
}
