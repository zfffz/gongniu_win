<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SweepCheck extends Model
{
  
    public $table='zzz_sweep_checks';
    protected $fillable = [
        'dispatch_no','ccusname','ddate','position','zdzz','lszz','cz','cy','checker','user_no','CTNS',
        // 'entry_id','cWhName','cInvCode','cInvName','cInvStd','cComUnitName','cinvDefine13','iNum','iQuantity',
    ];

  

    // protected static function boot()
    // {
    //     parent::boot();
    //     // 监听模型创建事件，在写入数据库之前触发
    //     static::creating(function ($model) {
    //         // 如果模型的 no 字段为空
    //         if (!$model->no) {
    //             // 调用 findAvailableNo 生成订单流水号
    //             $model->no = static::findAvailableNo();
    //             // 如果生成失败，则终止创建订单
    //             if (!$model->no) {
    //                 return false;
    //             }
    //         }
    //     });
    // }

    // public static function findAvailableNo()
    // {
    //     // 订单流水号前缀
    //     $prefix = date('YmdHis');
    //     for ($i = 0; $i < 10; $i++) {
    //         $no = "DB".$prefix;
    //         // 判断是否已经存在
    //         if (!static::query()->where('no', $no)->exists()) {
    //             return $no;
    //         }
    //     }
    //     \Log::warning('打包单号生成失败');

    //     return false;
    // }

    public function sweep_check_items()
    {
        return $this->hasMany(Sweep_check_item::class,'parent_id','id');
    }


}
