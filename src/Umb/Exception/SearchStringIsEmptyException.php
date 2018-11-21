<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Exception;

/**
 * Class SearchStringIsEmptyException
 * @package Umb\Exception
 */
class SearchStringIsEmptyException extends \DomainException
{
    /**
     * @var int
     */
    protected $code = ExceptionCodes::SEARCH_STRING_IS_EMPTY;

    /**
     * @var string
     */
    protected $message = 'Search string is empty.';
}