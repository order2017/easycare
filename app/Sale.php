<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * App\Sale
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $shop_staff_apply_id
 * @property integer $boss_id
 * @property integer $employees_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereShopStaffApplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sale whereDeletedAt($value)
 * @property-read \App\SaleApply $apply
 * @property-read mixed $name
 * @property-read mixed $mobile
 * @property-read mixed $province_name
 * @property-read mixed $city_name
 * @property-read mixed $county_name
 * @property-read mixed $address
 * @property-read mixed $full_address
 * @property-read mixed $boss_name
 * @property-read mixed $employee_name
 * @property-read \App\User $user
 * @property-read mixed $role_name
 * @property-read mixed $province_id
 * @property-read mixed $city_id
 * @property-read mixed $county_id
 */
class Sale extends Model
{
    use SoftDeletes;

    const STATUS_NORMAL = 10;
    const STATUS_LEAVE = 20;

    protected $attributes = [
        'status' => self::STATUS_NORMAL
    ];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('saving', function (self $model) {
            if ($model->status === self::STATUS_NORMAL) return $model->user->setAttribute('role', User::ROLE_SALE)->save();
            if ($model->status === self::STATUS_LEAVE) return $model->user->setAttribute('role', User::ROLE_MEMBER)->save();
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    public function apply()
    {
        return $this->belongsTo('App\SaleApply', 'shop_staff_apply_id');
    }

    public function getNameAttribute()
    {
        return $this->apply->name;
    }

    public function getMobileAttribute()
    {
        return $this->apply->mobile;
    }

    public function getProvinceIdAttribute()
    {
        return $this->apply->province_id;
    }

    public function getProvinceNameAttribute()
    {
        return $this->apply->province_name;
    }

    public function getCityIdAttribute()
    {
        return $this->apply->city_id;
    }

    public function getCityNameAttribute()
    {
        return $this->apply->city_name;
    }

    public function getCountyIdAttribute()
    {
        return $this->apply->county_id;
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
        return $this->apply->boss->name;
    }

    public function getEmployeeNameAttribute()
    {
        return $this->apply->employee->name;
    }

    public function getRoleNameAttribute()
    {
        return $this->apply->role_name;
    }
}
