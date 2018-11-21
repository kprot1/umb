<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class StringFinderRequestDto
 * @package Umb\Entity
 */
class StringFinderRequestDto
{
    /**
     * @var string
     */
    private $search;
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * StringFinderRequest constructor.
     * @param string $search
     * @param UploadedFile $file
     */
    public function __construct(string $search = '', ?UploadedFile $file = null)
    {
        $this->search = $search;
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getSearch(): string
    {
        return $this->search;
    }

    /**
     * @return UploadedFile | null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }
}