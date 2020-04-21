<?php

namespace Initbiz\InitDry\Console;

use DB;
use Config;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Command to drop all tables in the current DB
 */
class DropTables extends Command
{
    protected $force = false;

    protected $dbConnection = 'sqlite';

    protected $database;

    protected $name = 'initdry:droptables';

    protected $description = 'Drop all tables';

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force updates.'],
        ];
    }

    public function handle()
    {
        $this->force = $this->option('force');

        $this->dbConnection = Config::get('database.default', 'sqlite');
        $this->database = Config::get('database.connections.' . $this->dbConnection . '.database');

        if (
            !$this->force &&
            !$this->confirm('CONFIRM DROP ALL TABLES IN THE ' . $this->database . ' DATABASE [y|N]')
        ) {
            exit('Command aborted');
        }

        if ($this->dbConnection === 'sqlite') {
            $this->dropSQLite();
        } elseif ($this->dbConnection === 'mysql') {
            $this->dropMySQL();
        }

        $this->comment(PHP_EOL . "If no errors showed up, all tables were dropped" . PHP_EOL);
    }

    protected function dropSQLite()
    {
        $tables = DB::select("select name from sqlite_master where type is 'table'");

        foreach ($tables as $table) {
            DB::statement("DROP TABLE IF EXISTS $table");
        }
    }

    protected function dropMySQL()
    {
        $colname = 'Tables_in_' . $this->database;

        $tables = \Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        $droplist = [];

        foreach ($tables as $table) {
            $droplist[] = $table->$colname;
        }

        $droplist = implode(',', $droplist);

        DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement("DROP TABLE $droplist");
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        DB::commit();
    }
}
