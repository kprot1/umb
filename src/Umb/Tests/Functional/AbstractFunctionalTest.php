<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AbstractFunctionalTest
 * @package Umb\Tests\Functional
 */
abstract class AbstractFunctionalTest extends TestCase
{
    protected const FILE_NAME_TXT = '1.txt';
    protected const FILE_NAME_PNG = '2.png';
    protected const FILE_NAME_CSV = '5.csv';

    protected const PATH_TO_TXT = __DIR__ . '/../../Resources/files/' . self::FILE_NAME_TXT;
    protected const PATH_TO_PNG = __DIR__ . '/../../Resources/files/' . self::FILE_NAME_PNG;
    protected const PATH_TO_CSV = __DIR__ . '/../../Resources/files/' . self::FILE_NAME_CSV;

    /**
     * @param string $path
     * @param string $fileName
     * @return UploadedFile
     */
    protected function getUploadedFile(string $path, string $fileName): UploadedFile
    {
        return new UploadedFile($path, $fileName);
    }
}