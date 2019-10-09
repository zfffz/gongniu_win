<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\SweepCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SweepCarsController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Car::all('id','no');
        $drivers = Driver::all('id','name');
        return view('sweepCars.create',compact('cars','drivers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sweep_car=\DB::transaction(function() use ($request){
            //创建一张新的扫码上车单
            $sweep_car = new SweepCar([
                'car_id'=>$request->input('car_id'),
                'driver_id'=>$request->input('driver_id'),
                'user_no'=>Auth::id()
            ]);
            $sweep_car->save();

            //创建一张新的项目清单
            $sweep_car_items = $request->input('items');
            $i=1;

            foreach($sweep_car_items as $data){
                $sweep_car_item = $sweep_car->sweep_car_items()->make([
                    'entry_id'=>$i,
                    'dispatch_no'=> $data['dispatch_no']
                ]);

                $sweep_car_item->save();

                $i++;
            }

            // 更新
            $sweep_car->update(['count' => ($i-1)]);

            return $sweep_car;
        });

        return $sweep_car;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dispatch_data(Request $request){
        $dispatch_no = $request->dispatch_no;
        $data = DB:: table('zzz_sweep_out_items as t1')
            ->select('t1.dispatch_no')
            ->where('t1.dispatch_no','=',$dispatch_no)->get();

        echo json_encode($data);

    }

    //检查口令是否正确
    public function checkPass(Request $request){
        $password = $request->password;
        if($password == '123456'){
            echo json_encode(array('status'=>'success'));
        }else{
            echo json_encode(array('status'=>'error'));
        }

    }

}
