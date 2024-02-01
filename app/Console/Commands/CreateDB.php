<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:createDb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $db_name = env('DB_DATABASE');
        $this->info("Create database $db_name");
        $schemaName = config("database.connections.pgsql.database");
        $host = config("database.connections.pgsql.host");
        $port = config("database.connections.pgsql.port");
        $user = config("database.connections.pgsql.username");
        $password = config("database.connections.pgsql.password");
        $charset = config("database.connections.pgsql.charset",'utf8');

        config(["database.connections.pgsql.database" => null]);
        $sql = "SELECT FROM pg_database WHERE datname = '$schemaName'";

        $query = "CREATE DATABASE $schemaName WITH ENCODING=$charset;";
        try {
            //DB::getPdo($query);
            $dns = "pgsql:host=$host;port=$port";
            $con = new \PDO ($dns, $user, $password);
            $res = $con->query($sql);
            if($res->rowCount() > 0) {
                $this->info("Database $schemaName exist ==> no creation !!!!");
                config(["database.connections.pgsql.database" => $schemaName]);
                return 0;
            }
            $con->query($query);
            $this->info("Create database done successfully");
            config(["database.connections.pgsql.database" => $schemaName]);
        } catch (\Exception $e) {
            $this->error("Error create database !! stop install !! ");
            print $e->getMessage();
            return 1;
        }
        return 0;
    }
}
