<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\UserCoupon
 *
 * @property integer $id
 * @property string $coupon_number
 * @property string $password
 * @property integer $user_id
 * @property integer $coupon_id
 * @property integer $coupon_applies_id
 * @property integer $from_shop_id
 * @property integer $to_shop_id
 * @property integer $verify_user_id
 * @property integer $boss_id
 * @property integer $integral
 * @property boolean $status
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $comment_status
 * @property \Carbon\Carbon $begin_time
 * @property \Carbon\Carbon $end_time
 * @property-read \App\Coupon $couponNew
 * @property-read \App\CouponApply $coupon
 * @property-read mixed $is_expired
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereCouponNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereCouponId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereCouponAppliesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereFromShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereToShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereVerifyUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereIntegral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereCommentStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereBeginTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon whereEndTime($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon normal()
 * @method static \Illuminate\Database\Query\Builder|\App\UserCoupon expired()
 * @property-read mixed $is_used
 */
class UserCoupon extends Model
{
    const STATUS_WAIT = 10;
    const STATUS_FINISH = 20;

    const COMMENT_STATUS_NO = 10;
    const COMMENT_STATUS_YES = 20;

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'begin_time', 'end_time'];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->coupon_number = '6' . date('YmdHis') . str_pad(round(microtime(true) - time(), 3) * 10000, 3, '0', STR_PAD_LEFT) . random_int(100, 999);
            $model->password = str_random(10);
            $model->coupon_applies_id = $model->couponNew->coupon_applies_id;
            $model->from_shop_id = $model->couponNew->shop_id;
            $model->integral = $model->couponNew->integral;
            $model->begin_time = $model->couponNew->time_type == CouponApply::TIME_TERM ? $model->couponNew->begin_time : Carbon::now();
            $model->end_time = $model->couponNew->time_type == CouponApply::TIME_TERM ? $model->couponNew->end_time : Carbon::createFromTimestamp(time() + $model->couponNew->duration);
            return \Auth::user()->is_member && IntegralBlotter::outByCoupon($model->user_id, $model->integral, '购买优惠劵');
        });
        self::registerModelEvent('updating', function (self $model) {
            return $model->exchangeBoss();
        });
    }

    protected function exchangeBoss()
    {
        if ($this->status == self::STATUS_FINISH && $this->isDirty('status')) {
            return IntegralBlotter::inByCoupon($this->boss_id, $this->integral, '兑换优惠劵');
        }
        return true;
    }

    public function scopeNormal($query)
    {
        return $query->where('end_time', '>', Carbon::now())->where(['status' => self::STATUS_WAIT]);
    }

    public function scopeExpired($query)
    {
        return $query->where('end_time', '<', Carbon::now())->where(['status' => self::STATUS_WAIT]);
    }

    protected $attributes = [
        'status' => self::STATUS_WAIT,
        'comment_status' => self::COMMENT_STATUS_NO,
    ];

    public function couponNew()
    {
        return $this->belongsTo('App\Coupon', 'coupon_id');
    }

    public function coupon()
    {
        return $this->belongsTo('App\CouponApply', 'coupon_applies_id');
    }

    public function exchange()
    {
        if (!empty($this->from_shop_id) && !\Auth::user()->checkShopId($this->from_shop_id)) {
            return false;
        }
        $this->status = self::STATUS_FINISH;
        $this->boss_id = \Auth::user()->boss_id;
        return $this->save();
    }

    public function getIsExpiredAttribute()
    {
        return !Carbon::now()->between($this->begin_time, $this->end_time);
    }

    public function getIsUsedAttribute()
    {
        return $this->status > self::STATUS_WAIT;
    }
}
