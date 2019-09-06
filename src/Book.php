<?php

namespace ZFTInfo\Book;

use Encore\Admin\Extension;

class Book extends Extension
{
    public $name = 'book';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Book',
        'path'  => 'book',
        'icon'  => 'fa-gears',
    ];
}