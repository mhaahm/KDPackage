<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KdDeposit;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $deposits = [
            [
                'deposit_name' => 'scripts',
                'deposit_path' => KANDD_PATH . "/databases/scripts",
                'deposit_url' => 'ssh://gogs@devgit.k-and-decide.com:8822/Dev/GitScripts.git####scripts'
            ],
            [
                'deposit_name' => 'scriptsV5',
                'deposit_path' => KANDD_PATH . "/databases/scriptsV5",
                'deposit_url' => 'ssh://gogs@devgit.k-and-decide.com:8822/Dev/GitScriptsV5.git####scriptsV5'
            ],
            [
                'deposit_name' => 'sql',
                'deposit_path' => KANDD_PATH . "/databases/sql",
                'deposit_url' => 'ssh://gogs@devgit.k-and-decide.com:8822/Dev/GitSql.git####sql'
            ]
        ];
        foreach ($deposits as $deposit)
        {
            $deposit_obj = KdDeposit::firstOrCreate(
                ['deposit_name' => $deposit['deposit_name']],
                ['deposit_path' => $deposit['deposit_name'], 'deposit_url' => $deposit['deposit_url']]
            );
            if($deposit_obj) {
                $this->command->info("Create depost ".$deposit['deposit_name']." done successfully");
            } else {
                $this->command->error("Create depost ".$deposit['deposit_name']." done with error");
            }
        }

    }
}
