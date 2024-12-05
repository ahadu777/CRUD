<?php

namespace ahadu\crud;

use Illuminate\Support\ServiceProvider;
use ahadu\crud\commands\CrudCommand;

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
