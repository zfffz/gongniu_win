<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

#新引入命名空间
use Auth;
use App\Foundation\Auth\EllerEloquentUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //进行拦截注入，Eller-eloquent 自定义需要与配置文件对应。
        Auth::provider('Eller-eloquent', function ($app, $config) {
            return new EllerEloquentUserProvider($this->app['hash'], $config['model']);
        });
    }
}
