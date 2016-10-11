<?php

namespace Khattab\Chess;

use Khattab\Application\Application as BaseApplication;
use Khattab\Chess\Piece\Queen;
use Khattab\Chess\Solver\AllSafeSolver;

class Application extends BaseApplication
{

    public function run() {
        $width = $this->getParam('width');
        $height = $this->getParam('height');
        $queens = $this->getParam('queens');

        $solver = new AllSafeSolver();
        $solver->setBoard(new Board($width, $height));
        for ($n = 0; $n < $queens; $n++) {
            $solver->addPiece(new Queen());
        }

        echo $solver->solve();
    }
}