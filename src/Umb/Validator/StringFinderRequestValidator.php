<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Umb\Entity\StringFinderRequestDto;
use Umb\Exception\FileNotFoundException;
use Umb\Exception\FileSizeExceedsAllowedException;
use Umb\Exception\SearchStringIsEmptyException;
use Umb\Exception\UnsupportedFileExtensionException;
use Umb\Exception\UnsupportedFileMimeTypeException;

/**
 * Class StringFinderRequestValidator
 * @package Umb\Validator
 */
class StringFinderRequestValidator
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var int
     */
    private $maxFileSize;

    /**
     * @var array
     */
    private $mimeTypes;

    /**
     * @var array
     */
    private $extensions;

    /**
     * StringFinderRequestValidator constructor.
     * @param int $maxFileSize
     * @param array $mimeTypes
     * @param array $extensions
     */
    public function __construct(int $maxFileSize, array $mimeTypes, array $extensions)
    {
        $this->maxFileSize = $maxFileSize;
        $this->mimeTypes = $mimeTypes;
        $this->extensions = $extensions;
    }

    /**
     * @param StringFinderRequestDto $request
     * @return StringFinderRequestValidator
     */
    public function validate(StringFinderRequestDto $request): self
    {
        try {

            if (empty($request->getSearch())) {
                throw new SearchStringIsEmptyException();
            }
            $file = $request->getFile();
            if (!$file instanceof UploadedFile) {
                throw new FileNotFoundException();
            }
            if ($file->getSize() > $this->maxFileSize) {
                throw new FileSizeExceedsAllowedException();
            }
            if (!in_array($file->getMimeType(), $this->mimeTypes, true)) {
                throw new UnsupportedFileMimeTypeException();
            }
            if (!in_array($file->getClientOriginalExtension(), $this->extensions, true)) {
                throw new UnsupportedFileExtensionException();
            }

        } catch (\DomainException $exception) {
            $this->errors[] = $exception->getMessage();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}