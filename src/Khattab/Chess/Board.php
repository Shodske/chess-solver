<?php

namespace Khattab\Chess;

class Board
{
    const FIELD_UNSAFE = -1;
    const FIELD_SAFE = 0;
    const FIELD_OCCUPIED = 1;

    /** @var int[][] */
    private $fields;

    /** @var int */
    private $width;
    /** @var int */
    private $height;

    /**
     * Board constructor, takes width and height of the board as parameters.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;

        $this->reset();
    }

    /**
     * Initializes the fields as a 2D array with all empty fields.
     */
    public function reset() {
        $this->fields = array_fill(0, $this->getWidth(), array_fill(0, $this->getHeight(), self::FIELD_SAFE));
    }

    /**
     * Get the width of the board.
     *
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Get the height of the board.
     *
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Get the width and height of the board as an array.
     *
     * @return int[]
     */
    public function getDimensions() {
        return [
            'width'  => $this->getWidth(),
            'height' => $this->getHeight(),
        ];
    }

    /**
     * Set the status of a field.
     *
     * @param int $x
     * @param int $y
     * @param int $status FIELD_UNSAFE|FIELD_SAFE|FIELD_OCCUPIED
     */
    public function setFieldStatus($x, $y, $status) {
        $this->fields[$x][$y] = $status;
    }

    /**
     * Get the status of a field.
     *
     * @param  int $x
     * @param  int $y
     * @return int FIELD_UNSAFE|FIELD_SAFE|FIELD_OCCUPIED
     */
    public function getFieldStatus($x, $y) {
        return $this->fields[$x][$y];
    }

    /**
     * Return a string representation of the board.
     *
     * @return string
     */
    public function __toString() {
        $boardString = '';
        for ($y = 0; $y < $this->getHeight(); $y++) {
            $rowString = '';
            for ($x = 0; $x < $this->getWidth(); $x++) {
                switch ($this->getFieldStatus($x, $y)) {
                    case self::FIELD_OCCUPIED:
                        $rowString .= 'O';
                        break;
                    case self::FIELD_SAFE:
                        $rowString .= ' ';
                        break;
                    case self::FIELD_UNSAFE:
                        $rowString .= 'X';
                        break;
                }
            }
            $boardString .= PHP_EOL . $rowString;
        }

        return $boardString;
    }
}