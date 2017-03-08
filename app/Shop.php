<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Shop
 *
 * @property integer $id
 * @property integer $boss_id
 * @property integer $employee_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $thumb
 * @property string $intro
 * @property string $location
 * @property boolean $status
 * @property string $reason
 * @property string $last_audit_time
 * @property integer $audit_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereThumb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereLastAuditTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereDeletedAt($value)
 * @mixin \Eloquent
 * @property integer $shop_applies_id
 * @property integer $employees_id
 * @property \App\ShopApply $apply
 * @property mixed province_name
 * @property mixed city_name
 * @property mixed county_name
 * @property mixed shopApply
 * @property mixed user
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereShopAppliesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Shop whereEmployeesId($value)
 * @property-read mixed $mobile
 * @property-read mixed $full_address
 * @property-read mixed $boss_name
 * @property-read mixed $thumb_url
 * @property-read mixed $land_mark
 * @property-read mixed $images
 * @property-read mixed $province_name
 * @property-read mixed $city_name
 * @property-read mixed $county_name
 * @property-read mixed $image_urls
 */
class Shop extends Model
{
    use SoftDeletes;
    const STATUS_NORMAL = 10;
    const STATUS_LEAVE = 20;

    protected $attributes = [
        'status' => self::STATUS_NORMAL
    ];

    protected $fillable = [
        'id',
    ];


    public function apply()
    {
        return $this->belongsTo('App\ShopApply', 'shop_applies_id');
    }

    public function getNameAttribute()
    {
        return $this->apply->name;
    }

    public function getPhoneAttribute()
    {
        return $this->apply->phone;
    }

    public function getProvinceNameAttribute()
    {
        return $this->apply->province_name;
    }

    public function getCityNameAttribute()
    {
        return $this->apply->city_name;
    }

    public function getCountyNameAttribute()
    {
        return $this->apply->county_name;
    }

    public function getAddressAttribute()
    {
        return $this->apply->address;
    }

    public function getFullAddressAttribute()
    {
        return $this->province_name . $this->city_name . $this->county_name . $this->address;
    }

    public function getBossNameAttribute()
    {
        return $this->apply->boss_name;
    }

    public function getIntroAttribute()
    {
        return $this->apply->intro;
    }

    public function getLandMarkAttribute()
    {
        return $this->apply->landmark;
    }

    public function getThumbAttribute()
    {
        return $this->apply->thumb;
    }

    public function getImagesAttribute()
    {
        return $this->apply->images;
    }

    public function getThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->thumb]);
    }

    public function getImageUrlsAttribute()
    {
        $return = [];
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                if (!empty($image)) {
                    $return[] = route('widget.images', ['name' => $image]);
                }
            }
        }
        return $return;
    }
}
