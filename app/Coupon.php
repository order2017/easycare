<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Coupon
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $shop_id
 * @property integer $employees_id
 * @property integer $coupon_applies_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\CouponApply $apply
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereCouponAppliesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereDeletedAt($value)
 * @property-read mixed $title
 * @property-read mixed $type_name
 * @property-read mixed $data
 * @property-read mixed $shop_name
 * @property-read mixed $address
 * @property-read mixed $type
 * @property-read mixed $images
 * @property-read mixed $thumb
 * @property-read mixed $scope
 * @property-read mixed $condition
 * @property-read mixed $money
 * @property-read mixed $integral
 * @property-read mixed $discount
 * @property-read mixed $begin_time
 * @property-read mixed $end_time
 * @property-read mixed $duration
 * @property-read mixed $time_type_name
 * @property-read mixed $time_type
 * @property-read mixed $is_direct
 * @property-read mixed $thumb_url
 * @property-read mixed $shop_city
 * @property-read mixed $title_text
 * @property-read mixed $shop_id_num
 * @property integer $order
 * @property-read mixed $money_or_discount
 * @property-read mixed $time_name
 * @property-read mixed $description
 * @method static \Illuminate\Database\Query\Builder|\App\Coupon whereOrder($value)
 */
class Coupon extends Model
{
    const STATUS_NORMAL = 10;
    const STATUS_LEAVE = 20;


    protected $attributes = [
        'status' => self::STATUS_NORMAL,
    ];

    protected $fillable = [
        'id',
        'shop_id',
        'employees_id',
        'status',
        'coupon_applies_id'
    ];


    public function apply()
    {
        return $this->belongsTo('App\CouponApply', 'coupon_applies_id');
    }

    public function getTitleAttribute()
    {
        return $this->apply->title;
    }

    public function getTypeNameAttribute()
    {
        return $this->apply->type_list;
    }

    public function getImagesAttribute()
    {
        return $this->apply->images;
    }

    public function getThumbAttribute()
    {
        return $this->apply->thumb;
    }

    public function getShopNameAttribute()
    {
        return empty($this->apply->Shop) ? '伊斯卡尔直营' : $this->apply->Shop->name;
    }

    public function getShopIdNumAttribute()
    {
        return $this->apply->shop_id;
    }

    public function getIsDirectAttribute()
    {
        return empty($this->shop_id);
    }

    public function getThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->thumb]);
    }

    public function getShopCityAttribute()
    {
        return empty($this->apply->Shop) ? '' : $this->apply->Shop->city_name;
    }

    public function getScopeAttribute()
    {
        return $this->apply->scope;
    }

    public function getTypeAttribute()
    {
        return $this->apply->type;
    }

    public function getConditionAttribute()
    {
        return $this->apply->condition;
    }

    public function getMoneyAttribute()
    {
        return $this->apply->money;
    }

    public function getIntegralAttribute()
    {
        return $this->apply->integral;
    }

    public function getDiscountAttribute()
    {
        return $this->apply->discount;
    }

    public function getDurationAttribute()
    {
        return $this->apply->duration;
    }

    public function getBeginTimeAttribute()
    {
        return $this->apply->begin_time;
    }

    public function getEndTimeAttribute()
    {
        return $this->apply->end_time;
    }

    public function getTimeTypeNameAttribute()
    {
        return $this->apply->time_type_name;
    }

    public function getTimeTypeAttribute()
    {
        return $this->apply->time_type;
    }

    public function getTitleTextAttribute()
    {
        return $this->apply->title_text;
    }

    public function getMoneyOrDiscountAttribute()
    {
        return $this->type == CouponApply::TYPE_ZHEKOUQUAN ? $this->discount . '折' : $this->money . '元';
    }

    public function getTimeNameAttribute()
    {
        return $this->time_type == CouponApply::TIME_LENGTH ? $this->duration . '秒' : $this->begin_time . '至' . $this->end_time;
    }

    public function getDescriptionAttribute(){
        return $this->apply->description;
    }
}
