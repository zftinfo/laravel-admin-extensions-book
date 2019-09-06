<?php

namespace ZFTInfo\Book;

use Illuminate\Support\ServiceProvider;

use Encore\Admin\Admin;

class BookServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Book $extension)
    {
        if (! Book::boot()) {
            return ;
        }
        
        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'book');
        }
        
        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/zftinfo/book')],
                'book'
            );
        }
        
        $this->app->booted(function () {
            Book::routes(__DIR__.'/../routes/web.php');

            Admin::css([
                'vendor/zftinfo/book/book.css'
            ]);

            Admin::js([
                'vendor/zftinfo/book/book.js'
            ]);
        });
    }
}