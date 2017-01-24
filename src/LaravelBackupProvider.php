<?php

namespace Yk\LaravelBackup;

use Illuminate\Support\ServiceProvider;

class LaravelBackupProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Register commands, so you may execute them using the Artisan CLI.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Yk\LaravelBackup\App\Console\Commands\BackupExport::class,
                \Yk\LaravelBackup\App\Console\Commands\BackupImport::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {


    }
}
