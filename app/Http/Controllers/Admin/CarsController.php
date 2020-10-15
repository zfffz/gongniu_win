<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarsController extends CommonsController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        // 判断当前登录的用户是否有权限
        
        return view('admins.cars.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)

    {
        if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
// dd($request->user()->hasRoles('basic'));
//         // $role->hasPermissionTo('manage_contents');
// if (! $request->user()->Roles()->hasPermissionTo('manage_contents')) {
//             return view('admins.pages.permission_denied');
//         }
        // dd(Auth::user()->can('basic_users'));

        // if (! Auth::user()->can('basic_users')) {
        //     return view('admins.pages.permission_denied');
        // }
        $car= new Car();
        return view('admins.cars.create_and_edit',compact('car'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequest $request)
    {
        $car=new Car();
        $car->no = $request->no;
        $car->model = $request->model;
        $car->note = $request->note;
        $car->create_id = Auth::user()->no;

        $car->save();

        return redirect()->route('car.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $car = Car::find($id);
        return view('admins.cars.show',compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $car = Car::find($id);
        return view('admins.cars.create_and_edit',compact('car'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequest $request, Car $car)
    {
        if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $car->update([
            "model"=>$request->model,
            "note"=>$request->note,
            "updated_at"=>date("Y-m-d H:i:s"),
            "edit_id"=>Auth::user()->no
        ]);

        return redirect()->route('car.index')->with('success', '车辆更新成功！');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $car->delete();
        // 把之前的 redirect 改成返回空数组
        return [];
    }

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_cars as t1')
            ->select(
                \DB::raw("
            t1.id,
            t1.no,
            t1.model,
            t1.note,
            case when t1.status = 1 then '正常' else '作废' end as status,
            t1.created_at,
            t1.updated_at,
            t2.name as create_name,
            t3.name as edit_name
            "))
            ->leftJoin('users as t2','t1.create_id','t2.id')
            ->leftJoin('users as t3','t1.edit_id','t3.id');

        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t1.no','like','%'.$searchKey.'%');
            $table->orWhere('t1.model','like','%'.$searchKey.'%');
            $table->orWhere('t2.name','like','%'.$searchKey.'%');
            $table->orWhere('t3.name','like','%'.$searchKey.'%');
        }
        return $table;
    }
}
