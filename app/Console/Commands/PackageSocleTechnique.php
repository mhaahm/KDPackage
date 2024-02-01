<?php

namespace App\Console\Commands;

use App\Services\SocleTechnique;
use App\Services\Utils;
use Illuminate\Console\Command;

class PackageSocleTechnique extends Command
{

    public function __construct(public SocleTechnique $socleTechnique, private Utils $utils)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:socle {--platform=windows}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command de création du package socle technique';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->socleTechnique->setOutput($this->output);
        $platform = strtolower($this->option('platform'));
        $this->output->info('Start creation ');
        switch ($platform)
        {
            case 'windows':
                $this->socleTechnique->createWindowsPackage();
                break;
            case 'linux':
                $this->socleTechnique->createLinuxPackage();
                break;
        }

    }
}
