<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\EmployeeApply
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property integer $province_id
 * @property string $province_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $county_id
 * @property string $county_name
 * @property string $address
 * @property integer $departments_id
 * @property string $reason
 * @property boolean $status
 * @property string $audited_at
 * @property integer $audit_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereProvinceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereCountyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereDepartmentsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereAuditedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EmployeeApply whereDeletedAt($value)
 * @property-read mixed $department_name
 * @property-read \App\Department $department
 * @property-read mixed $full_address
 */
class EmployeeApply extends Model
{
    use SoftDeletes;

    const STATUS_WAIT = 10;
    const STATUS_REFUSAL = 20;
    const STATUS_APPROVE = 30;

    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'email',
        'province_id',
        'city_id',
        'county_id',
        'address',
        'departments_id',
    ];

    protected $attributes = [
        'status' => self::STATUS_WAIT,
    ];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->province_name = Region::getName($model->province_id);
            $model->city_name = Region::getName($model->city_id);
            $model->county_name = Region::getName($model->county_id);
        });
        self::registerModelEvent('updating', function (self $model) {
            if (in_array($model->status, [self::STATUS_APPROVE, self::STATUS_REFUSAL]) && $model->isDirty('status')) {
                $model->audit_user_id = \Auth::guard('admin')->user()['id'];
                $model->audited_at = Carbon::now();
            }
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackEmployee();
            }
            return true;
        });
    }

    protected function writeBackEmployee()
    {
        return Employee::findOrNew($this->user_id)->setAttribute('id', $this->user_id)->setAttribute('employee_apply_id', $this->id)->save();
    }

    public function approve()
    {
        return $this->setAttribute('status', self::STATUS_APPROVE)->saveOrFail();
    }

    public function refusal($reason)
    {
        return $this->setAttribute('status', self::STATUS_REFUSAL)->setAttribute('reason', $reason)->save();
    }

    public function getDepartmentNameAttribute()
    {
        return $this->department->name;
    }

    public function getFullAddressAttribute()
    {
        return $this->province_name . $this->city_name . $this->county_name . $this->address;
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'departments_id');
    }
}
