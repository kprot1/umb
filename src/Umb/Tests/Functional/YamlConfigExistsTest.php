<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Tests\Functional;

use PHPUnit\Framework\TestCase;

/**
 * Class YamlConfigExistsTest
 * @package Umb\Tests\Functional
 */
class YamlConfigExistsTest extends TestCase
{
    private const PATH_TO_FILE = __DIR__ . '/../../Resources/config/string_finder.yaml';

    public function testConfigExists()
    {
        $this->assertFileExists(self::PATH_TO_FILE);
    }

    public function testConfigReadable()
    {
        $this->assertFileIsReadable(self::PATH_TO_FILE);
    }
}
