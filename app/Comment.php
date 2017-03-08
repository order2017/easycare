<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $content
 * @property boolean $point
 * @property integer $order_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment wherePoint($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereDeletedAt($value)
 * @property boolean $type
 * @property integer $user_coupon_id
 * @property-read \App\Order $order
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereUserCouponId($value)
 * @property string $images
 * @method static \Illuminate\Database\Query\Builder|\App\Comment whereImages($value)
 * @property-read mixed $user_name
 */
class Comment extends Model
{
    const TYPE_GOODS = 10;
    const TYPE_COUPON = 20;

    protected $attributes = [
        'type' => self::TYPE_GOODS
    ];

    protected $casts=[
        'images' => 'array',
    ];
    
    protected $fillable = [
        'content',
        'order_id',
        'point',
        'images',
    ];

    public static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            if (!empty($model->images) && is_array($model->images)) {
                foreach ($model->images as $image) {
                    if (!empty($image) && !\Storage::exists($image)) {
                        \Storage::put($image, app('wechat')->material_temporary->getStream($image));
                    }
                }
            }
        });
        self::registerModelEvent('saving',function (self $model){
           return $model->writeBackOrder();
        });
        
    }

    public function writeBackOrder()
    {
        return Order::findOrNew($this->order_id)->setAttribute('comment_status',Order::COMMENTS_FINISH)->save();
    }

    public function order()
    {
        return $this->belongsTo('App\Order','order_id');
    }
    
    public function getUserNameAttribute()
    {
        return $this->order->username;
    }
}
