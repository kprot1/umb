<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Exception;

/**
 * Class FileSizeExceedsAllowedException
 * @package Umb\Exception
 */
class FileSizeExceedsAllowedException extends \DomainException
{
    /**
     * @var int
     */
    protected $code = ExceptionCodes::FILE_SIZE_EXCEEDS_ALLOWED;

    /**
     * @var string
     */
    protected $message = 'File size exceeds allowed.';
}