<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Favorite
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property boolean $type
 * @property integer $goods_id
 * @property integer $shop_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereUpdatedAt($value)
 * @property-read \App\Goods $goods
 * @property-read \App\Shop $shop
 * @property-read mixed $type_name
 * @property-read mixed $goods_name
 * @property-read mixed $integral
 * @property-read mixed $shop_name
 * @property-read mixed $intro
 * @property-read mixed $goods_intro
 * @property-read mixed $shop_address
 * @property-read \App\User $user
 * @property-read \App\Coupon $coupon
 * @property integer $coupon_id
 * @property-read mixed $goods_thumb_url
 * @property-read mixed $shop_thumb_url
 * @property-read mixed $title
 * @property-read mixed $coupon_integral
 * @property-read mixed $coupon_thumb_url
 * @property-read mixed $count_favor
 * @method static \Illuminate\Database\Query\Builder|\App\Favorite whereCouponId($value)
 */
class Favorite extends Model
{
    const TYPE_GOODS = 10;
    const TYPE_SHOP = 20;
    const TYPE_COUPON = 30;

    protected $fillable = [
        'user_id',
        'type',
        'goods_id',
        'shop_id',
        'coupon_id'
    ];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
    }

    public static function typeList()
    {
        return [
            self::TYPE_GOODS => '商品',
            self::TYPE_SHOP => '店铺',
            self::TYPE_COUPON => '优惠券'
        ];
    }

    public function getTypeNameAttribute()
    {
        return self::typeList()[$this->type];
    }

    public function goods()
    {
        return $this->belongsTo('App\Goods');
    }

    public function getGoodsNameAttribute()
    {
        return $this->goods->name;
    }

    public function getGoodsIntroAttribute()
    {
        return $this->goods->intro;
    }

    public function getIntegralAttribute()
    {
        return $this->goods->price;
    }


    public function getGoodsThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->goods->thumb]);
    }


    public function shop()
    {
        return $this->belongsTo('App\Shop');
    }

    public function getShopNameAttribute()
    {
        return $this->shop->name;
    }

    public function getIntroAttribute()
    {
        return $this->shop->intro;
    }

    public function getShopAddressAttribute()
    {
        return $this->shop->address;
    }


    public function getShopThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->shop->thumb]);
    }


    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }

    public function getTitleAttribute()
    {
        return $this->coupon->title;
    }
    
    public function getCouponIntegralAttribute()
    {
        return $this->coupon->integral;
    }

    public function getCouponThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->coupon->thumb]);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    

    public function getCountFavorAttribute()
    {
        if ($this->type == self::TYPE_GOODS) {
            return self::whereUserId(Auth::user()->id)->whereType(Favorite::TYPE_GOODS)->count();
        }
        if ($this->type == self::TYPE_SHOP) {
            return self::whereUserId(Auth::user()->id)->whereType(Favorite::TYPE_SHOP)->count();
        }
        if ($this->type == self::TYPE_COUPON) {
            return self::whereUserId(Auth::user()->id)->whereType(Favorite::TYPE_COUPON)->count();
        }
    }
}
    