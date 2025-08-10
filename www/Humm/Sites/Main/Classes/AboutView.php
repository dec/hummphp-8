<?php

/**
 * This file implement the main site About view class.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare(strict_types = 1);

namespace Humm\Sites\Main\Classes;

use
  \Humm\System\Classes\HummView,
  \Humm\System\Classes\HtmlTemplate;

/**
 * Main site AboutView class implementation.
 *
 * This class is instantiated automatically by the system
 * when the site about view is required.
 */
final class AboutView extends HummView {

  public function __construct (HtmlTemplate $template) {

    parent::__construct($template);

    $this->template->headerTitle = 'About!';
  }
}
