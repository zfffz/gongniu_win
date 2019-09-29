<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use App\Http\Requests\DriverRequest;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriversController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.drivers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $driver= new Driver();
        return view('admins.drivers.create_and_edit',compact('driver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DriverRequest $request)
    {
        $driver=new Driver();
        $driver->name = $request->name;
        $driver->mobile = $request->mobile;
        $driver->note = $request->note;
        $driver->create_id = Auth::user()->no;

        $driver->save();

        return redirect()->route('driver.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::find($id);
        return view('admins.drivers.show',compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = Driver::find($id);
        return view('admins.drivers.create_and_edit',compact('driver'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DriverRequest $request, Driver $driver)
    {
        $driver->update([
            "name"=>$request->name,
            "mobile"=>$request->mobile,
            "note"=>$request->note,
            "updated_at"=>date("Y-m-d H:i:s")
        ]);

        return redirect()->route('driver.index')->with('success', '车辆更新成功！');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        $driver->delete();
        // 把之前的 redirect 改成返回空数组
        return [];
    }

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_drivers as t1')
            ->select(
                \DB::raw("
            t1.id,
            t1.name,
            t1.mobile,
            t1.note,
            case when t1.status = 1 then '正常' else '作废' end as status,
            t1.created_at,
            t1.updated_at,
            t2.name as create_name
            "))
            ->leftJoin('users as t2','t1.create_id','t2.id');

        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t1.name','like','%'.$searchKey.'%');
            $table->orWhere('t1.mobile','like','%'.$searchKey.'%');
            $table->orWhere('t2.name','like','%'.$searchKey.'%');
        }
        return $table;
    }
}
