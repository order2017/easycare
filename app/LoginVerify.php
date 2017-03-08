<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\LoginVerify
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\LoginVerify whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LoginVerify whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LoginVerify whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LoginVerify whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LoginVerify whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LoginVerify whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LoginVerify whereDeletedAt($value)
 * @property-read mixed $is_expired
 * @property-read mixed $is_success
 * @property-read \App\User $user
 */
class LoginVerify extends Model
{
    const STATUS_WAIT = 10;
    const STATUS_SUCCESS = 20;
    const STATUS_CANCEL = 30;

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->token = str_random(40);
        });
    }

    protected $attributes = [
        'status' => self::STATUS_WAIT,
    ];

    public static function generateByUserId($user_id)
    {
        $m = new self();
        $m->setAttribute('user_id', $user_id)->saveOrFail();
        return $m;
    }

    public function getIsExpiredAttribute()
    {
        return $this->created_at->timestamp < (time() - 180);
    }

    public function getIsSuccessAttribute()
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function verifyUser($openid)
    {
        return $this->user->openid == $openid;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function confirm()
    {
        return $this->setAttribute('status', self::STATUS_SUCCESS)->saveOrFail();
    }
}
