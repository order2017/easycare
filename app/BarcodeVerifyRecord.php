<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\BarcodeVerifyRecord
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $barcode_id
 * @property string $verified_at
 * @property boolean $verify_type
 * @property boolean $result
 * @property integer $user_id
 * @property boolean $is_subscribe
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereBarcodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereVerifyType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereResult($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereIsSubscribe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BarcodeVerifyRecord whereDeletedAt($value)
 * @property-read \App\Barcode $barcode
 * @property-read \App\User $user
 * @property-read mixed $verify_type_text
 * @property-read mixed $is_subscribe_text
 */
class BarcodeVerifyRecord extends Model
{
    protected $casts = [
        'is_subscribe' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            return $model->writeBackTimes();
        });
    }

    public static function record(User $user, $barcode_id, $verify_type)
    {
        (new self())
            ->setAttribute('user_id', $user->id)
            ->setAttribute('barcode_id', $barcode_id)
            ->setAttribute('verify_type', $verify_type)
            ->setAttribute('is_subscribe', $user->is_subscribe)
            ->setAttribute('verified_at', Carbon::now())
            ->saveOrFail();
    }

    public function barcode()
    {
        return $this->belongsTo('App\Barcode');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    protected function writeBackTimes()
    {
        if ($this->verify_type == Barcode::TYPE_MEMBER) {
            return $this->barcode->setAttribute('integral_verify_times', $this->barcode->integral_verify_times + 1)->save();
        }
        if ($this->verify_type == Barcode::TYPE_SALE) {
            return $this->barcode->setAttribute('commission_verify_times', $this->barcode->commission_verify_times + 1)->save();
        }
        return true;
    }

    public function getVerifyTypeTextAttribute()
    {
        return Barcode::typeLabelList()[$this->verify_type];
    }

    public function getIsSubscribeTextAttribute()
    {
        return $this->is_subscribe ? '已关注' : '未关注';
    }
}