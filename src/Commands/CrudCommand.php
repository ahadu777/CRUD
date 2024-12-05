<?php

namespace ahadu\crud\Commands;

use Illuminate\Console\Command;

class CrudCommand extends Command
{
    protected $signature = 'make:crud';
    protected $description = 'pass model name and columns with data types then it generates starter files';

    public function handle()
    {
        $this->info('Ahadu CRUD command executed successfully!');
    }
}
