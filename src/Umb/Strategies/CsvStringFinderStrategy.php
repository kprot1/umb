<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 20.11.2018
 */

namespace Umb\Strategies;

use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Umb\Entity\StringFinderResponseDto;
use Umb\Exception\StringNotFoundException;
use Umb\Strategies\Interfaces\StringFinderStrategyInterface;

/**
 * Class CsvStringFinderStrategy
 * @package Umb\Strategies
 */
class CsvStringFinderStrategy implements StringFinderStrategyInterface
{
    /**
     * @param string $search
     * @param UploadedFile $file
     *
     * @return StringFinderResponseDto
     * @throws \League\Csv\Exception
     */
    public function find(string $search, UploadedFile $file): StringFinderResponseDto
    {
        $handler = fopen($file, 'r');
        $reader = Reader::createFromStream($handler);
        $reader->setDelimiter(';');

        foreach ($reader->getRecords() as $index => $list) {
            $position = strpos(implode($list), $search);
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
     *
     * @return bool
     */
    public function support(string $mimeType, string $extension): bool
    {
        return $mimeType === 'text/plain' && $extension === 'csv';
    }
}