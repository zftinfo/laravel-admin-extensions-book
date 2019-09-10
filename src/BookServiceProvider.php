<?php

namespace ZFTInfo\Book;

use Illuminate\Support\ServiceProvider;

use Encore\Admin\Admin;

use ZFTInfo\Book\Commands\InstallCommand;

class BookServiceProvider extends ServiceProvider
{

    protected $commands = [
        InstallCommand::class,
    ];

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

        $this->publishes([
            __DIR__ . '/../config/book.php' => config_path('book.php'),
        ]);

        if ($migrations = $extension->migrations()) {
            $this->loadMigrationsFrom($migrations);
        }
        
        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/zftinfo/book')],
                'book'
            );
        }
        
        $this->app->booted(function () {
            Book::routes(__DIR__.'/../routes/web.php');

            // Admin::css([
            //     'vendor/zftinfo/book/book.css'
            // ]);

            // Admin::js([
            //     'vendor/zftinfo/book/book.js'
            // ]);
        });
    }

    public function register()
    {
        $this->commands($this->commands);
    }
}