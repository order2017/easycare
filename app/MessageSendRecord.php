<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MessageSendRecord
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $message_id
 * @property integer $serial_number
 * @property boolean $send_method
 * @property string $wechat_msg_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereMessageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereSerialNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereSendMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereWechatMsgId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereDeletedAt($value)
 * @property string $to
 * @method static \Illuminate\Database\Query\Builder|\App\MessageSendRecord whereTo($value)
 */
class MessageSendRecord extends Model
{
    const STATUS_WAIT = 10;
    const STATUS_RUNNING = 20;
    const STATUS_SUCCESS = 30;
    const STATUS_FAILED = 40;

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->serial_number = '5' . date('YmdHis') . str_pad(round(microtime(true) - time(), 3) * 10000, 3, '0', STR_PAD_LEFT) . random_int(100, 999);
        });
    }
}
