<?php

namespace Khattab\Chess\Solver;


use Khattab\Chess\Board;
use Khattab\Chess\Piece;
use Khattab\Chess\Solver;

class AllSafeSolver extends Solver
{
    /**
     * Solve the problem and return the solution.
     *
     * @return string[]
     */
    public function solve() {
        $solutions = [];

        $board = $this->getBoard();
        $pieces = $this->getPieces();

        // if we have no pieces or a board is missing a height or width, there
        // won't be any solutions
        if (empty($pieces) || $board->getHeight() * $board->getWidth() == 0) {
            return [];
        }

        // give all the pieces an initial position
        foreach ($pieces as $i => $piece) {
            $piece->setPosition(0, 0);
        }

        do {
            // reset the board
            $board->reset();

            // we want to put all the pieces back 1 step, except for the last
            // piece (last 2 pieces if the last one is on the last field),
            // because solveNext() will always try to find a safe field starting
            // from the piece's next position
            $stepBackFrom = (end($pieces)->getX() == $board->getWidth() - 1 && end($pieces)->getY() == $board->getHeight() - 1)
                        ? 1 : 0;
            foreach ($pieces as $i => $piece) {
                $piece->setCoveredFields([]);
                if ($i <= $stepBackFrom) {
                    $piece->setPosition($pieces[$stepBackFrom]->getX(), $pieces[$stepBackFrom]->getY());
                } else {
                    $piece->setPosition($piece->getX() - 1, $piece->getY());
                }
            }
        } while ($solutions[] = $this->solveNext($board, $pieces));

        // remove the last empty solution;
        array_pop($solutions);

        return $solutions;
    }

    /**
     * @param Board $board
     * @param Piece[] $pieces
     * @return null|string
     */
    private function solveNext(Board $board, array $pieces) {
        $placedPieces = [];

        while (!empty($pieces)) {
            $piece = array_pop($pieces);

            // we want to start checking for save fields starting from the next
            // field
            if ($piece->getX() == $board->getWidth() - 1) {
                $x = 0;
                $y = $piece->getY() + 1;
            } else {
                $x = $piece->getX() + 1;
                $y = $piece->getY();
            }

            // if all possible spots have been tried for this piece and there is
            // no safe place, we want to continue trying to find a solution with
            // the previously placed piece
            if ($y == $board->getHeight()
                || is_null($field = $this->findSafeField($board, $x, $y))
                // even if we find a safe field, if its before the
                || (!empty($placedPieces)
                && (end($placedPieces)->getX() + end($placedPieces)->getY() * $board->getWidth())
                > ($field['x'] + $field['y'] * $board->getWidth()))

            ) {
                // if no pieces have been placed yet, it means we've exhausted
                // all possibilities
                if (empty($placedPieces)) {
                    return null;
                }

                // set the piece position to the position of the first placed
                // piece, so we can start finding a new safe position when we
                // get to this piece again
                $piece->setPosition($placedPieces[0]->getX(), $placedPieces[0]->getY());

                // remove the previous piece from the placed pieces array and
                // put it back in the pieces array, so we can start to find a
                // new safe place for it
                $prevPiece = array_pop($placedPieces);
                $board->setFieldStatus($prevPiece->getX(), $prevPiece->getY(), Board::FIELD_SAFE);
                $prevPiece->unmarkCoveredFields($board);

                array_push($pieces, $piece);
                array_push($pieces, $prevPiece);

                continue;
            }

            // place the piece
            $piece->setPosition($field['x'], $field['y']);
            $board->setFieldStatus($piece->getX(), $piece->getY(), Board::FIELD_OCCUPIED);
            // mark the covered fields on the board
            $piece->markCoveredFields($board);

            array_push($placedPieces, $piece);
        }

        // for now we return the solution as a string representation of the board
        return (string) $board;
    }

    /**
     * Find a safe field on given board, starting from given coordinates.
     *
     * @param Board $board
     * @param int   $startX
     * @param int   $startY
     * @return array|null
     */
    private function findSafeField(Board $board, $startX = 0, $startY = 0) {
        for ($y = $startY; $y < $board->getHeight(); $y++) {
            for ($x = !is_null($startX) ? $startX : 0; $x < $board->getWidth(); $x++) {
                if ($board->getFieldStatus($x, $y) == Board::FIELD_SAFE) {
                    return ['x' => $x, 'y' => $y];
                }
            }
            $startX = null;
        }

        return null;
    }
}

