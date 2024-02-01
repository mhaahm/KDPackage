<?php

namespace App\Console\Commands;

use App\Services\SocleTechnique;
use App\Services\Utils;
use Illuminate\Console\Command;

class PackageGlobal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:global';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command de génération du package global';

    public function __construct(private Utils $utils)
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // create folder
        $this->output->title("Create package global");
        $this->output->info("Create package folders for windows platform");
        $this->utils->createPackageSocleTechniqueDir('windows');
        $this->output->info("Create package folders for windows linux");
        $this->utils->createPackageSocleTechniqueDir('linux');
        $this->output->title("Create package socle technique windows");
        $this->call("package:socle",[
            '--platform' => 'windows'
        ]);
        $this->output->title("Create package socle technique linux");
        $this->call("package:socle",[
            '--platform' => 'linux '
        ]);

    }
}
