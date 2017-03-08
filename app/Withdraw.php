<?php

namespace App;

use App\Jobs\WithdrawJob;
use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Withdraw
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $integral
 * @property float $money
 * @property float $proportion
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property mixed getIntegral
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereIntegral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereProportion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereIntegralBlottersId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereCommissionBlottersId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereDeletedAt($value)
 * @property string $serial_number
 * @property string $wechat_order_number
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereWechatOrderNumber($value)
 * @property string $fail_reason
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Withdraw whereFailReason($value)
 */
class Withdraw extends Model
{
    const STATUS_HOLD = 10;
    const STATUS_WAIT = 20;
    const STATUS_RUNNING = 30;
    const STATUS_SUCCESS = 40;
    const STATUS_FAILED = 50;
    const STATUS_ACTION_SUCCESS = 60;
    const STATUS_ACTION_FAILED = 70;

    protected static function statusLabelList()
    {
        return [
            self::STATUS_HOLD => '等待关注',
            self::STATUS_WAIT => '等待系统处理',
            self::STATUS_RUNNING => '系统处理中',
            self::STATUS_FAILED => '系统处理失败',
            self::STATUS_SUCCESS => '系统处理成功',
            self::STATUS_ACTION_FAILED => '微信处理失败',
            self::STATUS_ACTION_SUCCESS => '微信处理成功',
        ];
    }

    protected $fillable = [
        'money'
    ];

    protected static function boot()
    {
        self::registerModelEvent('creating', function (self $model) {
            $model->serial_number = '3' . date('YmdHis') . str_pad(round(microtime(true) - time(), 3) * 10000, 3, '0', STR_PAD_LEFT) . random_int(100, 999);
            $model->status = Auth::user()->is_subscribe ? self::STATUS_WAIT : self::STATUS_HOLD;
            $model->user_id = Auth::user()->id;
            $model->proportion = Setting::integralProportion();
            $model->integral = round($model->money * $model->proportion);
            return $model->writeIntegralRecord();
        });
        self::registerModelEvent('created', function (self $model) {
            if ($model->status == self::STATUS_WAIT && $model->isDirty('status')) {
                dispatch(new WithdrawJob($model));
            }
        });
    }

    protected function writeIntegralRecord()
    {
        return IntegralBlotter::outByWithdraw($this->user_id, $this->integral, '提现扣除积分');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function running()
    {
        $this->status = self::STATUS_RUNNING;
        return $this->save();
    }

    public function success($number)
    {
        $this->status = self::STATUS_SUCCESS;
        $this->wechat_order_number = $number;
        return $this->save();
    }

    public function fail($reason)
    {
        $this->status = self::STATUS_FAILED;
        $this->fail_reason = $reason;
        return $this->save();
    }

    public function retry()
    {
        $this->status = self::STATUS_WAIT;
        return $this->save();
    }


}
