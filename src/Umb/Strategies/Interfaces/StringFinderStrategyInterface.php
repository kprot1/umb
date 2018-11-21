<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Strategies\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Umb\Entity\StringFinderResponseDto;

/**
 * Interface StringFinderStrategyInterface
 * @package Umb\Strategies\Interfaces
 */
interface StringFinderStrategyInterface
{
    /**
     * @param string $search
     * @param UploadedFile $file
     *
     * @return StringFinderResponseDto
     */
    public function find(string $search, UploadedFile $file): StringFinderResponseDto;

    /**
     * @param string $mimeType
     * @param string $extension
     * @return bool
     */
    public function support(string $mimeType, string $extension): bool;
}