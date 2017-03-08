<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $to_user_id
 * @property boolean $type
 * @property boolean $status
 * @property string $read_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereToUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereReadAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereDeletedAt($value)
 * @property-read mixed $status_name
 * @property string $send_type
 * @method static \Illuminate\Database\Query\Builder|\App\Message whereSendType($value)
 * @property-read \App\User $user
 */
class Message extends Model
{
    const STATUS_UNREAD = 10;
    const STATUS_HAVE_READ = 20;

    const TYPE_ORDER_SUCCESS = 10;
    const TYPE_COUPON_SUCCESS = 20;

    const SEND_TYPE_SMS = 10;
    const SEND_TYPE_EMAIL = 20;
    const SEND_TYPE_WECHAT = 30;

    protected $casts = [
        'send_type' => 'array',
    ];

    protected $attributes = [
        'status' => self::STATUS_UNREAD
    ];

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('created', function (self $model) {
            $model->sendSms();
            //$model->sendEmail();
            $model->sendWechat();
        });
    }

    protected function sendSms()
    {
        in_array(self::SEND_TYPE_SMS, $this->send_type) && (new MessageSendRecord())
            ->setAttribute('message_id', $this->id)
            ->setAttribute('send_method', self::SEND_TYPE_SMS)
            ->setAttribute('to', $this->user->mobile)
            ->save();
    }

//    protected function sendEmail()
//    {
//        in_array(self::SEND_TYPE_SMS, $this->send_type) && (new MessageSendRecord())
//            ->setAttribute('message_id', $this->id)
//            ->setAttribute('send_method', self::SEND_TYPE_SMS)
//            ->setAttribute('to',$this->user->email)
//            ->save();
//    }

    protected function sendWechat()
    {
        in_array(self::SEND_TYPE_WECHAT, $this->send_type) && (new MessageSendRecord())
            ->setAttribute('message_id', $this->id)
            ->setAttribute('send_method', self::SEND_TYPE_WECHAT)
            ->setAttribute('to', $this->user->openid)
            ->save();
    }

    public static function send($type, $to_user_id, $title, $content, array $send_type = [])
    {
        return (new self())->setAttribute('title', $title)
            ->setAttribute('content', $content)
            ->setAttribute('to_user_id', $to_user_id)
            ->setAttribute('type', $type)
            ->setAttribute('send_type', $send_type)
            ->save();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }
}
