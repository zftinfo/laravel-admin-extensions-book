<?php

use ZFTInfo\Book\Http\Controllers\BookController;

Route::get('book', BookController::class.'@index');