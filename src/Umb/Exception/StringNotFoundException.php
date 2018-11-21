<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Exception;

/**
 * Class StringNotFoundException
 * @package Umb\Exception
 */
class StringNotFoundException extends \DomainException
{
    /**
     * @var int
     */
    protected $code = ExceptionCodes::STRING_NOT_FOUND_IN_FILE;

    /**
     * @var string
     */
    protected $message = 'String not found.';
}