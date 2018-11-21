<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Tests\Functional;

use Umb\Entity\StringFinderRequestDto;
use Umb\Exception\FileNotFoundException;
use Umb\Exception\FileSizeExceedsAllowedException;
use Umb\Exception\SearchStringIsEmptyException;
use Umb\Exception\UnsupportedFileExtensionException;
use Umb\Exception\UnsupportedFileMimeTypeException;
use Umb\Validator\StringFinderRequestValidator;

/**
 * Class StringFinderRequestValidatorTest
 * @package Umb\Tests\Functional
 */
class StringFinderRequestValidatorTest extends AbstractFunctionalTest
{
    public function testNegativeEmptySearch(): void
    {
        $file = $this->getUploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV);
        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([
                (new SearchStringIsEmptyException())->getMessage()
            ],
            $errors
        );
    }

    public function testNegativeEmptyFile(): void
    {
        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('asdf', null);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([
                (new FileNotFoundException())->getMessage()
            ],
            $errors
        );

        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('asdf');
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([
            (new FileNotFoundException())->getMessage()
        ],
            $errors
        );
    }

    public function testNegativeEmptyStringAndFile(): void
    {
        $validator = $this->createBaseValidator();
        $requetsDto = new StringFinderRequestDto();
        $errors = $validator->validate($requetsDto)->getErrors();
        $this->assertEquals(
            [
                (new SearchStringIsEmptyException())->getMessage()
            ],
            $errors
        );

    }

    public function testPositiveForCsv(): void
    {
        $file = $this->getUploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV);

        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([], $errors);

        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('asdfasdfasdfasdfas', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([], $errors);
    }

    public function testPositiveForTxt(): void
    {
        $file =  $this->getUploadedFile(self::PATH_TO_TXT, self::FILE_NAME_TXT);

        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([], $errors);

        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('absa', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([], $errors);
    }

    public function testPositiveForPng(): void
    {
        $file = $this->getUploadedFile(self::PATH_TO_PNG, self::FILE_NAME_PNG);

        $validator = $this->createBaseValidator();
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals(
            [
                (new UnsupportedFileMimeTypeException())->getMessage()
            ],
            $errors
        );
    }

    public function testNegativeMaxSize(): void
    {
        $exceptionMessage = (new FileSizeExceedsAllowedException())->getMessage();

        $file = $this->getUploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV);
        $validator = $this->createValidatorWithLowMaxSize();
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);

        $file = $this->getUploadedFile(self::PATH_TO_TXT, self::FILE_NAME_TXT);
        $validator = $this->createValidatorWithLowMaxSize();
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);

        $file = $this->getUploadedFile(self::PATH_TO_PNG, self::FILE_NAME_PNG);
        $validator = $this->createValidatorWithLowMaxSize();
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);
    }

    public function testNegativeUnsupportedMimeTypes(): void
    {
        $exceptionMessage = (new UnsupportedFileMimeTypeException())->getMessage();

        $file = $this->getUploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV);
        $validator = new StringFinderRequestValidator(1000, ['image/png'], ['csv', 'txt', 'png']);
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);

        $file = $this->getUploadedFile(self::PATH_TO_TXT, self::PATH_TO_TXT);
        $validator = new StringFinderRequestValidator(1000, ['text/csv', 'image/png'], ['csv', 'txt', 'png']);
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);

        $file = $this->getUploadedFile(self::PATH_TO_PNG, self::FILE_NAME_PNG);
        $validator = new StringFinderRequestValidator(100000, ['text/csv', 'text/plain'], ['csv', 'txt', 'png']);
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);
    }

    public function testNegativeUnsupportedExtensions(): void
    {
        $exceptionMessage = (new UnsupportedFileExtensionException())->getMessage();

        $file = $this->getUploadedFile(self::PATH_TO_CSV, self::FILE_NAME_CSV);
        $validator = new StringFinderRequestValidator(1000, ['text/csv', 'text/plain', 'image/png'], ['txt', 'png']);
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);

        $file = $this->getUploadedFile(self::PATH_TO_TXT, self::FILE_NAME_TXT);
        $validator = new StringFinderRequestValidator(1000, ['text/csv', 'text/plain', 'image/png'], ['csv', 'png']);
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);

        $file = $this->getUploadedFile(self::PATH_TO_PNG, self::FILE_NAME_PNG);
        $validator = new StringFinderRequestValidator(100000, ['text/csv', 'text/plain', 'image/png'], ['csv', 'txt']);
        $requestDto = new StringFinderRequestDto('a', $file);
        $errors = $validator->validate($requestDto)->getErrors();
        $this->assertEquals([$exceptionMessage], $errors);
    }

    /**
     * @return StringFinderRequestValidator
     */
    private function createBaseValidator(): StringFinderRequestValidator
    {
        return new StringFinderRequestValidator(100000, ['text/csv', 'text/plain'], ['csv', 'txt']);
    }

    /**
     * @return StringFinderRequestValidator
     */
    private function createValidatorWithLowMaxSize(): StringFinderRequestValidator
    {
        return new StringFinderRequestValidator(0, ['text/csv', 'text/plain'], ['csv', 'txt']);
    }
}
