<?php

namespace App;

/**
 * App\MemberBarcode
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
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereGenerateBarcodeTaskId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereCommissionPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereCommissionStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereCommissionVerifyTimes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereCommissionLastVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereCommissionUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereIntegralPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereIntegralStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereIntegralVerifyTimes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereIntegralLastVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereIntegralUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereDeletedAt($value)
 * @property string $commission_verified_at
 * @property string $integral_verified_at
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereCommissionVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MemberBarcode whereIntegralVerifiedAt($value)
 * @property-read mixed $product_name
 */

class MemberBarcode extends Barcode
{
    protected $table = 'barcodes';

    public function getPasswordAttribute()
    {
        return $this->integral_password;
    }

    public function getStatusAttribute()
    {
        return $this->integral_status;
    }

    public function getLastVerifiedAtAttribute()
    {
        return $this->last_verified_at;
    }

    public function getVerifyTimesAttribute()
    {
        return $this->integral_verify_times;
    }

    public static function findCode($serial_number, $password)
    {
        return self::where('serial_number', $serial_number)->where('integral_password', md5($password))->first();
    }

    public function scan(User $user)
    {
        $this->scanInternal($user, self::TYPE_MEMBER);
    }

    public function rewards(User $user)
    {
        $this->rewardsInternal($user);
        $result = true;
        $baseIntegral = $this->product->getIntegralRewards();
        $extendIntegral = 0;
        if ($integralActivity = $this->product->getIntegralActivity()) {
            $extendIntegral = $integralActivity->rewards($this->product);
        }
        if ($extendIntegral > 0 && $integralActivity && $integralActivity->is_alone) {
            $result = $result === true && IntegralBlotter::inByBarcodeWithProductActivity($user->id, $baseIntegral, '扫码获取积分', $this->id, $integralActivity->id, null, $user->is_subscribe);
            $result = $result === true && IntegralBlotter::inByBarcodeWithProductActivity($user->id, $extendIntegral, '扫码奖励积分', $this->id, $integralActivity->id, null, $user->is_subscribe);
        } elseif ($integralActivity) {
            $result = $result === true && IntegralBlotter::inByBarcodeWithProductActivity($user->id, $baseIntegral + $extendIntegral, '扫码获取积分', $this->id, $integralActivity->id, null, $user->is_subscribe);
        } else {
            $result = $result === true && IntegralBlotter::inByBarcodeWithProductActivity($user->id, $baseIntegral, '扫码获取积分', $this->id, null, null, $user->is_subscribe);
        }
        $redPacket = 0;
        if ($redPacketActivity = $this->product->getRedPacketActivity()) {
            $redPacket = $redPacketActivity->rewards($this->product);
            $result = $result === true && CommissionBlotter::inByBarcodeWithProductActivity($user->id, $redPacket, '扫码奖励红包', $this->id, $redPacketActivity->id, null, $user->is_subscribe);
        }
        if ($result === true) {
            return view('frontend.scan.success-member', ['barCode' => $this, 'integral' => $baseIntegral, 'extendIntegral' => $extendIntegral, 'redPacket' => $redPacket]);
        }
        return view('frontend.scan.system-busy');
    }
}
