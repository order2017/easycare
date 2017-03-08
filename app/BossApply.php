<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/28
 * Time: 21:30
 */

namespace App;


use Illuminate\Database\Eloquent\Builder;

/**
 * App\BossApply
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
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereProvinceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereCountyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereAuditedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereDeletedAt($value)
 * @mixin \Eloquent
 * @property string $address
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereAddress($value)
 * @property-read \App\Employee $employee
 * @property integer $user_id
 * @property-read mixed $full_address
 * @property-read mixed $employee_name
 * @method static \Illuminate\Database\Query\Builder|\App\BossApply whereUserId($value)
 * @property-read mixed $region
 * @property mixed role_name
 * @property-read mixed $role_name
 */
class BossApply extends ShopStaffApply
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
            return $query->where('role', User::ROLE_BOSS);
        });
        self::registerModelEvent('updating', function (self $model) {
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackBoss();
            }
            return true;
        });
    }

    protected function writeBackBoss()
    {
        return Boss::findOrNew($this->user_id)
            ->setAttribute('id', $this->user_id)
            ->setAttribute('shop_staff_apply_id', $this->id)
            ->setAttribute('employees_id', $this->employees_id)
            ->save();
    }
    
  
}