<?php

namespace ZFTInfo\Book\Http\Controllers;

use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

use ZFTInfo\Book\Book;
use Illuminate\Support\Arr;

class BookController extends Controller
{
    public function index(Content $content, Book $book)
    {
    	$infos = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => Arr::get($_SERVER, 'SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],

            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];
        return $content
            ->title('Title')
            ->description('Description')
            ->body(view('book::index', compact('infos')));
    }
}