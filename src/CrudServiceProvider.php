<?php

namespace ahadu\crud;

use ahadu\crud\Commands\CrudCommand;
use Illuminate\Support\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            CrudCommand::class,
        ]);
    }

    public function boot()
    {
    }
}
