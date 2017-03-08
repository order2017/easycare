<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\UserAddress
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $province_id
 * @property string $province_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $county_id
 * @property string $county_name
 * @property string $address
 * @property string $contact
 * @property integer $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property mixed user
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereProvinceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereCountyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserAddress whereDeletedAt($value)
 * @property-read mixed $name
 * @property-read \App\User $user
 */
class UserAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'province_id',
        'province_name',
        'city_id',
        'city_name',
        'county_id',
        'county_name',
        'address',
        'contact',
        'phone'
    ];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('saving', function (self $model) {
            $model->province_name = Region::getName($model->province_id);
            $model->city_name = Region::getName($model->city_id);
            $model->county_name = Region::getName($model->county_id);
        });
    }

    public function getNameAttribute()
    {
        return $this->user->name;
    }

    public function user()
    {
        return $this->belongsTo('APP\User', 'user_id');
    }

}
