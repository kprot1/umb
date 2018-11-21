<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Exception;

/**
 * Class UnsupportedFileMimeTypeException
 * @package Umb\Exception
 */
class UnsupportedFileMimeTypeException extends \DomainException
{
    /**
     * @var int
     */
    protected $code = ExceptionCodes::UNSUPPORTED_FILE_MIMETYPE;

    /**
     * @var string
     */
    protected $message = 'Unsupported file mimeType.';
}