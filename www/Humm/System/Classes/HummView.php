<?php

/**
 * This file implement the HummView system class.
 *
 * The HummView system class is intented to be inherited
 * by all system and user sites views classes.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System HummView class implementation.
 *
 * Every Humm PHP view class must inherites from this
 * in order to be considered a valid views class.
 *
 * @abstract
 */
abstract class HummView extends BaseClass {

  /**
   * Store the view HtmlTemplate object.
   *
   * @var ?HtmlTemplate
   */
  protected ?HtmlTemplate $template = null;

  /**
   * Construct an HtmlView object and store their associated template.
   *
   * @param HtmlTemplate $template HTML template object.
   */
  public function __construct (HtmlTemplate $template) {

    $this->template = $template;
  }
}
