<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Form;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MainForm
 * @package Umb\Form
 */
class MainForm
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
     * @return string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param string $search
     */
    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }
}