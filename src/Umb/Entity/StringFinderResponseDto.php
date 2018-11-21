<?php
/**
 * Created by PhpStorm.
 * User: kprot
 * Date: 21.11.2018
 */

namespace Umb\Entity;

/**
 * Class StringFinderResponseDto
 * @package Umb\Entity
 */
class StringFinderResponseDto
{
    /**
     * @var int
     */
    private $line;

    /**
     * @var int
     */
    private $position;

    /**
     * StringFinderResponseDto constructor.
     *
     * @param int $line
     * @param int $position
     */
    public function __construct(int $line, int $position)
    {
        $this->line = $line;
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
}