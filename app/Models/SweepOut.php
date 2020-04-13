<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SweepOut extends Model
{
    const CAR_STATUS_NO = '0';
    const REFUND_STATUS_PART = '1';
    const REFUND_STATUS_FINISH = '2';

    public $table='zzz_sweep_outs';
    protected $fillable = [
        'no','packager_no','user_no','count','status','location_no',
    ];

    public static $shipStatusMap = [
        self::CAR_STATUS_NO   => '未装车',
        self::REFUND_STATUS_PART => '部分装车',
        self::REFUND_STATUS_FINISH  => '全部装车',
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
            $no = "DB".$prefix;
            // 判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('打包单号生成失败');

        return false;
    }

    public function sweep_out_items()
    {
        return $this->hasMany(Sweep_out_item::class,'parent_id','id');
    }


}
