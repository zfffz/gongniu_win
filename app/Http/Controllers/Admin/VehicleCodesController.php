<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use App\Http\Requests\VehicleCodeRequest;
use App\Models\VehicleCode;
use App\Models\Storage_location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleCodesController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        return view('admins.vehicleCode.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $vehicle_code= new VehicleCode();
        // $storage_locations = Storage_location::all();
 
        return view('admins.vehicleCode.create_and_edit',compact('vehicle_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleCodeRequest $request)
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $VehicleCode=new VehicleCode();
        $VehicleCode->cxno = $request->cxno;
        $VehicleCode->fccode = $request->fccode;
        $VehicleCode->create_id = Auth::user()->no;

        
        // $VehicleCode->created_at= date("Y-m-d H:i:s");
        // $VehicleCode->note = $request->note;
        // $VehicleCode->location_id = $request->location_id;
        

        $VehicleCode->save();

        return redirect()->route('vehicleCode.index');
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
        $vehicle_code = VehicleCode::find($id);
    //    dd($vehicle_code->fccode);
        $customer_name = DB::table('customer')->select('cCusName')
            ->where('cCusCode','=',$vehicle_code->fccode)
            ->get()[0]->cCusName;

        $storage_locations = Storage_location::all();

        return view('admins.vehicleCode.show',compact('vehicle_code','storage_locations','customer_name'));
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
        $vehicle_code = VehicleCode::find($id);
        // $customer_location = CustomerLocation::find($id);

        $customer_name = DB::table('customer')->select('cCusName')
        ->where('cCusCode','=',$vehicle_code->fccode)
        ->get()[0]->cCusName;

        $storage_locations = Storage_location::all();

        return view('admins.vehicleCode.create_and_edit',compact('vehicle_code','storage_locations','customer_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleCodeRequest $request,VehicleCode $vehicleCode)
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }

        // dd($request->fccode);
        $vehicleCode->update([
            "fccode"=>$request->fccode,
            // "note"=>$request->note,
            //  "updated_at"=>date("Y-m-d H:i:s"),
            "edit_id"=>Auth::user()->no
        ]);

        return redirect()->route('vehicleCode.index')->with('success', '车销对应客户更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        //
    }

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_DMS_FC_code as t1')
        ->select(
            \DB::raw("
        t1.id,
        t1.cxno,
        t1.fccode,
        t3.cCusName,
        case when t1.status = 1 then '正常' else '作废' end as status,
        t1.created_at,
        t1.updated_at,
        t2.name as create_name,
        t5.name as edit_name
        "))
        ->leftJoin('users as t2','t1.create_id','t2.id')
        ->leftJoin('customer as t3','t1.fccode','t3.cCusCode')
     
        ->leftJoin('users as t5','t1.edit_id','t5.id');
        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'desc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t1.cxno','like','%'.$searchKey.'%');
            $table->orWhere('t1.fccode','like','%'.$searchKey.'%');
            $table->orWhere('t2.name','like','%'.$searchKey.'%');
            $table->orWhere('t5.name','like','%'.$searchKey.'%');
        }
        return $table;
    }

    public function getCustomerData(Request $request){
        $builder = \DB::table('customer as t1')
            ->select(
                \DB::raw("
            t1.cCusCode as id,
            t1.cCusName as text
            "));
        $code = $request->code;
        if($code!=''){
            $builder->where('t1.cCusCode','like','%'.$code.'%');
            $builder->orWhere('t1.cCusName','like','%'.$code.'%');
        }

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');

        $total = $builder->count();
        $list = $builder->orderBy('cCusCode', 'asc')->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);

    }
}
