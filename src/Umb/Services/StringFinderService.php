<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Umb\Entity\StringFinderResponseDto;
use Umb\Exception\FileNotFoundException;
use Umb\Exception\SearchStringIsEmptyException;
use Umb\Exception\UnsupportedFileExtensionException;
use Umb\Strategies\Interfaces\StringFinderStrategyInterface;

/**
 * Class StringFinderService
 * @package Umb\Services
 */
class StringFinderService
{
    /**
     * @var StringFinderStrategyInterface[]
     */
    private $finderStrategies;

    /**
     * @param string $search
     * @param UploadedFile $file
     *
     * @return StringFinderResponseDto
     *
     * @throws FileNotFoundException
     * @throws UnsupportedFileExtensionException
     */
    public function find(string $search, UploadedFile $file): StringFinderResponseDto
    {
        if (empty($search)) {
            throw new SearchStringIsEmptyException();
        }

        $mimeType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();

        foreach ($this->finderStrategies as $finderStrategy) {
            if ($finderStrategy->support($mimeType, $extension)) {
                return $finderStrategy->find($search, $file);
            }
        }
        throw new UnsupportedFileExtensionException();
    }

    /**
     * @param StringFinderStrategyInterface $finderStrategy
     */
    public function addFinderStrategy(StringFinderStrategyInterface $finderStrategy): void
    {
        $this->finderStrategies [] = $finderStrategy;
    }
}