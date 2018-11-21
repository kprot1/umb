<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Exception;

/**
 * Class FileNotFoundException
 * @package Umb\Exception
 */
class FileNotFoundException extends \DomainException
{
    /**
     * @var int
     */
    protected $code = ExceptionCodes::FILE_NOT_FOUND;

    /**
     * @var string
     */
    protected $message = 'File not found.';
}