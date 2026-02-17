<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UserImportServices;

class ImportUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the user data from the csv file into database';

    /**
     * Execute the console command.
     */
    public function handle(UserImportServices $service)
    {
        try{
            $service->import($this->argument('file'));
            $this->info('User data impoted Successfully');
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
    }
}
