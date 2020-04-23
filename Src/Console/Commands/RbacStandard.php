<?php
namespace Rbac\Standard\Console\Commands;
use Illuminate\Console\Command;

/**
 * 生成RBAC必要表
 * Class RbacStandard
 * @package Rbac\Standard\Console\Commands
 */
class RbacStandard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rbac:standard {drop?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init rbac standard system';

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
          \Rbac\Standard\Database\RbacPermissionRoles::class ,
          \Rbac\Standard\Database\RbacRoleUsers::class ,
          \Rbac\Standard\Database\RbacPermissions::class ,
          \Rbac\Standard\Database\RbacPermissionTypes::class ,
          \Rbac\Standard\Database\RbacUsers::class,
          \Rbac\Standard\Database\RbacRoles::class,
          \Rbac\Standard\Database\RbacGroupUsers::class,
          \Rbac\Standard\Database\RbacGroups::class,
          \Rbac\Standard\Database\RbacGroupRoles::class,
        ];

        if($this->argument('drop') == 'drop'){
            if(! $this->confirm("确定操作吗？继续的话将删除所有rbac权限表") ){
                 $this->info("您取消了操作");
                 return false;
            }
        }

        foreach ( $initSchemas as $item){
            try{
                $schema = new $item();
                if( $this->argument('drop') == 'drop' ){
                    $this->info("删除： {$item} 表");
                    $schema->down();
                }else{
                    $this->info("创建： {$item} 表");
                    $schema->up();
                }
            }catch (\Exception $exception){
                $this->warn( '-- '.$exception->getMessage() );
                $this->line('');
            }
        }
    }
}
