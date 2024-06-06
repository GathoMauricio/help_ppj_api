<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DumpMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dump:mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump full database and upload to google cloud storage';

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
     * @return int
     */
    public function handle()
    {
        //DUPM DATABASE
        \Spatie\DbDumper\Databases\MySql::create()
            ->setDbName(\Config::get('app.bd_name'))->setUserName(\Config::get('app.bd_user'))
            ->setPassword(\Config::get('app.bd_password'))
            ->dumpToFile(\Config::get('app.app_route') . 'storage/dump_db/dump_' . \Config::get('app.bd_name') . '.sql');
        //GET CURRENT DUMP AND UPLOAD TO GCS
        $disk = \Storage::disk('gcs');
        $disk->put("dump_" . \Config::get('app.bd_name') . ".sql", \File::get(storage_path('dump_db/dump_' . \Config::get('app.bd_name') . '.sql')));
    }
}
