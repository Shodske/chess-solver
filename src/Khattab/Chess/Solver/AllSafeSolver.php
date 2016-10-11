<?php

namespace Khattab\Chess\Solver;


use Khattab\Chess\Solver;

class AllSafeSolver extends Solver
{

    /**
     * Solve the problem and return the solution.
     * @return mixed
     */
    public function solve() {
        $board = $this->getBoard();
        $pieces = $this->getPieces();

        for ($x = 0; $x < $board->getWidth(); $x++) {
            for ($y = 0; $y < $board->getHeight(); $y++) {

            }
        }

        return null;
    }
}