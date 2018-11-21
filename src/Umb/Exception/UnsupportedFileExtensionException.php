<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Exception;

/**
 * Class UnsupportedFileExtensionException
 * @package Umb\Exception
 */
class UnsupportedFileExtensionException extends \DomainException
{
    /**
     * @var int
     */
    protected $code = ExceptionCodes::UNSUPPORTED_FILE_EXTENSION;

    /**
     * @var string
     */
    protected $message = 'Unsupported file extension.';
}