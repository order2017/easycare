<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $order_number
 * @property string $password
 * @property integer $user_id
 * @property boolean $type
 * @property integer $goods_applies_id
 * @property integer $coupon_applies_id
 * @property boolean $delivery_method
 * @property integer $province_id
 * @property string $province_name
 * @property integer $city_id
 * @property string $city_name
 * @property integer $county_id
 * @property string $county_name
 * @property string $address
 * @property string $contact
 * @property string $phone
 * @property string $tracking_number
 * @property integer $from_shop_id
 * @property integer $to_shop_id
 * @property integer $verify_user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $status
 * @property boolean $comment_status
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereGoodsAppliesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCouponAppliesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDeliveryMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereProvinceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCountyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCountyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereTrackingNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereFromShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereToShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereVerifyUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereDeletedAt($value)
 * @property integer $goods_id
 * @property integer $boss_id
 * @property integer $integral
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereBossId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereIntegral($value)
 * @property-read \App\Goods $goods
 * @property boolean $send_method
 * @property-read \App\Goods $newGoods
 * @property-read mixed $shop
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereSendMethod($value)
 * @property-read mixed $status_text
 * @property-read mixed $order_type
 * @property-read mixed $comment_type
 * @property-read \App\User $user
 * @property-read mixed $shop_name
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereCommentStatus($value)
 * @property-read mixed $is_used
 * @property mixed username
 * @property-read mixed $thumb_url
 * @property-read mixed $user_name
 * @property string $number
 * @method static \Illuminate\Database\Query\Builder|\App\Order whereNumber($value)
 */
class Order extends Model
{
    const STATUS_WAIT = 10;
    const STATUS_SENDING = 20;
    const STATUS_FINISH = 50;

    const DELIVERY_METHOD_OWN = 10;
    const DELIVERY_METHOD_EXPRESS = 20;

    const COMMENTS_WAIT = 10;
    const COMMENTS_FINISH = 20;

    protected $fillable = [
        'goods_id',
        'goods_applies_id'
    ];

    public static function statusLabelList()
    {
        return [
            self::STATUS_WAIT => '等待兑换',
            self::STATUS_FINISH => '已完成',
            self::STATUS_SENDING => '配送中',
        ];
    }

    public function getOrderTypeAttribute()
    {
        return self::statusLabelList()[$this->status];
    }

    public static function commentStatusList()
    {
        return [
            self::COMMENTS_WAIT => '待评价',
            self::COMMENTS_FINISH => '已评价'
        ];
    }

    public function getCommentTypeAttribute()
    {
        return self::commentStatusList()[$this->comment_status];
    }

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            $model->order_number = '4' . date('YmdHis') . str_pad(round(microtime(true) - time(), 3) * 10000, 3, '0', STR_PAD_LEFT) . random_int(100, 999);
            $model->user_id = \Auth::user()->id;
            $model->status = self::STATUS_WAIT;
            $model->delivery_method = self::DELIVERY_METHOD_OWN;
            $model->comment_status = self::COMMENTS_WAIT;
            $model->goods_applies_id = $model->newGoods->goods_apply_id;
            if (!$model->newGoods->is_direct) {
                $model->from_shop_id = $model->newGoods->shop_id;
            }
            $model->password = str_random(10);
            $model->integral = $model->newGoods->price;
            $model->province_name = Region::getName($model->province_id);
            $model->city_name = Region::getName($model->city_id);
            $model->county_name = Region::getName($model->county_id);
            return IntegralBlotter::outByOrder($model->user_id, $model->integral, '兑换商品');
        });
        self::registerModelEvent('updating', function (self $model) {
            return $model->exchangeBossIntegral();
        });
    }

    protected function exchangeBossIntegral()
    {
        if ($this->status == self::STATUS_FINISH && !empty($this->boss_id)) {
            return IntegralBlotter::inByOrder($this->boss_id, $this->integral, '兑换订单', $this->id);
        }
        return true;
    }

    public function newGoods()
    {
        return $this->belongsTo('App\Goods', 'goods_id');
    }

    public function goods()
    {
        return $this->belongsTo('App\GoodsApply', 'goods_applies_id');
    }

    public function getThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->goods->thumb]);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function getShopNameAttribute()
    {
        return $this->newGoods->shop_name;
    }

    public function getShopAttribute()
    {
        return $this->goods->shop;
    }

    public function getStatusTextAttribute()
    {
        return self::statusLabelList()[$this->status];
    }

    public function exchange()
    {
        if (!empty($this->from_shop_id) && !Auth::user()->checkShopId($this->from_shop_id)) {
            return false;
        }
        $this->boss_id = Auth::user()->boss_id;
        $this->status = self::STATUS_FINISH;
        return $this->save();
    }

    public function getIsUsedAttribute()
    {
        return $this->status > self::STATUS_WAIT;
    }

}
