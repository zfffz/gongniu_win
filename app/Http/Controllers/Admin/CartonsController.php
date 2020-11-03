<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonsController;
// use App\Http\Requests\CartonRequest;
// use App\Models\Carton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CartonsController extends CommonsController
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
        return view('admins.carton.index');
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
        $carton= new Carton();
        return view('admins.carton.create_and_edit',compact('carton'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request,$id)
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        // select cinvcode as id,cinvcode as no,cinvname as name,cInvDefine13,iInvWeight,fGrossW  from inventory where cinvcode=?",[$id]);
          
        DB::update("update inventory set cInvDefine13=?, cinvdefine5=?,iInvWeight=?,fGrossW=? where cdlcode=?",[$request->no,$request->cinvdefine5,$request->iInvWeight,$request->fGrossW,$id]);
        // $carton=new Carton();
        // $carton->no = $request->no;
        // $carton->name = $request->name;
        // $carton->note = $request->note;
        // $carton->create_id = Auth::user()->no;

        // $carton->save();

        return redirect()->route('carton.index');
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


         $carton= DB::select("select cinvcode as id,cinvcode as no,cinvdefine5,cinvname as name,cInvDefine13,iInvWeight,fGrossW  from inventory where cinvcode=?",[$id]);
          
        return view('admins.carton.show',compact('carton'));



         // $carton = \DB::table('inventory as t1')
         //    ->select(
         //        \DB::raw("
         //    t1.cinvcode as id,
         //    t1.cinvcode,
         //    t1.cinvname,
         //    t1.cInvDefine13
           
         //    "))
         //    // ->leftJoin('users as t2','t1.create_id','t2.id')
         //    // ->leftJoin('users as t3','t1.edit_id','t3.id')
         //    ;
       
        return view('admins.carton.show',compact('carton'));
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
       $carton= DB::select("select cinvcode as id,cinvcode as no,cinvdefine5,cinvname as name,cInvDefine13,iInvWeight,fGrossW  from inventory where cinvcode=?",[$id]);
          
        return view('admins.carton.create_and_edit',compact('carton'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $dModifyDate = date("Y-m-d H:i:s");
        $cModifyPerson= Auth::user()->name;
        // dd($request->cInvDefine13);
       DB::update("update inventory set cInvDefine13=?, cinvdefine5=?,iInvWeight=?,fGrossW=?,cModifyPerson=?,dModifyDate=? where cinvcode=?",[$request->cInvDefine13,$request->cinvdefine5,$request->iInvWeight,$request->fGrossW,$cModifyPerson,$dModifyDate,$id]);
        // $carton=new Carton();
        // $carton->no = $request->no;
        // $carton->name = $request->name;
        // $carton->note = $request->note;
        // $carton->create_id = Auth::user()->no;

        // $carton->save();

        return redirect()->route('carton.index')->with('success', '库位更新成功！');


        // return redirect()->route('carton.index')
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carton $carton)
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $carton->delete();
        // 把之前的 redirect 改成返回空数组
        return [];
    }

    public function getData(Request $request)
    {
         if (! Auth::user()->can('basic_users')) {
            return view('admins.pages.permission_denied');
        }
        $builder = \DB::table('inventory as t1')
            ->select(
                \DB::raw("
            t1.cinvcode as id,
            t1.cinvcode,
            t1.cinvdefine5,
            t1.cinvname,
            t1.cInvDefine13,
            t1.iInvWeight,
            t1.fGrossW
           
            "))
            ->where('bInvType','=',0)
           
            // ->leftJoin('users as t2','t1.create_id','t2.id')
            // ->leftJoin('users as t3','t1.edit_id','t3.id')
            ;

        $data=parent::dataPage8($request,$this->condition($builder,$request->searchKey),'asc');

        return $data;
    }

    private function condition($table,$searchKey){
        if($searchKey!=''){

            $table->where('t1.cinvcode','like','%'.$searchKey.'%');
            $table->orWhere('t1.cinvname','like','%'.$searchKey.'%');
            $table->orWhere('t1.cInvDefine13','like','%'.$searchKey.'%');
            $table->orWhere('t1.cInvDefine5','like','%'.$searchKey.'%');
            // $table->orWhere('t3.name','like','%'.$searchKey.'%');
        }
        return $table;
    }
}
