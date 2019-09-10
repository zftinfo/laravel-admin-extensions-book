<?php

use ZFTInfo\Book\Http\Controllers\BookController;
use ZFTInfo\Book\Http\Controllers\AuthorController;
use ZFTInfo\Book\Http\Controllers\PublisherController;

#Route::get('book', BookController::class.'@index');

Route::resource('book',  BookController::class);

Route::resource('author',  AuthorController::class);

Route::resource('publisher',  PublisherController::class);