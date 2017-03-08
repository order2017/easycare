<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Goods
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $shop_id
 * @property integer $employees_id
 * @property integer $goods_apply_id
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property \App\GoodsApply $apply
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereGoodsApplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereDeletedAt($value)
 * @property string $name
 * @property-read mixed $price
 * @property-read mixed $original_price
 * @property-read mixed $intro
 * @property-read mixed $inventory
 * @property-read mixed $shop_name
 * @property-read mixed $shop
 * @property-read mixed $delivery_method
 * @property-read mixed $thumb_url
 * @property-read mixed $images
 * @property-read mixed $comment_number
 * @property-read mixed $thumb
 * @property-read mixed $is_direct
 * @property integer $order
 * @property-read mixed $description
 * @method static \Illuminate\Database\Query\Builder|\App\Goods whereOrder($value)
 */
class Goods extends Model
{
    const STATUS_NORMAL = 10;
    const STATUS_LEAVE = 20;


    protected $attributes = [
        'status' => self::STATUS_NORMAL
    ];

    protected $fillable = [
        'id',
        'goods_apply_id',
        'shop_id',
        'employees_id'
    ];


    public function apply()
    {
        return $this->belongsTo('App\GoodsApply', 'goods_apply_id');
    }

    public function getIsDirectAttribute()
    {
        return empty($this->shop_id);
    }

    public function getNameAttribute()
    {
        return $this->apply->name;
    }

    public function getPriceAttribute()
    {
        return $this->apply->price;
    }

    public function getOriginalPriceAttribute()
    {
        return $this->apply->original_price;
    }

    public function getIntroAttribute()
    {
        return $this->apply->intro;
    }

    public function getInventoryAttribute()
    {
        return $this->apply->inventory;
    }

    public function getShopNameAttribute()
    {
        return empty($this->shop) ? '伊斯卡尔直营店' : $this->shop->name;
    }

    public function getShopIdAttribute()
    {
        return empty($this->shop) ? 0 : $this->shop->id;
    }

    public function getShopAttribute()
    {
        return $this->apply->shop;
    }

    public function getDeliveryMethodAttribute()
    {
        return empty($this->shop_id) ? '快递' : '自提';
    }

    public function getThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->apply->thumb]);
    }

    public function getImagesAttribute()
    {
        if (!empty($this->apply->images)) {
            $return = [];
            foreach ($this->apply->images as $image) {
                !empty($image) && $return[] = route('widget.images', ['name' => $image]);
            }
            return $return;
        }
        return [];
    }

    public function getCommentNumberAttribute()
    {
        return 0;
    }

    public function getThumbAttribute()
    {
        return $this->apply->thumb;
    }

    public function getDescriptionAttribute()
    {
        return $this->apply->description;
    }


}
