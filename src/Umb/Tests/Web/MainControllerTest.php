<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Tests\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MainControllerTest
 * @package Umb\Tests\Web
 */
class MainControllerTest extends WebTestCase
{
    private const FILE_NAME_CSV = '5.csv';
    private const PATH_TO_CSV = __DIR__ . '/../../Resources/files/' . self::FILE_NAME_CSV;


    public function testMainAction(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/main',
            [
                'search' => 'alau'
            ],
            [
                'file' => new UploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV)
            ]
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
