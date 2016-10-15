<?php

require_once '../src/Khattab/Application/AutoLoader.php';

use Khattab\Application\AutoLoader;
use Khattab\Chess\Application;

$autoLoader = new AutoLoader();
$autoLoader->register();

$app = new Application();
$app->start();
