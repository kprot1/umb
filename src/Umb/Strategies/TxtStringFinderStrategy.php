<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Strategies;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Umb\Entity\StringFinderResponseDto;
use Umb\Exception\StringNotFoundException;
use Umb\Strategies\Interfaces\StringFinderStrategyInterface;

/**
 * Class TxtStringFinderStrategy
 * @package Umb\Strategies
 */
class TxtStringFinderStrategy implements StringFinderStrategyInterface
{
    /**
     * @param string $search
     * @param UploadedFile $file
     *
     * @return StringFinderResponseDto
     */
    public function find(string $search, UploadedFile $file): StringFinderResponseDto
    {
        $handler = fopen($file, 'r');

        foreach ($this->readFile($handler) as $index => $stringIterator) {
            $position = strpos($stringIterator, $search);
            if ($position !== false) {
                fclose($handler);
                return new StringFinderResponseDto(++$index, ++$position);
            }
        }
        fclose($handler);
        throw new StringNotFoundException();
    }

    /**
     * @param string $mimeType
     * @param string $extension
     * @return bool
     */
    public function support(string $mimeType, string $extension): bool
    {
        return $mimeType === 'text/plain' && $extension === 'txt';
    }

    /**
     * @param resource $handler
     * @return \Generator
     */
    private function readFile($handler): ?\Generator
    {
        while(!feof($handler)) {
            yield trim(fgets($handler));
        }
    }
}