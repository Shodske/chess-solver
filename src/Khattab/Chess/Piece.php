<?php

namespace Khattab\Chess;

/**
 * Abstract class representing a chess piece.
 */
abstract class Piece
{
    /** @var string */
    protected $name;

    /** @var int */
    private $x;
    /** @var int */
    private $y;

    /** @var array */
    private $coveredFields = [];

    /**
     * Return the name of this chess piece.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the position on the board of this piece.
     *
     * @param int $x
     * @param int $y
     */
    public function setPosition($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * Get the x position of this piece.
     *
     * @return int
     */
    public function getX() {
        return $this->x;
    }

    /**
     * Get the y position of this piece.
     *
     * @return int
     */
    public function getY() {
        return $this->y;
    }

    /**
     * Set which fields this piece covers on the board.
     *
     * @param array $fields
     */
    public function setCoveredFields(array $fields) {
        $this->coveredFields = $fields;
    }

    /**
     * Add field at position ($x, $y) as being covered by this piece.
     *
     * @param int $x
     * @param int $y
     */
    public function addCoveredField($x, $y) {
        $this->coveredFields[] = ['x' => $x, 'y' => $y];
    }

    /**
     * Get all the fields covered by this piece.
     *
     * @return array
     */
    public function getCoveredFields() {
        return $this->coveredFields;
    }

    /**
     * Unmark all the fields covered by this piece on given board.
     *
     * @param Board $board
     */
    public function unmarkCoveredFields(Board $board) {
        foreach ($this->coveredFields as $field) {
            $board->setFieldStatus($field['x'], $field['y'], Board::FIELD_SAFE);
        }

        $this->setCoveredFields([]);
    }

    /**
     * Mark all the fields covered by this piece on given board. This should be
     * implemented by specific pieces as they know what their movement is.
     *
     * @param Board $board
     * @return mixed
     */
    abstract public function markCoveredFields(Board $board);
}