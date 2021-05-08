<?php

// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//   Route::get('excel/export','ExcelController@export')->name('excel.export');
// Route::get('excel/import','ExcelController@import');
// Route::get('excel/export', 'ExcelController@export');
Route::group(['middleware' => 'auth'], function() {
// Route::group(['middleware' => ['web','admin.login']], function () {
    // 首页
    Route::get('/', 'PagesController@root')->name('root');

// Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');
    // 打包出库

    Route::get('sweepOut/dispatch_data', 'SweepOutsController@dispatch_data')->name('sweepOut.dispatch_data');
    Route::get('sweepOut/dispatchs_data', 'SweepOutsController@dispatchs_data')->name('sweepOut.dispatchs_data');
    Route::get('sweepOut/location_data', 'SweepOutsController@location_data')->name('sweepOut.location_data');
    Route::post('sweepOut/getData', 'SweepOutsController@getData')->name('sweepOut.getData');
      Route::post('sweepOut/delete/{searchKey}', 'SweepOutsController@delete')->name('sweepOut.delete');
    Route::post('sweepOut/update_cverifier', 'SweepOutsController@update_cverifier')->name('sweepOut.update_cverifier');
    Route::get('sweepOut/checkIfdh', 'SweepOutsController@checkIfdh')->name('sweepOut.checkIfdh');
    Route::resource('sweepOut', 'SweepOutsController', ['only' => [ 'index', 'create', 'store','index','destroy','show','update']]);

     // 退回单
    Route::get('returnhouse/dispatch_data', 'returnhousesController@dispatch_data')->name('returnhouse.dispatch_data');
    Route::get('returnhouse/dispatchs_data', 'returnhousesController@dispatchs_data')->name('returnhouse.dispatchs_data');
    Route::get('returnhouse/location_data', 'returnhousesController@location_data')->name('returnhouse.location_data');
    Route::post('returnhouse/getData', 'returnhousesController@getData')->name('returnhouse.getData');
    Route::post('returnhouse/update_cverifier', 'returnhousesController@update_cverifier')->name('returnhouse.update_cverifier');
    Route::get('returnhouse/checkIfdh', 'returnhousesController@checkIfdh')->name('returnhouse.checkIfdh');
    Route::resource('returnhouse', 'returnhousesController', ['only' => [ 'index', 'create', 'store','index','destroy','show','update']]);


    // // 扫码上车
    // Route::get('sweepCar/dispatch_data', 'SweepCarsController@dispatch_data')->name('sweepCar.dispatch_data');
    // Route::get('sweepCar/checkPass', 'SweepCarsController@checkPass')->name('sweepCar.checkPass');
    // Route::post('sweepCar/getData', 'SweepCarsController@getData')->name('sweepCar.getData');
    // Route::post('sweepCar/delete/{searchKey}', 'SweepCarsController@delete')->name('sweepCar.delete');
    // Route::get('sweepCar/checkCdlcode', 'SweepCarsController@checkCdlcode')->name('sweepCar.checkCdlcode');
    // // Route::get('users/export/', 'SweepCarsController@export');
    // Route::resource('sweepCar', 'SweepCarsController', ['only' => ['create', 'store','index','destroy','show']]);

    // 扫码上车
    Route::get('sweepCar/dispatch_data', 'SweepCarsController@dispatch_data')->name('sweepCar.dispatch_data');
    Route::get('sweepCar/checkPass', 'SweepCarsController@checkPass')->name('sweepCar.checkPass');
    Route::post('sweepCar/getData', 'SweepCarsController@getData')->name('sweepCar.getData');
    Route::post('sweepCar/delete/{searchKey}', 'SweepCarsController@delete')->name('sweepCar.delete');
    Route::get('sweepCar/checkCdlcode', 'SweepCarsController@checkCdlcode')->name('sweepCar.checkCdlcode');
    // Route::get('users/export/', 'SweepCarsController@export');
    Route::resource('sweepCar', 'SweepCarsController', ['only' => ['create', 'store','index','destroy','show']]);

    //扫码对货
    // Route::get('sweepCheck/dispatch_data', 'SweepChecksController@dispatch_data')->name('sweepCheck.dispatch_data');
    Route::post('sweepCheck/dispatch_data', 'SweepChecksController@dispatch_data')->name('sweepCheck.dispatch_data');
    Route::post('sweepCheck/result_data', 'SweepChecksController@result_data')->name('sweepCheck.result_data');
    Route::post('sweepCheck/dispatchs_data', 'SweepChecksController@dispatchs_data')->name('sweepCheck.dispatchs_data');
    Route::post('sweepCheck/dispatchscf_data', 'SweepChecksController@dispatchscf_data')->name('sweepCheck.dispatchscf_data');
    Route::get('sweepCheck/dispatchss_data', 'SweepChecksController@dispatchss_data')->name('sweepCheck.dispatchss_data');
    Route::post('sweepCheck/getData', 'SweepChecksController@getData')->name('sweepCheck.getData');
    Route::post('sweepCheck/getDatas', 'SweepChecksController@getDatas')->name('sweepCheck.getDatas');
    Route::post('sweepCheck/print', 'SweepChecksController@print')->name('sweepCheck.print');
    Route::get('sweepCheck/lgetPrint', 'SweepChecksController@lgetPrint')->name('sweepCheck.lgetPrint');
     Route::get('sweepCheck/outboxPrint', 'SweepChecksController@outboxPrint')->name('sweepCheck.outboxPrint');
    Route::post('sweepCheck/outboxPrint', 'SweepChecksController@outboxPrint')->name('sweepCheck.outboxPrint');
    Route::resource('sweepCheck', 'SweepChecksController', ['only' => ['create', 'store','index','destroy','show']]);



    //扫码对货app
Route::get('sweepCheckapp/dispatch_data', 'SweepCheckappsController@dispatch_data')->name('sweepCheckapp.dispatch_data');
Route::get('sweepCheckapp/result_data', 'SweepCheckappsController@result_data')->name('sweepCheckapp.result_data');
Route::post('sweepCheckapp/dispatchs_data', 'SweepCheckappsController@dispatchs_data')->name('sweepCheckapp.dispatchs_data');
Route::post('sweepCheck/dispatchscf_data', 'SweepChecksController@dispatchscf_data')->name('sweepCheck.dispatchscf_data');
Route::get('sweepCheckapp/dispatchss_data', 'SweepCheckappsController@dispatchss_data')->name('sweepCheckapp.dispatchss_data');
Route::post('sweepCheckapp/getData', 'SweepCheckappsController@getData')->name('sweepCheckapp.getData');
Route::post('sweepCheckapp/getDatas', 'SweepCheckappsController@getDatas')->name('sweepCheckapp.getDatas');
Route::resource('sweepCheckapp', 'SweepCheckappsController', ['only' => ['create', 'store','index','destroy','show']]);

    // 个人中心
Route::resource('user', 'UsersController', ['only' => ['show']]);
Route::get('users/export', 'UsersController@export');


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
      // 箱规
    Route::post('carton/getData', 'CartonsController@getData')->name('carton.getData');
    Route::resource('carton', 'CartonsController', ['only' => [ 'index', 'create', 'store','show','edit','update','destroy']]);

    // 司机
    Route::post('driver/getData', 'DriversController@getData')->name('driver.getData');
    Route::resource('driver', 'DriversController', ['only' => [ 'index', 'create', 'store','show','edit','update','destroy']]);

    // 客户默认库位
    Route::post('customerLocation/getData', 'CustomerLocationsController@getData')->name('customerLocation.getData');
    Route::get('customerLocation/getCustomerData', 'CustomerLocationsController@getCustomerData')->name('customerLocation.getCustomerData');
    Route::resource('customerLocation', 'CustomerLocationsController', ['only' => [ 'index', 'create', 'store','show','edit','update','destroy']]);
    
    //生成发运单
    Route::post('wayBill/getData', 'WayBillsController@getData')->name('wayBill.getData');
    Route::post('wayBill/getDispatchData', 'WayBillsController@getDispatchData')->name('wayBill/getDispatchData');
    Route::resource('wayBill', 'WayBillsController', ['only' => [ 'index','store']]);

    //生成调运单
    Route::post('transVouch/getData', 'TransVouchsController@getData')->name('transVouch.getData');
    Route::post('transVouch/getDispatchData', 'TransVouchsController@getDispatchData')->name('transVouch/getDispatchData');
    Route::post('transVouch/getTransVouch', 'TransVouchsController@getTransVouch')->name('transVouch/getTransVouch');
    Route::resource('transVouch', 'TransVouchsController', ['only' => [ 'index','store']]);

   //发货单打印
    Route::post('dispatchPrint/getData', 'DispatchPrintController@getData')->name('dispatchPrint.getData');
    Route::get('dispatchPrint/getPrint', 'DispatchPrintController@getPrint')->name('dispatchPrint.getPrint');  
     Route::post('dispatchPrint/lgetData', 'DispatchPrintController@lgetData')->name('dispatchPrint.lgetData');
    Route::get('dispatchPrint/lgetPrint', 'DispatchPrintController@lgetPrint')->name('dispatchPrint.lgetPrint');
    Route::post('dispatchPrint/lgetPrint', 'DispatchPrintController@lgetPrint')->name('dispatchPrint.lgetPrint');
    Route::post('dispatchPrint/lgetPrint1', 'DispatchPrintController@lgetPrint1')->name('dispatchPrint.lgetPrint1');
    Route::get('dispatchPrint/outboxPrint', 'DispatchPrintController@outboxPrint')->name('dispatchPrint.outboxPrint');
    Route::post('dispatchPrint/outboxPrint', 'DispatchPrintController@outboxPrint')->name('dispatchPrint.outboxPrint');
    Route::post('dispatchPrint/updPrintstatus', 'DispatchPrintController@updPrintstatus')->name('dispatchPrint.updPrintstatus');
    Route::get('dispatchPrint/checkprint', 'DispatchPrintController@checkprint')->name('dispatchPrint.checkprint');   
     Route::post('dispatchPrint/checkprint1', 'DispatchPrintController@checkprint1')->name('dispatchPrint.checkprint1');
     Route::post('dispatchPrint/checkprint2', 'DispatchPrintController@checkprint2')->name('dispatchPrint.checkprint2');
       Route::post('dispatchPrint/checkprint3', 'DispatchPrintController@checkprint3')->name('dispatchPrint.checkprint3');
          Route::post('dispatchPrint/deletesd', 'DispatchPrintController@deletesd')->name('dispatchPrint.deletesd');
           // Route::post('sweepCheck/print', 'SweepChecksController@print')->name('sweepCheck.print');
       //调拨单打印
        Route::get('dispatchPrint/dbcheckprint', 'DispatchPrintController@dbcheckprint')->name('dispatchPrint.dbcheckprint');
        Route::get('dispatchPrint/dbgetPrint', 'DispatchPrintController@dbgetPrint')->name('dispatchPrint.dbgetPrint');  
          Route::post('dispatchPrint/getDatadb', 'DispatchPrintController@getDatadb')->name('dispatchPrint.getDatadb');
          Route::post('dispatchPrint/updPrintstatusdb', 'DispatchPrintController@updPrintstatusdb')->name('dispatchPrint.updPrintstatusdb');
    //  Route::post('dispatchPrint/printpage', 'DispatchPrintController@printpage')->name('dispatchPrint.printpage');
    Route::resource('dispatchPrint', 'DispatchPrintController', ['only' => [ 'index']]);



    // 报表
    // 1.发货单：发货单 -> 打包出库 -> 扫码上车
    Route::post('dispatchReport/getData', 'DispatchReportsController@getData')->name('dispatchReport.getData');
       Route::post('/dispatchReport/export', 'DispatchReportsController@export')->name('dispatchReport.export');
       Route::get('/dispatchReport/DownloadFile/{file}', 'DispatchReportsController@DownloadFile')->name('download');
    // Route::post('dispatchReport/getData1', 'DispatchReportsController@getData1')->name('dispatchReport.getData1');
    //  Route::post('dispatchReport/stock', 'DispatchReportsController@stock')->name('dispatchReport.getData1');

    Route::resource('dispatchReport', 'DispatchReportsController', ['only' => [ 'index']]);

    //出入库报表
      Route::post('stockReport/getData', 'StockReportsController@getData')->name('stockReport/getData');
     Route::resource('stockReport', 'StockReportsController', ['only' => [ 'index']]);
      //现存量报表
      Route::post('stockReport1/getData', 'StockReport1sController@getData')->name('stockReport1/getData');
     Route::resource('stockReport1', 'StockReport1sController', ['only' => [ 'index']]);
Route::get('stockReport1/getInventoryData', 'stockReport1sController@getInventoryData')->name('stockReport1/getInventoryData');

    //发运单打印
     Route::get('/wayPrint/{id}/getPrint', 'WayPrintController@getPrint')->name('wayPrint.getPrint');
    Route::post('wayPrint/getData', 'WayPrintController@getData')->name('wayPrint.getData');
    Route::resource('wayPrint', 'WayPrintController', ['only' => [ 'index']]);

       //调运单打印
     Route::get('/transPrint/{id}/getPrint', 'TransPrintController@getPrint')->name('transPrint.getPrint');
    Route::post('transPrint/getData', 'TransPrintController@getData')->name('transPrint.getData');
    Route::resource('transPrint', 'TransPrintController', ['only' => [ 'index']]);


//权限
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');

});