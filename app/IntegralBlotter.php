<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\IntegralBlotter
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $serial_number
 * @property integer $user_id
 * @property integer $numerical
 * @property integer $barcode_verify_record_id
 * @property integer $order_id
 * @property integer $balance
 * @property string $remark
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereNumerical($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereBarcodeVerifyRecordId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereDeletedAt($value)
 * @property-read \App\User $user
 * @property integer $barcode_id
 * @property integer $product_activity_id
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereBarcodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereProductActivityId($value)
 * @property integer $product_activity_rule_id
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereProductActivityRuleId($value)
 * @property boolean $status
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereStatus($value)
 * @property-read \App\Barcode $barcode
 * @property-read mixed $status_text
 * @property-read mixed $integral
 * @property integer $withdraws_id
 * @method static \Illuminate\Database\Query\Builder|\App\IntegralBlotter whereWithdrawsId($value)
 */
class IntegralBlotter extends Model
{
    const STATUS_HOLD = 10;
    const STATUS_SUCCESS = 20;

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->serial_number = '1' . date('YmdHis') . str_pad(round(microtime(true) - time(), 3) * 10000, 3, '0', STR_PAD_LEFT) . random_int(100, 999);
            return $model->writeBackBarcode();
        });
        self::registerModelEvent('saving', function (self $model) {
            $model->balanceCalculation();
            return $model->writeBackUserIntegral();
        });
    }

    protected static function statusLabelList()
    {
        return [
            self::STATUS_HOLD => '等待关注',
            self::STATUS_SUCCESS => '发放成功',
        ];
    }

    /**
     * 反写账户余额
     */

    protected function writeBackUserIntegral()
    {
        if ($this->status === self::STATUS_SUCCESS && $this->isDirty('status')) {
            if ($this->user->integral + $this->numerical < 0) {
                return false;
            }
            return $this->user->setAttribute('integral', $this->user->integral + $this->numerical)->save();
        }
        return true;
    }

    /**
     * 反写条码状态
     * @return bool
     */

    protected function writeBackBarcode()
    {
        if (!empty($this->barcode_id)) {
            return $this->barcode->setAttribute('integral_user_id', $this->user_id)->setAttribute('integral_verified_at', Carbon::now())->setAttribute('integral_status', Barcode::STATUS_USED)->save();
        }
        return true;
    }

    /**
     * 计算余额
     */

    protected function balanceCalculation()
    {
        $this->balance = $this->user->integral + $this->numerical;
    }

    /**
     * @param $user_id
     * @param $numerical
     * @param $remark
     * @param $barcode_id
     * @param bool $immediately
     * @return bool
     */
    public static function inByBarcode($user_id, $numerical, $remark, $barcode_id, $immediately = true)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('numerical', $numerical)
            ->setAttribute('remark', $remark)
            ->setAttribute('barcode_id', $barcode_id)
            ->setAttribute('status', ($immediately === true ? self::STATUS_SUCCESS : self::STATUS_HOLD))
            ->save();
    }

    /**
     * @param $user_id
     * @param $numerical
     * @param $remark
     * @param $barcode_id
     * @param $product_activity_id
     * @param $product_activity_rule_id
     * @param bool $immediately
     * @return bool
     */

    public static function inByBarcodeWithProductActivity($user_id, $numerical, $remark, $barcode_id, $product_activity_id, $product_activity_rule_id, $immediately = true)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('numerical', $numerical)
            ->setAttribute('remark', $remark)
            ->setAttribute('barcode_id', $barcode_id)
            ->setAttribute('product_activity_id', $product_activity_id)
            ->setAttribute('product_activity_rule_id', $product_activity_rule_id)
            ->setAttribute('status', ($immediately === true ? self::STATUS_SUCCESS : self::STATUS_HOLD))
            ->save();
    }

    public static function inByOrder($user_id, $numerical, $remark, $order_id)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('numerical', $numerical)
            ->setAttribute('remark', $remark)
            ->setAttribute('order_id', $order_id)
            ->setAttribute('status', self::STATUS_SUCCESS)
            ->save();
    }

    public static function inByCoupon($user_id, $numerical, $remark)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('numerical', $numerical)
            ->setAttribute('remark', $remark)
            ->setAttribute('status', self::STATUS_SUCCESS)
            ->save();
    }


    /**
     * @param $user_id
     * @param $numerical
     * @param $remark
     * @return bool
     */

    public static function outByOrder($user_id, $numerical, $remark)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('numerical', -$numerical)
            ->setAttribute('remark', $remark)
            ->setAttribute('status', self::STATUS_SUCCESS)
            ->save();
    }

    public static function outByCoupon($user_id, $numerical, $remark)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('numerical', -$numerical)
            ->setAttribute('remark', $remark)
            ->setAttribute('status', self::STATUS_SUCCESS)
            ->save();
    }

    /**
     * @param $user_id
     * @param $numerical
     * @param $remark
     * @return bool
     */

    public static function outByWithdraw($user_id, $numerical, $remark)
    {
        return (new self())->setAttribute('user_id', $user_id)
            ->setAttribute('status', self::STATUS_SUCCESS)
            ->setAttribute('numerical', -$numerical)
            ->setAttribute('remark', $remark)
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

    public function getIntegralAttribute()
    {
        return $this->user->integral;
    }

    public function barcode()
    {
        return $this->belongsTo('App\Barcode');
    }

    public function send()
    {
        $this->status = self::STATUS_SUCCESS;
        return $this->save();
    }
}
