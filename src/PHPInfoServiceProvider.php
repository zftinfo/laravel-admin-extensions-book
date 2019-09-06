<?php

namespace ZFTInfo\PHPInfo;

use Illuminate\Support\ServiceProvider;

use Encore\Admin\Admin;

class PHPInfoServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(PHPInfo $extension)
    {
        if (! PHPInfo::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'phpinfo');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/zftinfo/phpinfo')],
                'phpinfo'
            );
        }

        $this->app->booted(function () {
            PHPInfo::routes(__DIR__.'/../routes/web.php');

            Admin::css([
                'vendor/zftinfo/phpinfo/phpinfo.css'
            ]);

            Admin::js([
                'vendor/zftinfo/phpinfo/phpinfo.js'
            ]);
        });
    }
}