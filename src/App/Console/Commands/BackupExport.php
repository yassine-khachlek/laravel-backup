<?php

namespace Yk\LaravelBackup\App\Console\Commands;

use Illuminate\Console\Command;

use Config;
use DB;
use File;

class BackupExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:export';

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
        // Set the database backup path
        $backup_path = storage_path('backups/'.date('YmdHis').'/database/'.Config::get('database.connections.'.Config::get('database.default').'.database'));

        // Create the backup path if not exist
        File::makeDirectory($backup_path, 0775, true, true);

        // Get tables
        $tables = array_map(function($Object){
            
            return $Object->{'Tables_in_'.Config::get('database.connections.mysql.database')};

        }, DB::select('SHOW TABLES'));

        foreach ($tables as $table) {

            // Set the table path
            $table_path = $backup_path.DIRECTORY_SEPARATOR.$table;

            // Make sure the table path exist
            File::makeDirectory($table_path, 0775, true, true);

            // Export table records to json
            DB::table($table)->chunk(1000, function ($records) use ($table_path) {
                
                foreach ($records as $record) {
                    
                    // Set the file path
                    $file_path = $table_path.DIRECTORY_SEPARATOR.$record->id.'.json';

                    // Write the file with record content encoded in json format
                    $bytes_written = File::put($file_path, json_encode($record));
                    
                    if ($bytes_written === false)
                    {
                        $this->error("Error writing to file");
                        die();
                    }else{
                        $this->info($bytes_written);
                    }

                }
            });

        }

    }
}
