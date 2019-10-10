<?php

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function() {
    // 首页
    Route::get('/', 'PagesController@root')->name('root');

    // 打包出库
    Route::get('sweepOut/dispatch_data', 'SweepOutsController@dispatch_data')->name('sweepOut.dispatch_data');
    Route::post('sweepOut/getData', 'SweepOutsController@getData')->name('sweepOut.getData');
    Route::resource('sweepOut', 'SweepOutsController', ['only' => [ 'index', 'create', 'store','index','destroy','show']]);

    // 扫码上车
    Route::get('sweepCar/dispatch_data', 'SweepCarsController@dispatch_data')->name('sweepCar.dispatch_data');
    Route::get('sweepCar/checkPass', 'SweepCarsController@checkPass')->name('sweepCar.checkPass');
    Route::post('sweepCar/getData', 'SweepCarsController@getData')->name('sweepCar.getData');
    Route::resource('sweepCar', 'SweepCarsController', ['only' => ['create', 'store','index','destroy','show']]);

    // 个人中心
    Route::resource('user', 'UsersController', ['only' => ['show']]);


});

// 电脑端路由 Admin
Route::group(['middleware' => 'auth','prefix'=>'admin','namespace'=>'Admin'], function() {
    Route::get('/', 'PagesController@root')->name('root');

    // 库位
    Route::post('storageLocation/getData', 'StorageLocationsController@getData')->name('storageLocation.getData');
    Route::resource('storageLocation', 'StorageLocationsController', ['only' => [ 'index', 'create', 'store','show','edit','update','destroy']]);

    // 车辆
    Route::post('car/getData', 'CarsController@getData')->name('car.getData');
    Route::resource('car', 'CarsController', ['only' => [ 'index', 'create', 'store','show','edit','update','destroy']]);

    // 司机
    Route::post('driver/getData', 'DriversController@getData')->name('driver.getData');
    Route::resource('driver', 'DriversController', ['only' => [ 'index', 'create', 'store','show','edit','update','destroy']]);

    // 客户默认库位
    Route::post('customerLocation/getData', 'CustomerLocationsController@getData')->name('customerLocation.getData');
    Route::get('customerLocation/getCustomerData', 'CustomerLocationsController@getCustomerData')->name('customerLocation.getCustomerData');
    Route::resource('customerLocation', 'CustomerLocationsController', ['only' => [ 'index', 'create', 'store','show','edit','update','destroy']]);


});