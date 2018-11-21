<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Tests\Functional;

/**
 * Class FilesForTestingExistsTest
 * @package Umb\Tests\Functional
 */
class FilesForTestingExistsTest extends AbstractFunctionalTest
{
    public function testCsvExists(): void
    {
        $this->assertFileExists(self::PATH_TO_CSV);
        $this->assertFileIsReadable(self::PATH_TO_CSV);
    }

    public function testTxtExists(): void
    {
        $this->assertFileExists(self::PATH_TO_TXT);
        $this->assertFileIsReadable(self::PATH_TO_TXT);
    }

    public function testPngExists(): void
    {
        $this->assertFileExists(self::PATH_TO_PNG);
        $this->assertFileIsReadable(self::PATH_TO_PNG);
    }
}
