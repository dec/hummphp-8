<?php

/**
 * This file implement the main site Shared view class.
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
 * Implement the main site SharedView class.
 *
 * This class is instantiated automatically by the system
 * when the site home view is required.
 */
final class SharedView extends HummView {

  public function __construct (HtmlTemplate $template) {

    parent::__construct($template);

    $this->prepareUserSession();

    $this->template->copyrightYear = \date('Y');
  }

  private function prepareUserSession () : void {

    \ini_set('session.cookie_httponly', 1);
    \ini_set('session.cookie_samesite', 'Strict');
    \session_start();
  }
}
