<?php

namespace App;

use App\Jobs\SendCommissionJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\CommissionBlotter
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $serial_number
 * @property integer $user_id
 * @property float $numerical
 * @property float $balance
 * @property string $wechat_order_number
 * @property integer $product_id
 * @property integer $product_acitvity_id
 * @property string $remark
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereNumerical($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereWechatOrderNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereProductAcitvityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereDeletedAt($value)
 * @property integer $barcode_id
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereBarcodeId($value)
 * @property-read mixed $status_text
 * @property-read \App\User $user
 * @property-read \App\Barcode $barcode
 * @property integer $product_activity_id
 * @property integer $product_activity_rule_id
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereProductActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereProductActivityRuleId($value)
 * @property string $fail_reason
 * @method static \Illuminate\Database\Query\Builder|\App\CommissionBlotter whereFailReason($value)
 */
class CommissionBlotter extends Model
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

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->serial_number = '2' . date('YmdHis') . str_pad(round(microtime(true) - time(), 3) * 10000, 3, '0', STR_PAD_LEFT) . random_int(100, 999);
            return $model->writeBackBarcode();
        });
        self::registerModelEvent('saved', function (self $model) {
            if ($model->status == self::STATUS_WAIT && $model->isDirty('status')) {
                dispatch(new SendCommissionJob($model));
            }
        });
    }


    protected function writeBackBarcode()
    {
        if ($this->user->is_sale && !empty($this->barcode_id)) {
            return $this->barcode->setAttribute('commission_user_id', $this->user_id)->setAttribute('commission_verified_at', Carbon::now())->setAttribute('commission_status', Barcode::STATUS_USED)->save();
        }
        return true;
    }

    public static function inByBarcodeWithProductActivity($user_id, $numerical, $remark, $barcode_id, $product_activity_id, $product_activity_rule_id, $immediately = true)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('numerical', $numerical)
            ->setAttribute('remark', $remark)
            ->setAttribute('barcode_id', $barcode_id)
            ->setAttribute('product_activity_id', $product_activity_id)
            ->setAttribute('product_activity_rule_id', $product_activity_rule_id)
            ->setAttribute('status', ($immediately === true ? self::STATUS_WAIT : self::STATUS_HOLD))
            ->save();
    }

    public function getStatusTextAttribute()
    {
        return self::statusLabelList()[$this->status];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function barcode()
    {
        return $this->belongsTo('App\Barcode');
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
