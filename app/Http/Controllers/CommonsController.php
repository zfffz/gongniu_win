<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonsController extends Controller
{
    //将sql结果集转化成分页格式
    protected function dataPage($request,$builder,$asc='desc'){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $total = $builder->count();
        $list = $builder->orderBy('t1.id', $asc)->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);
    }


    protected function dataPage1($request,$builder,$asc='desc'){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $total = $builder->count();
        $list = $builder->orderBy('t1.AutoID', $asc)->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);
    }


    protected function dataPage2($request,$builder,$asc='desc'){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $total = $builder->count();
        $list = $builder->orderBy('t2.dispatch_no', $asc)->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);
    }

    protected function dataPage3($request,$builder,$asc='desc'){
    $draw = $request->get('draw');
    $start = $request->get('start');
    $length = $request->get('length');
    $total = $builder->count();
    $list = $builder->orderBy('t1.ccuscode', $asc)->orderBy('t1.cdlcode', $asc)->offset($start)->take($length)->get()->toArray();
    $data = [];
    $data["draw"] = $draw;
    $data["recordsTotal"] = $total;
    $data["recordsFiltered"] = $total;
    $data["data"] = $list;
    return response()->json($data);
    }
protected function dataPage9($request,$builder,$asc='desc'){
    $draw = $request->get('draw');
    $start = $request->get('start');
    $length = $request->get('length');
    $total = $builder->count();
    $list = $builder->orderBy('t1.cdefine3', $asc)->orderBy('t1.ctvCode', $asc)->offset($start)->take($length)->get()->toArray();
    $data = [];
    $data["draw"] = $draw;
    $data["recordsTotal"] = $total;
    $data["recordsFiltered"] = $total;
    $data["data"] = $list;
    return response()->json($data);
    }

    protected function dataPage5($request,$builder,$asc='desc'){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $total = $builder->count();
        $list = $builder->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);
    }


     protected function dataPage6($request,$builder,$asc='desc'){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $total = $builder->count();
        $list = $builder->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);
    }


  protected function dataPage7($request,$builder,$asc='desc'){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $total = $builder->count();
        $list = $builder->orderBy('t1.id', $asc)->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);
    }
 protected function dataPage8($request,$builder,$asc='desc'){
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $total = $builder->count();
        $list = $builder->orderBy('t1.cinvcode', $asc)->offset($start)->take($length)->get()->toArray();
        $data = [];
        $data["draw"] = $draw;
        $data["recordsTotal"] = $total;
        $data["recordsFiltered"] = $total;
        $data["data"] = $list;
        return response()->json($data);
    }







}


