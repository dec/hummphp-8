<?php

/**
 * This file implement the ErrorInfo system class.
 *
 * This class is used internally by Humm PHP to
 * encapsulate PHP errors and exceptions information.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp/blob/master/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System ErrorInfo class implementation.
 *
 * This class is used internally by our error handler in order
 * to encapsulate a PHP error or exception information.
 */
class ErrorInfo extends BaseClass {

  /**
   * Error file path.
   *
   * @var ?string
   */
  public ?string $file = null;

  /**
   * Error file number.
   *
   * @var ?int
   */
  public ?int $line_num = null;

  /**
   * Error message.
   *
   * @var ?string
   */
  public ?string $message = null;

  /**
   * Error code.
   *
   * @var ?int
   */
  public ?int $error_code = null;

  /**
   * Error code string.
   *
   * @var ?string
   */
  public ?string $error_code_str = null;

  /**
   * Construct an ErrorInfo object.
   *
   * @param int $error_code Error code.
   * @param string $message Error message.
   * @param string $file Error file path.
   * @param int $line_num Error file number.
   */
  public function __construct (int $error_code, string $message, string $file, int $line_num) {

    $this->file = $file;
    $this->message = $message;
    $this->line_num = $line_num;
    $this->error_code = $error_code;

    $this->error_code_str = $this->getErrorCodeAsString();
  }

  /**
   * Translate an error code into string.
   *
   * @return string Error code string representation.
   */
  private function getErrorCodeAsString () : string {

    switch ($this->error_code) {

      case E_ALL: $result = 'E_ALL'; break;
      case E_PARSE: $result = 'E_PARSE'; break;
      case E_ERROR: $result = 'E_ERROR'; break;
      case E_NOTICE: $result = 'E_NOTICE'; break;
      case E_WARNING: $result = 'E_WARNING'; break;
      case E_USER_ERROR: $result = 'E_USER_ERROR'; break;
      case E_CORE_ERROR: $result = 'E_CORE_ERROR'; break;
      case E_USER_NOTICE: $result = 'E_USER_NOTICE'; break;
      case E_USER_WARNING: $result = 'E_USER_WARNING'; break;
      case E_CORE_WARNING: $result = 'E_CORE_WARNING'; break;
      case E_COMPILE_ERROR: $result = 'E_COMPILE_ERROR'; break;
      case E_COMPILE_WARNING: $result = 'E_COMPILE_WARNING'; break;
      case E_RECOVERABLE_ERROR: $result = 'E_RECOVERABLE_ERROR'; break;

      default: $result = 'Unknow error'; break;
    }

    return $result;
  }
}
