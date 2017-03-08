<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property boolean $sex
 * @property string $birthday
 * @property string $mobile
 * @property string $childName
 * @property boolean $childSex
 * @property string $childBirthday
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
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereChildName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereChildSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereChildBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUnionid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSubscribedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $is_subscribe
 * @property-read mixed $is_admin
 * @property-read mixed $is_member
 * @property-read mixed $is_employee
 * @property-read mixed $is_boss
 * @property-read mixed $is_sale
 * @property-read mixed $verify_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LoginVerify[] $loginVerify
 * @property-read mixed $is_lock
 * @property integer $integral
 * @method static \Illuminate\Database\Query\Builder|\App\User whereIntegral($value)
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
class User extends Model implements Authenticatable
{
    use SoftDeletes;

    const ROLE_ADMIN = 100;
    const ROLE_MEMBER = 10;
    const ROLE_EMPLOYEE = 20;
    const ROLE_BOSS = 30;
    const ROLE_SALE = 40;

    const STATUS_NORMAL = 10;
    const STATUS_LOCK = 20;

    const SEX_MAN = 10;
    const SEX_WOMAN = 20;

    protected $attributes = [
        'role' => self::ROLE_MEMBER,
        'status' => self::STATUS_NORMAL,
        'username' => null,
    ];

    protected $fillable = [
        'name',
        'sex',
        'mobile',
        'birthday',
        'childName',
        'childSex',
        'childBirthday'
    ];

    /**
     * @param $openid
     * @return Model|mixed|null|static
     */

    public static function registerByOpenid($openid)
    {
        $m = new self();
        $m->setAttribute('openid', $openid)->saveOrFail();
        return $m;
    }

    public static function sexLabelList()
    {
        return [
            self::SEX_MAN => '男',
            self::SEX_WOMAN => '女'
        ];
    }

    public function getCanConvertCommissionAttribute()
    {
        $amount = round($this->integral / Setting::integralProportion(), 2);
        return $amount >= 1 ? $amount : 0;
    }

    public static function statusLabelList()
    {
        return [
            self::STATUS_NORMAL => '正常',
            self::STATUS_LOCK => '已冻结'
        ];
    }

    /**
     * @param $openid
     * @return Model|mixed|null|static
     */

    public static function findByOpenid($openid)
    {
        return self::whereOpenid($openid)->first();
    }

    /**
     * @param $username
     * @return Model|mixed|null|static
     */

    public static function findByUsername($username)
    {
        return self::whereUsername($username)->first();
    }

    /**
     * @param $password
     * @return bool
     */

    public function validatePassword($password)
    {
        return Hash::check($password, $this->password) && $this->is_admin;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function loginVerify()
    {
        return $this->hasMany('App\LoginVerify');
    }

    /**
     * @return bool
     */

    public function subscribe()
    {
        $this->sendReward();
        return $this->setAttribute('subscribed_at', Carbon::now())->save();
    }

    /**
     * @return bool
     */

    public function unSubscribe()
    {
        return $this->setAttribute('subscribed_at', null)->save();
    }

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id');
    }

    public function getIsHasApplyShopStaffAttribute()
    {
        return !$this->shopStaffApply->isEmpty();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function shopStaffApply()
    {
        return $this->hasMany('App\ShopStaffApply');
    }

    /**
     * @return bool
     */

    public function getIsSubscribeAttribute()
    {
        return !empty($this->subscribed_at);
    }

    public function getIsAdminAttribute()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function getIsMemberAttribute()
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function getIsEmployeeAttribute()
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function getIsBossAttribute()
    {
        return $this->role === self::ROLE_BOSS;
    }

    public function getIsSaleAttribute()
    {
        return $this->role === self::ROLE_SALE;
    }

    public function getIsLockAttribute()
    {
        return $this->status === self::STATUS_LOCK;
    }

    public function getSexTextAttribute()
    {
        return empty($this->sex) ? '' : self::sexLabelList()[$this->sex];
    }

    public function getChildSexTextAttribute()
    {
        return empty($this->childSex) ? '' : self::sexLabelList()[$this->childSex];
    }

    public function getStatusTextAttribute()
    {
        return self::statusLabelList()[$this->status];
    }


    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->id;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    public function sale()
    {
        return $this->hasOne('App\Sale', 'id', 'id');
    }

    public function getBossIdAttribute()
    {
        if ($this->is_boss) {
            return $this->id;
        } elseif ($this->is_sale) {
            return $this->sale->boss_id;
        }
        return null;
    }

    public function checkShopId($shopId)
    {
        return Shop::where('boss_id', $this->boss_id)->where('id', $shopId)->exists();
    }

    public function changePassword($password)
    {
        return $this->setAttribute('password',bcrypt($password))->save();
    }

    public function sendReward()
    {
        $commissionList = CommissionBlotter::whereStatus(CommissionBlotter::STATUS_HOLD)->whereUserId($this->id)->get();
        foreach ($commissionList as $commission) {
            $commission->retry();
        }
        $integralList = IntegralBlotter::whereStatus(IntegralBlotter::STATUS_HOLD)->whereUserId($this->id)->get();
        foreach ($integralList as $integral) {
            $integral->send();
        }
        $withdrawList = Withdraw::whereStatus(Withdraw::STATUS_HOLD)->whereUserId($this->id)->get();
        foreach ($withdrawList as $withdraw) {
            $withdraw->retry();
        }
    }
}
