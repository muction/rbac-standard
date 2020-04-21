<?php
namespace Rbac\Standard;
use Illuminate\Support\ServiceProvider;

class RbacPermissionServiceProvider extends ServiceProvider
{
    /**
     * 系统命令
     * @var array
     */
    protected $commands = [
        \Rbac\Standard\Console\Commands\RbacStandard::class
    ];

    /**
     * 系统中间件
     * @var array
     */
    protected $routeMiddleware = [];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->runningInConsole()){
            $this->commands( $this->commands );
        }

        $this->app->shouldSkipMiddleware();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registryRouteMiddleware();
    }

    /**
     * 注册中间件
     */
    protected function registryRouteMiddleware(){

        foreach ( $this->routeMiddleware as $alias=>$class){
            app('router')->aliasMiddleware( $alias , $class);
        }
    }
}
