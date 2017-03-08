<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/28
 * Time: 21:37
 */

namespace App;


use Illuminate\Database\Eloquent\Builder;

/**
 * App\SaleApply
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property integer $province_id
 * @property string $province_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $county_id
 * @property string $county_name
 * @property integer $boss_id
 * @property boolean $role
 * @property string $reason
 * @property boolean $status
 * @property string $audited_at
 * @property integer $audit_user_id
 * @property integer $employees_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Boss $boss
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereProvinceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereCountyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereAuditedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereDeletedAt($value)
 * @mixin \Eloquent
 * @property string $address
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereAddress($value)
 * @property-read \App\SaleApply $apply
 * @property-read mixed $full_address
 * @property-read \App\Employee $employee
 * @property integer $user_id
 * @property-read mixed $employee_name
 * @method static \Illuminate\Database\Query\Builder|\App\SaleApply whereUserId($value)
 * @property-read mixed $region
 * @property mixed role_name
 * @property-read mixed $role_name
 */
class SaleApply extends ShopStaffApply
{
    protected $table = 'shop_staff_applies';

    
    const BOSS = '老板';
    const SALE = '导购';

    public function getRoleNameAttribute()
    {
        if ($this->role === User::ROLE_BOSS)
        {
            return $this->IsBoss();
        }
        else if ($this->role === User::ROLE_SALE)
        {
            return $this->IsSale();
        }
    }

    public static function IsBoss()
    {
        return self::BOSS;
    }

    public static function IsSale()
    {
        return self::SALE;
    }

    
    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(function (Builder $query) {
            return $query->where('role', User::ROLE_SALE);
        });
        self::registerModelEvent('updating', function (self $model) {
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackSale();
            }
            return true;
        });
    }

    protected function writeBackSale()
    {
        return Sale::findOrNew($this->user_id)
            ->setAttribute('id', $this->user_id)
            ->setAttribute('employees_id', $this->employees_id)
            ->setAttribute('shop_staff_apply_id', $this->id)
            ->setAttribute('boss_id', $this->boss_id)
            ->save();
    }

    public function boss()
    {
        return $this->belongsTo('App\Boss', 'boss_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employees_id');
    }
    
}