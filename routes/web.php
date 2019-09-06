<?php

use ZFTInfo\Book\Http\Controllers\PHPInfoController;

Route::get('book', BookController::class.'@index');