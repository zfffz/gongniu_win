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
//     public function boot(GateContract $gate)
//     {
//         $this->registerPolicies($gate);

//         //进行拦截注入，Eller-eloquent 自定义需要与配置文件对应。
//         Auth::provider('Eller-eloquent', function ($app, $config) {
//             return new EllerEloquentUserProvider($this->app['hash'], $config['model']);
//         });

//         //  \sweepCheck::auth(function ($request) {
//         //     // 是否是站长
//         //     return \Auth::user()->hasRole('admin');
//         // });

//     }
// }
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        // 修改策略自动发现的逻辑
                //进行拦截注入，Eller-eloquent 自定义需要与配置文件对应。
        Auth::provider('Eller-eloquent', function ($app, $config) {
            return new EllerEloquentUserProvider($this->app['hash'], $config['model']);
        });
      // \sweepCheck::auth(function ($request) {
      //   //     // 是否是站长
      //       return \Auth::user()->hasRole('admin');
 //      //   });
 // Gate::define('edit-settings', function ($user) {
 //        return $user->isAdmin;
 //    });



      
    }


// public function boot()
// {
//     $this->registerPolicies();

//     Gate::define('edit-settings', function ($user) {
//         return $user->isAdmin;
//     });

//     Gate::define('update-post', function ($user, $post) {
//         return $user->id === $post->user_id;
//     });
// }


    //  public function boot()
    // {
    //     $this->registerPolicies();
    //     // 修改策略自动发现的逻辑
    //     Gate::guessPolicyNamesUsing(function ($modelClass) {
    //         // 动态返回模型对应的策略名称，如：// 'App\Model\User' => 'App\Policies\UserPolicy',
    //         return 'App\Policies\\'.class_basename($modelClass).'Policy';
    //      });
    //  \sweepCheck::auth(function ($request) {
    //          // 是否是站长
    //         return \Auth::user()->hasRole('admin');
    //      });
    // }



}
