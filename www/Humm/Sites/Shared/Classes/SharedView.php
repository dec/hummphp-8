<?php

namespace Humm\Sites\Shared\Classes;

use
  \Humm\System\Classes\HummView,
  \Humm\System\Classes\HtmlTemplate;

final class SharedView extends HummView {

  public function __construct (HtmlTemplate $template) {

    parent::__construct($template);
  }
}
