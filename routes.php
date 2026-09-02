<?php

use Http\Controllers\IndexController;
// testing route
$router->get('/', [IndexController::class, 'index']);
