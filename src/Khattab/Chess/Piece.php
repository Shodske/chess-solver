<?php

namespace Khattab\Chess;


abstract class Piece
{
    protected $name;

    private $x;
    private $y;

    public function getName() {
        return $this->name;
    }

    public function setPosition($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

    abstract function markUnsafe(Board $board);
}