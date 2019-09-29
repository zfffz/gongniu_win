<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
use App\Http\Requests\StorageLocationRequest;
use App\Models\Storage_location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorageLocationsController extends CommonsController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admins.storageLocations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storage_location= new Storage_location();
        return view('admins.storageLocations.create_and_edit',compact('storage_location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorageLocationRequest $request)
    {
        $storage_location=new Storage_location();
        $storage_location->no = $request->no;
        $storage_location->name = $request->name;
        $storage_location->note = $request->note;
        $storage_location->create_id = Auth::user()->no;

        $storage_location->save();

        return redirect()->route('storageLocation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $storage_location = Storage_location::find($id);
        return view('admins.storageLocations.show',compact('storage_location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storage_location = Storage_location::find($id);
        return view('admins.storageLocations.create_and_edit',compact('storage_location'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorageLocationRequest $request, Storage_location $storageLocation)
    {
        $storageLocation->update([
            "no"=>$request->no,
            "name"=>$request->name,
            "note"=>$request->note,
            "updated_at"=>date("Y-m-d H:i:s")
        ]);

        return redirect()->route('storageLocation.index')->with('success', '库位更新成功！');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storage_location $storageLocation)
    {
        $storageLocation->delete();
        // 把之前的 redirect 改成返回空数组
        return [];
    }

    public function getData(Request $request)
    {
        $builder = \DB::table('zzz_storage_locations as t1')
            ->select(
                \DB::raw("
            t1.id,
            t1.no,
            t1.name,
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
            $table->where('t1.no','like','%'.$searchKey.'%');
            $table->orWhere('t1.name','like','%'.$searchKey.'%');
            $table->orWhere('t2.name','like','%'.$searchKey.'%');
        }
        return $table;
    }
}
