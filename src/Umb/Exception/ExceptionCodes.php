<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Exception;

/**
 * Class ExceptionCodes
 * @package Umb\Exception
 */
class ExceptionCodes
{
    // Файл не найден
    public const FILE_NOT_FOUND = 1;
    // Размер файла превышает допустимый
    public const FILE_SIZE_EXCEEDS_ALLOWED = 2;
    // Строка, которую необходимо найти, пуста
    public const SEARCH_STRING_IS_EMPTY = 3;
    // Строка, которую необходимо найти, отсутствует в файле
    public const STRING_NOT_FOUND_IN_FILE = 4;
    // Файл неподдерживаемого расширения
    public const UNSUPPORTED_FILE_EXTENSION = 5;
    // Файл неподдерживаемого mimeType
    public const UNSUPPORTED_FILE_MIMETYPE = 6;
}