<?php

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function() {
    //首页
    Route::get('/', 'PagesController@root')->name('root');

    //打包出库
    Route::get('sweepOut/dispatch_data', 'SweepOutsController@dispatch_data')->name('sweepOut.dispatch_data');
    Route::resource('sweepOut', 'SweepOutsController', ['only' => ['index','create', 'store','show', 'edit','update','destroy']]);


});