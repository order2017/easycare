<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ShopApply
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property integer $province_id
 * @property string $province_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $county_id
 * @property string $county_name
 * @property string $address
 * @property string $location
 * @property string $phone
 * @property integer $boss_id
 * @property string $intro
 * @property string $reason
 * @property boolean $status
 * @property string $audited_at
 * @property integer $audit_user_id
 * @property integer $employees_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereProvinceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereCountyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereAuditedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereDeletedAt($value)
 * @property string $images
 * @property-read \App\Boss $boss
 * @property string boss_name
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereImages($value)
 * @property integer $shop_id
 * @property-read mixed $full_address
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereShopId($value)
 * @property string $thumb
 * @property string $landmark
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereThumb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ShopApply whereLandmark($value)
 * @property-read mixed $boss_name
 * @property-read mixed $employees_name
 * @property-read \App\Employee $employee
 */
class ShopApply extends Model
{
    use SoftDeletes;

    const STATUS_WAIT = 10;
    const STATUS_REFUSAL = 20;
    const STATUS_APPROVE = 30;

    protected $fillable = [
        'boss_id',
        'name',
        'phone',
        'province_id',
        'city_id',
        'county_id',
        'address',
        'audit_user_id',
        'employees_id',
        'shop_id',
        'thumb',
        'landmark',
        'images',
        'intro',
        'thumb',
        'location',
        'shop_id'
    ];

    protected $attributes = [
        'status' => self::STATUS_WAIT,
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            if (empty($model->shop_id)) {
                $model->shop_id = null;
            }
            $model->province_name = Region::getName($model->province_id);
            $model->city_name = Region::getName($model->city_id);
            $model->county_name = Region::getName($model->county_id);
        });
        self::registerModelEvent('saving', function (self $model) {
            if (!\Storage::exists($model->thumb)) {
                \Storage::put($model->thumb, app('wechat')->material_temporary->getStream($model->thumb));
            }
            if (!empty($model->images) && is_array($model->images)) {
                foreach ($model->images as $image) {
                    if (!empty($image) && !\Storage::exists($image)) {
                        \Storage::put($image, app('wechat')->material_temporary->getStream($image));
                    }
                }
            }
        });
        self::registerModelEvent('updating', function (self $model) {
            if (in_array($model->status, [self::STATUS_APPROVE, self::STATUS_REFUSAL]) && $model->isDirty('status')) {
                $model->audit_user_id = \Auth::guard('admin')->user()['id'];
                $model->audited_at = Carbon::now();
            }
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackShop();
            }
            return true;
        });

    }

    protected function writeBackShop()
    {
        return Shop::findOrNew($this->shop_id)->setAttribute('shop_applies_id', $this->id)->setAttribute('employees_id', $this->employees_id)->setAttribute('boss_id', $this->boss_id)->save();

    }

    public static function checkHasApply($employees_id)
    {
        return self::whereStatus(self::STATUS_WAIT)->whereEmployeesId($employees_id)->exists();
    }

    public function approve()
    {
        return $this->setAttribute('status', self::STATUS_APPROVE)->saveOrFail();
    }

    public function refusal($reason)
    {
        return $this->setAttribute('status', self::STATUS_REFUSAL)->setAttribute('reason', $reason)->save();
    }

    public function getFullAddressAttribute()
    {
        return $this->province_name . $this->city_name . $this->county_name . $this->address;
    }

    public function getBossNameAttribute()
    {
        return $this->boss->name;
    }

    public function getEmployeesNameAttribute(){
        return $this->employee->name;
    }

    public function boss()
    {
        return $this->belongsTo('App\Boss', 'boss_id');
    }

    public function employee(){
        return $this->belongsTo('App\Employee','employees_id');
    }

}
