<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ShopStaffApply
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $employee_id
 * @property string $name
 * @property string $mobile
 * @property boolean $type
 * @property boolean $status
 * @property string $reason
 * @property string $last_audit_time
 * @property integer $audit_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereLastAuditTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereDeletedAt($value)
 * @mixin \Eloquent
 * @property integer $province_id
 * @property string $province_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $county_id
 * @property string $county_name
 * @property integer $boss_id
 * @property boolean $role
 * @property string $audited_at
 * @property integer $employees_id
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereProvinceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereCountyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereAuditedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereEmployeesId($value)
 * @property string $address
 * @method static \Illuminate\Database\Query\Builder|\App\ShopStaffApply whereAddress($value)
 * @property-read \App\Employee $employee
 * @property-read mixed $full_address
 * @property-read mixed $employee_name
 * @property-read mixed $region
 */
class ShopStaffApply extends Model
{
    use SoftDeletes;

    const STATUS_WAIT = 10;
    const STATUS_REFUSAL = 20;
    const STATUS_APPROVE = 30;
    const STATUS_WAIT_FOT_PADDING = 40;


    protected $attributes = [
        'status' => self::STATUS_WAIT_FOT_PADDING,
    ];

    protected $fillable = [
        'name',
        'mobile',
        'province_id',
        'city_id',
        'county_id',
        'role',
        'boss_id',
        'employees_id',
        'user_id'
    ];

    public static function roleList()
    {
        return [
            User::ROLE_BOSS => '老板',
            User::ROLE_SALE => '导购',
        ];
    }
    
    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('saving', function (self $model) {
            $model->province_name = Region::getName($model->province_id);
            $model->city_name = Region::getName($model->city_id);
            $model->county_name = Region::getName($model->county_id);
        });
        self::registerModelEvent('updating', function (self $model) {
            if (in_array($model->status, [self::STATUS_APPROVE, self::STATUS_REFUSAL]) && $model->isDirty('status')) {
                $model->audit_user_id = \Auth::guard('admin')->user()['id'];
                $model->audited_at = Carbon::now();
            }
        });
    }

    public function approve()
    {
        return $this->setAttribute('status', self::STATUS_APPROVE)->saveOrFail();
    }

    public function refusal($reason)
    {
        return $this->setAttribute('status', self::STATUS_REFUSAL)->setAttribute('reason', $reason)->save();
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employees_id');
    }

    public function getRegionAttribute()
    {
        return $this->province_name . $this->city_name . $this->county_name;
    }

    public function getEmployeeNameAttribute()
    {
        return $this->employee->name;
    }
}
