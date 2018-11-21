<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Tests\Functional;

use Umb\Entity\StringFinderResponseDto;
use Umb\Exception\ExceptionCodes;
use Umb\Services\StringFinderService;
use Umb\Strategies\CsvStringFinderStrategy;
use Umb\Strategies\TxtStringFinderStrategy;

/**
 * Class StringFinderServiceTest
 * @package Umb\Tests\Functional
 */
class StringFinderServiceTest extends AbstractFunctionalTest
{
    /**
     * @var StringFinderService | null
     */
    private $stringFinderService;

    /**
     * StringFinderServiceTest constructor.
     *
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->stringFinderService = new StringFinderService();
        $this->stringFinderService->addFinderStrategy(new CsvStringFinderStrategy());
        $this->stringFinderService->addFinderStrategy(new TxtStringFinderStrategy());
    }

    public function testStringFinderServiceNotNull(): void
    {
        $this->assertNotNull($this->stringFinderService);
        $this->assertInstanceOf(StringFinderService::class, $this->stringFinderService);
    }

    public function testPositiveForCsv(): void
    {
        $file = $this->getUploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV);

        $search = 'aute';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(1, $responseDto->getLine());
        $this->assertEquals(5, $responseDto->getPosition());

        $search = 'suscipit';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(4, $responseDto->getLine());
        $this->assertEquals(10, $responseDto->getPosition());

        $search = 'jj';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(5, $responseDto->getLine());
        $this->assertEquals(18, $responseDto->getPosition());

        $search = 'j';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(4, $responseDto->getLine());
        $this->assertEquals(23, $responseDto->getPosition());
    }

    public function testNegativeForCsv(): void
    {
        $file =  $this->getUploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV);

        $codeException = null;
        try {
            $this->stringFinderService->find('', $file);
        } catch (\Exception $exception) {
            $codeException = $exception->getCode();
        }
        $this->assertEquals(ExceptionCodes::SEARCH_STRING_IS_EMPTY, $codeException);

        $codeException = null;
        try {
            $this->stringFinderService->find('asdfasdjkfhaskdljfhasdkjlfhasdkljfahsdkljfasd', $file);
        } catch (\Exception $exception) {
            $codeException = $exception->getCode();
        }
        $this->assertEquals(ExceptionCodes::STRING_NOT_FOUND_IN_FILE, $codeException);
    }

    public function testPositiveForTxt(): void
    {
        $file = $this->getUploadedFile(self::PATH_TO_TXT, self::FILE_NAME_TXT);

        $search = 'D';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(1, $responseDto->getLine());
        $this->assertEquals(1, $responseDto->getPosition());

        $search = 'der';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(2, $responseDto->getLine());
        $this->assertEquals(9, $responseDto->getPosition());

        $search = 'sit';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(6, $responseDto->getLine());
        $this->assertEquals(19, $responseDto->getPosition());

        $search = 'laboris';
        $responseDto = $this->stringFinderService->find($search, $file);
        $this->assertInstanceOf(StringFinderResponseDto::class, $responseDto);
        $this->assertEquals(10, $responseDto->getLine());
        $this->assertEquals(35, $responseDto->getPosition());

    }

    public function testNegativeForTxt(): void
    {
        $file =  $this->getUploadedFile(self::PATH_TO_TXT, self::FILE_NAME_TXT);

        $codeException = null;
        try {
            $this->stringFinderService->find('', $file);
        } catch (\Exception $exception) {
            $codeException = $exception->getCode();
        }
        $this->assertEquals(ExceptionCodes::SEARCH_STRING_IS_EMPTY, $codeException);

        $codeException = null;
        try {
            $this->stringFinderService->find('asdfasdjkfhaskdljfhasdkjlfhasdkljfahsdkljfasd', $file);
        } catch (\Exception $exception) {
            $codeException = $exception->getCode();
        }
        $this->assertEquals(ExceptionCodes::STRING_NOT_FOUND_IN_FILE, $codeException);
    }

    public function testPositiveForPng(): void
    {
        $file = $this->getUploadedFile(self::PATH_TO_PNG, self::FILE_NAME_PNG);

        $codeException = null;
        try {
            $this->stringFinderService->find('123', $file);
        } catch (\Exception $exception) {
            $codeException = $exception->getCode();
        }
        $this->assertEquals(ExceptionCodes::UNSUPPORTED_FILE_EXTENSION, $codeException);
    }
}
