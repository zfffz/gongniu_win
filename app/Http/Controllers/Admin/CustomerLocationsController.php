<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use App\Http\Requests\CustomerLocationRequest;
use App\Models\CustomerLocation;
use App\Models\Storage_location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerLocationsController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.customerLocations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer_location= new CustomerLocation();
        $storage_locations = Storage_location::all();
        return view('admins.customerLocations.create_and_edit',compact('customer_location','storage_locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerLocationRequest $request)
    {
        $customerLocation=new CustomerLocation();
        $customerLocation->customer_no = $request->customer_no;
        $customerLocation->location_id = $request->location_id;
        $customerLocation->note = $request->note;
        $customerLocation->create_id = Auth::user()->no;

        $customerLocation->save();

        return redirect()->route('customerLocation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer_location = CustomerLocation::find($id);

        $customer_name = DB::table('customer')->select('cCusName')
            ->where('cCusCode','=',$customer_location->customer_no)
            ->get()[0]->cCusName;

        $storage_locations = Storage_location::all();

        return view('admins.customerLocations.show',compact('customer_location','storage_locations','customer_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer_location = CustomerLocation::find($id);

        $customer_name = DB::table('customer')->select('cCusName')
            ->where('cCusCode','=',$customer_location->customer_no)
            ->get()[0]->cCusName;

        $storage_locations = Storage_location::all();

        return view('admins.customerLocations.create_and_edit',compact('customer_location','storage_locations','customer_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerLocationRequest $request,CustomerLocation $customerLocation)
    {
        $customerLocation->update([
            "location_id"=>$request->location_id,
            "note"=>$request->note,
            "updated_at"=>date("Y-m-d H:i:s"),
            "edit_id"=>Auth::user()->no
        ]);

        return redirect()->route('customerLocation.index')->with('success', '客户默认库位更新成功！');
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

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_customer_locations as t1')
            ->select(
                \DB::raw("
            t1.id,
            t1.customer_no,
            t1.location_id,
            t4.no as location_no,
            t4.name as location_name,
            t3.cCusName as customer_name,
            t1.note,
            case when t1.status = 1 then '正常' else '作废' end as status,
            t1.created_at,
            t1.updated_at,
            t2.name as create_name,
            t5.name as edit_name
            "))
            ->leftJoin('users as t2','t1.create_id','t2.id')
            ->leftJoin('customer as t3','t1.customer_no','t3.cCusCode')
            ->leftJoin('zzz_storage_locations as t4','t1.location_id','t4.id')
            ->leftJoin('users as t5','t1.edit_id','t5.id');

        $data=parent::dataPage($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){
            $table->where('t1.customer_no','like','%'.$searchKey.'%');
            $table->orWhere('t4.no','like','%'.$searchKey.'%');
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
