<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PackageCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command de génération du package code';

    /**
     * Execute the console command.
     * La commande doit générer le package code
     *  - Un package de code crypté
     *  - Ou un package avec un code non crypté
     *  - Un package avec juste des commands de clone git pour installer des envs de dev
     * La commande doit générer le package de base de données
     *   - Avec des migrations de base de donnée
     */
    public function handle()
    {
        // Déterminer la liste des dépôts
        // Pour chaque dépôt, il faut générer le package
        // générer le package de base de données


    }
}
