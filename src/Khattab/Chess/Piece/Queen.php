<?php

namespace Khattab\Chess\Piece;

use Khattab\Chess\Board;
use Khattab\Chess\Piece;

class Queen extends Piece
{
    protected $name = 'Queen';

    /**
     * Queens can go in a straight line in the directions left, right, up, down,
     * diagonally left-up, left-down, right-up, right-down. We mark all the
     * fields as unsafe that this queen can reach.
     *
     * @param Board $board
     */
    function markUnsafe(Board $board) {
        $x = $this->getX();
        $y = $this->getY();
        $height = $board->getHeight();
        $width  = $board->getWidth();

        for ($offset = 1; $offset < max($board->getDimensions()); $offset++) {
            $left  = $x - $offset;
            $right = $x + $offset;
            $up    = $y + $offset;
            $down  = $y - $offset;
            $canMoveLeft  = $left  >= 0;
            $canMoveRight = $right <  $width;
            $canMoveDown  = $down  >= 0;
            $canMoveUp    = $up    <  $height;

            if ($canMoveLeft) {
                if ($board->getFieldStatus($left, $y) == Board::FIELD_SAFE) {
                    $board->setFieldStatus($left, $y, Board::FIELD_UNSAFE);
                }

                if ($canMoveDown && $board->getFieldStatus($left, $down) == Board::FIELD_SAFE) {
                    $board->setFieldStatus($left, $down, Board::FIELD_UNSAFE);
                }

                if ($canMoveUp && $board->getFieldStatus($left, $up) == Board::FIELD_SAFE) {
                    $board->setFieldStatus($left, $up, Board::FIELD_UNSAFE);
                }
            }

            if ($canMoveRight) {
                if ($board->getFieldStatus($right, $y) == Board::FIELD_SAFE) {
                    $board->setFieldStatus($right, $y, Board::FIELD_UNSAFE);
                }

                if ($canMoveDown && $board->getFieldStatus($right, $down) == Board::FIELD_SAFE) {
                    $board->setFieldStatus($right, $down, Board::FIELD_UNSAFE);
                }

                if ($canMoveUp && $board->getFieldStatus($right, $up) == Board::FIELD_SAFE) {
                    $board->setFieldStatus($right, $up, Board::FIELD_UNSAFE);
                }
            }

            if ($canMoveDown && $board->getFieldStatus($x, $down) == Board::FIELD_SAFE) {
                $board->setFieldStatus($x, $down, Board::FIELD_UNSAFE);
            }

            if ($canMoveUp && $board->getFieldStatus($x, $up) == Board::FIELD_SAFE) {
                $board->setFieldStatus($x, $up, Board::FIELD_UNSAFE);
            }
        }
    }
}