<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/28
 * Time: 11:16
 */

namespace App;


use Illuminate\Database\Eloquent\Builder;

/**
 * App\Administrator
 *
 * @property integer $id
 * @property string $name
 * @property boolean $sex
 * @property string $birthday
 * @property string $mobile
 * @property string $childName
 * @property boolean $childSex
 * @property string $childBirthday
 * @property integer $integral
 * @property boolean $status
 * @property boolean $role
 * @property string $username
 * @property string $password
 * @property string $openid
 * @property string $unionid
 * @property string $subscribed_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LoginVerify[] $loginVerify
 * @property-read mixed $is_subscribe
 * @property-read mixed $is_admin
 * @property-read mixed $is_member
 * @property-read mixed $is_employee
 * @property-read mixed $is_boss
 * @property-read mixed $is_sale
 * @property-read mixed $is_lock
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereChildName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereChildSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereChildBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereIntegral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereUnionid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereSubscribedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Administrator whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $sex_text
 * @property-read mixed $child_sex_text
 * @property-read \App\Employee $employee
 * @property-read mixed $is_has_apply_shop_staff
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ShopStaffApply[] $shopStaffApply
 * @property-read mixed $status_text
 * @property-read mixed $can_convert_commission
 * @property-read \App\Sale $sale
 * @property-read mixed $boss_id
 */
class Administrator extends User
{
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(function (Builder $query) {
            return $query->where('role', self::ROLE_ADMIN);
        });
    }
}