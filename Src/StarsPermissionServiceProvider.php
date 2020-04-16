<?php

namespace Stars\Permission;


use Illuminate\Support\ServiceProvider;

class StarsPermissionServiceProvider extends ServiceProvider
{
    /**
     * 系统命令
     * @var array
     */
    protected $commands = [
        \Stars\Permission\Console\Commands\StarsPermissionInit::class
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
        $this->loadViewsFrom( __DIR__ .'/Views/', 'stars-permission' );
        // $this->mergeConfigFrom( __DIR__ . "/starspermission.php", 'stars-permission');
//        $this->publishes([
//            __DIR__ . '/starspermission.php' => config_path('starspermission.php'), ], 'stars-permission');
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
