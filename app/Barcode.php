<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Barcode
 *
 * @mixin \Eloquent
 * @property-read mixed $is_used
 * @property-read mixed $status
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
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereGenerateBarcodeTaskId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereCommissionPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereCommissionStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereCommissionVerifyTimes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereCommissionLastVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereCommissionUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereIntegralPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereIntegralStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereIntegralVerifyTimes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereIntegralLastVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereIntegralUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereDeletedAt($value)
 * @property string $commission_verified_at
 * @property string $integral_verified_at
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereCommissionVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Barcode whereIntegralVerifiedAt($value)
 * @property-read mixed $product_name
 */
class Barcode extends Model
{
    const TYPE_MEMBER = 10;
    const TYPE_SALE = 20;

    const STATUS_WAIT = 10;
    const STATUS_USED = 20;
    const STATUS_CANCEL = 30;

    protected $fillable = [
        'generate_barcode_task_id',
        'serial_number',
        'product_id',
        'commission_password',
        'integral_password',
    ];

    public static $statusTextMap = [
        self::STATUS_WAIT => "未使用",
        self::STATUS_USED => "已使用",
        self::STATUS_CANCEL => "已作废"
    ];

    protected $attributes = [
        'commission_status' => self::STATUS_WAIT,
        'integral_status' => self::STATUS_WAIT,
    ];

    public static function typeLabelList()
    {
        return [
            self::TYPE_SALE => '导购码',
            self::TYPE_MEMBER => '会员码',
        ];
    }

    public function getStatusAttribute()
    {
        return null;
    }

    public function getIntegralStatusTextAttribute()
    {
        return self::$statusTextMap[$this->integral_status];
    }

    public function getCommissionStatusTextAttribute()
    {
        return self::$statusTextMap[$this->commission_status];
    }

    public function getIsUsedAttribute()
    {
        return $this->status > self::STATUS_WAIT;
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }

    protected function scanInternal(User $user, $type)
    {
        BarcodeVerifyRecord::record($user, $this->id, $type);
    }

    protected function rewardsInternal(User $user)
    {
        if ($user->is_lock) {
            response(view('scan.user-locked'))->send();
            exit;
        }
    }

}
