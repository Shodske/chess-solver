<?php

namespace Khattab\Chess;

use Khattab\Application\Application as BaseApplication;
use Khattab\Chess\Piece\Queen;
use Khattab\Chess\Solver\AllSafeSolver;

class Application extends BaseApplication
{

    protected function run() {
        $width = $this->getParam('width', 0);
        $height = $this->getParam('height', 0);
        $queens = $this->getParam('queens', 0);

        $solver = new AllSafeSolver();
        $solver->setBoard(new Board($width, $height));
        for ($n = 0; $n < $queens; $n++) {
            $solver->addPiece(new Queen());
        }

        $this->setView('solutions');

        return [
            'solutions' => $solver->solve(),
            'width'     => $width,
            'height'    => $height,
            'queens'    => $queens,
        ];
    }
}