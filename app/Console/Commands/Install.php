<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command d\'installation de kdpackage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output = $this->getOutput();
        $output->info("Start install KDPackage");
        $output->title("Create database");
        $res = $this->call("app:createDb");
        if($res > 0) {
            $output->error("Create database done with error !!! stop install !!");
            return 1;
        }
        $output->title("Launch Migration");
        $this->call("migrate");
        $output->title("Launch Seed");
        $this->call("db:seed",[
            'Database\Seeders\DatabaseSeeder'
        ]);
        return 0;
    }
}
