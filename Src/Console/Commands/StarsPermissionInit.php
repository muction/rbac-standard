<?php

namespace Stars\Permission\Console\Commands;

use Illuminate\Console\Command;
class StarsPermissionInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starsPermission:init {down?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init Stars Permission System';

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
        //
        $initSchemas = [
          \Stars\Permission\Database\StarsPermissionRoles::class ,
          \Stars\Permission\Database\StarsRoleUsers::class ,
          \Stars\Permission\Database\StarsPermissions::class ,
          \Stars\Permission\Database\StarsUsers::class,
          \Stars\Permission\Database\StarsRoles::class,
        ];

        foreach ( $initSchemas as $item){
            try{
                $schema = new $item();
                $schema->up();
            }catch (\Exception $exception){
                $this->warn( '-- '.$exception->getMessage() );
                $this->line('');
            }
        }
    }
}
