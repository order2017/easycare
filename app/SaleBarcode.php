<?php

namespace App;

/**
 * App\SaleBarcode
 *
 * @property-read mixed $password
 * @property-read mixed $status
 * @property-read mixed $last_verified_at
 * @property-read mixed $verify_times
 * @property-read mixed $is_used
 * @mixin \Eloquent
 * @property-read \App\Product $product
 * @property integer $id
 * @property integer $generate_barcode_task_id
 * @property integer $product_id
 * @property string $serial_number
 * @property string $commission_password
 * @property boolean $commission_status
 * @property integer $commission_verify_times
 * @property string $commission_last_verified_at
 * @property integer $commission_user_id
 * @property string $integral_password
 * @property boolean $integral_status
 * @property integer $integral_verify_times
 * @property string $integral_last_verified_at
 * @property integer $integral_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereGenerateBarcodeTaskId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereCommissionPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereCommissionStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereCommissionVerifyTimes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereCommissionLastVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereCommissionUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereIntegralPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereIntegralStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereIntegralVerifyTimes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereIntegralLastVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereIntegralUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereDeletedAt($value)
 * @property-read \App\User $user
 * @property-read \App\Sale $sale
 * @property string $commission_verified_at
 * @property string $integral_verified_at
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereCommissionVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleBarcode whereIntegralVerifiedAt($value)
 * @property-read mixed $product_name
 */
class SaleBarcode extends Barcode
{
    protected $table = 'barcodes';

    public function getPasswordAttribute()
    {
        return $this->commission_password;
    }

    public function getStatusAttribute()
    {
        return $this->commission_status;
    }

    public function getLastVerifiedAtAttribute()
    {
        return $this->commission_verified_at;
    }

    public function getVerifyTimesAttribute()
    {
        return $this->commission_verify_times;
    }

    public static function findCode($serial_number, $password)
    {
        return self::whereSerialNumber($serial_number)->whereCommissionPassword(md5($password))->first();
    }

    public function sale()
    {
        return $this->belongsTo('App\Sale', 'commission_user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'commission_user_id');
    }


    public function scan(User $user)
    {
        $this->scanInternal($user, self::TYPE_SALE);
    }

    public function rewards(User $user)
    {
        $this->rewardsInternal($user);
        $result = true;
        $baseCommission = $this->product->getCommissionRewards();
        $extendCommission = 0;
        if ($commissionActivity = $this->product->getSaleActivity()) {
            $extendCommission = $commissionActivity->rewards($this->product);
        }
        if ($extendCommission > 0 && $commissionActivity && $commissionActivity->is_alone) {
            $result == true && $result = CommissionBlotter::inByBarcodeWithProductActivity($user->id, $extendCommission, '扫码活动奖励', $this->id, $commissionActivity->id, $commissionActivity->rule_id, $user->is_subscribe);
            $result == true && $result = CommissionBlotter::inByBarcodeWithProductActivity($user->id, $baseCommission, '扫码获取佣金', $this->id, null, null, $user->is_subscribe);
        } elseif ($commissionActivity) {
            $result == true && $result = CommissionBlotter::inByBarcodeWithProductActivity($user->id, $baseCommission + $extendCommission, '扫码获取佣金', $this->id, $commissionActivity->id, $commissionActivity->rule_id, $user->is_subscribe);
        } else {
            $result == true && $result = CommissionBlotter::inByBarcodeWithProductActivity($user->id, $baseCommission, '扫码获取佣金', $this->id, null, null, $user->is_subscribe);
        }
        if ($result == true) {
            return view('frontend.scan.success-sale', ['barCode' => $this, 'baseCommission' => $baseCommission, 'extendCommission' => $extendCommission]);
        }
        return view('frontend.scan.system-busy');
    }
}
