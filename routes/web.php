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
    Route::resource('sweepOut', 'SweepOutsController', ['only' => ['create', 'store']]);

    //扫码上车
    Route::get('sweepCar/dispatch_data', 'SweepCarsController@dispatch_data')->name('sweepCar.dispatch_data');
    Route::get('sweepCar/checkPass', 'SweepCarsController@checkPass')->name('sweepCar.checkPass');
    Route::resource('sweepCar', 'SweepCarsController', ['only' => ['create', 'store']]);


});