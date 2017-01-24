<?php

namespace Yk\LaravelBackup\App\Console\Commands;

use Illuminate\Console\Command;

use Config;
use DB;
use File;

class BackupImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Set the backups path
        $backup_path = storage_path('backups/');

        // Read the backups path
        $directories = File::directories($backup_path);

        // Sort backups
        sort($directories);

        // Select the last backup
        $backup = basename($directories[count($directories)-1]);

        // Set the database backup path
        $backup_path = storage_path('backups/'.$backup.'/database/'.Config::get('database.connections.'.Config::get('database.default').'.database'));

        // Read backup tables
        $tables = File::directories($backup_path);

        // Import tables records
        foreach ($tables as $table) {

            $files = File::files($table);

            DB::table(basename($table))->truncate();

            foreach ($files as $file) {

                $content = File::get($file);

                $content = json_decode($content, True);

                DB::table(basename($table))->insert(
                    $content
                );

            }

        }
    }
}
