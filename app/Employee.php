<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Employee
 *
 * @property integer $id
 * @property integer $employee_apply_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\User $user
 * @property-read \App\EmployeeApply $apply
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereEmployeeApplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $name
 * @property-read mixed $mobile
 * @property-read mixed $province_name
 * @property-read mixed $city_name
 * @property-read mixed $county_name
 * @property-read mixed $address
 * @property-read mixed $full_address
 * @property string $token
 * @method static \Illuminate\Database\Query\Builder|\App\Employee whereToken($value)
 * @property-read mixed $department_name
 * @property-read mixed $status_text
 * @property-read mixed $is_leave
 */
class Employee extends Model
{
    const STATUS_NORMAL = 10;
    const STATUS_LEAVE = 20;

    protected $attributes = [
        'status' => self::STATUS_NORMAL
    ];

    protected $fillable = [
        'id',
    ];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->token = str_random(40);
        });
        self::registerModelEvent('saving', function (self $model) {
            if ($model->status === self::STATUS_NORMAL) return $model->user->setAttribute('role', User::ROLE_EMPLOYEE)->save();
            if ($model->status === self::STATUS_LEAVE) return $model->user->setAttribute('role', User::ROLE_MEMBER)->save();
        });
    }

    public static function statusLabelList()
    {
        return [
            self::STATUS_NORMAL => '在职',
            self::STATUS_LEAVE => '离职',
        ];
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    public function apply()
    {
        return $this->belongsTo('App\EmployeeApply', 'employee_apply_id');
    }

    public function getNameAttribute()
    {
        return $this->apply->name;
    }

    public function getMobileAttribute()
    {
        return $this->apply->mobile;
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

    public function getDepartmentNameAttribute()
    {
        return $this->apply->department_name;
    }

    public function getStatusTextAttribute()
    {
        return self::statusLabelList()[$this->status];
    }

    public function getIsLeaveAttribute()
    {
        return $this->status === self::STATUS_LEAVE;
    }
}
