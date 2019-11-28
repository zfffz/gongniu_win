<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SweepCar extends Model
{
    public $table='zzz_sweep_cars';
    protected $fillable = [
        'car_id','driver_id','user_no','count',
    ];

    protected static function boot()
    {
        parent::boot();
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function ($model) {
            // 如果模型的 no 字段为空
            if (!$model->no) {
                // 调用 findAvailableNo 生成订单流水号
                $model->no = static::findAvailableNo();
                // 如果生成失败，则终止创建订单
                if (!$model->no) {
                    return false;
                }
            }
        });
    }

    public static function findAvailableNo()
    {
        // 订单流水号前缀
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            $no = "ZC".$prefix;
            // 判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('装车单号生成失败');

        return false;
    }

    public function sweep_car_items()
    {
        return $this->hasMany(Sweep_car_item::class,'parent_id','id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class,'car_id','id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id','id');
    }
}
