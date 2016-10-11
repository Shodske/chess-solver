<?php

namespace Khattab\Chess;


abstract class Solver
{
    /** @var Board */
    private $board;

    /** @var Piece[] */
    private $pieces = [];

    /**
     * Solve the problem and return the solution.
     * @return mixed
     */
    abstract public function solve();

    /**
     * Set the board to use for the problem.
     *
     * @param Board $board
     */
    public function setBoard(Board $board) {
        $this->board = $board;
    }

    /**
     * Get the board.
     *
     * @return Board
     */
    public function getBoard() {
        return $this->board;
    }

    /**
     * Set the pieces to use for the problem.
     *
     * @param Piece[] $pieces
     */
    public function setPieces(array $pieces) {
        $this->pieces = $pieces;
    }

    /**
     * Add a piece to use for the problem.
     *
     * @param Piece $piece
     */
    public function addPiece(Piece $piece) {
        $this->pieces[] = $piece;
    }

    /**
     * Get all the pieces.
     *
     * @return Piece[]
     */
    public function getPieces() {
        return $this->pieces;
    }
}