<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ProductActivity
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $title
 * @property boolean $type
 * @property integer $total
 * @property boolean $send_method
 * @property string $begin_time
 * @property string $end_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereSendMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereBeginTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereEndTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereDeletedAt($value)
 * @property integer $has_join_num
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereHasJoinNum($value)
 * @property boolean $send_type
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereSendType($value)
 * @property-read mixed $active_rule
 * @property string $rules
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereRules($value)
 * @property \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read mixed $winner_number
 * @property-read mixed $type_name
 * @property-read mixed $send_method_name
 * @property-read mixed $rules_max
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereProducts($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $productModels
 * @property boolean $status
 * @property-read mixed $multiple
 * @property-read mixed $status_text
 * @method static \Illuminate\Database\Query\Builder|\App\ProductActivity whereStatus($value)
 * @property-read mixed $is_down
 * @property-read mixed $min
 * @property-read mixed $max
 * @property-read mixed $is_alone
 * @property-read mixed $rule_id
 */
class ProductActivity extends Model
{
    use SoftDeletes;

    const TYPE_MEMBER_INTEGRAL = 10;
    const TYPE_MEMBER_RED_PACKETS = 20;
    const TYPE_SALE_COMMISSION = 30;

    const SEND_METHOD_ALONE = 10;
    const SEND_METHOD_MERGE = 20;

    const STATUS_DOWN = 10;
    const STATUS_UP = 20;


    protected $casts = [
        'rules' => 'array',
        'products' => 'array',
    ];

    protected $fillable = [
        'title',
        'send_method',
        'begin_time',
        'end_time',
        'rules',
        'products'
    ];

    public function getRuleIdAttribute()
    {
        return 1;
    }

    protected static function boot()
    {
        parent::boot();
        self::registerModelEvent('saved', function (self $model) {
            $model->bindProduct();
        });
    }

    protected $attributes = [
        'status' => self::STATUS_DOWN
    ];

    public function productModels()
    {
        return $this->belongsToMany('App\Product', 'product_in_activities');
    }

    protected function bindProduct()
    {
        $this->productModels()->sync($this->products);
    }

    public static function statusLabelList()
    {
        return [
            self::STATUS_DOWN => '已下架',
            self::STATUS_UP => '正在进行中',
        ];
    }

    public static function sendMethodLabelList()
    {
        return [
            self::SEND_METHOD_MERGE => '合并发放',
            self::SEND_METHOD_ALONE => '单独发放',
        ];
    }

    public function getIsAloneAttribute()
    {
        return $this->send_method === self::SEND_METHOD_ALONE;
    }

    public static function getProducts($type, $beginTime, $endTime, $else = null)
    {
        $query = self::whereType($type);
        if ($else !== null) {
            $query->whereNotIn('id', [$else]);
        }
        $list = $query->get();
        $elseProduct = [];
        foreach ($list as $item) {
            if ($item['begin_time'] <= $beginTime && $beginTime < $item['end_time']) {
                $elseProduct = array_merge($elseProduct, $item['products']);
            }
            if ($item['begin_time'] < $endTime && $endTime <= $item['end_time']) {
                $elseProduct = array_merge($elseProduct, $item['products']);
            }
        }
        return Product::whereNotIn('id', $elseProduct)->orderByRaw('model*1 asc')->get();
    }

    public function getTotalAttribute()
    {
        return collect($this->rules)->sum('winning_rate');
    }

    public function getWinnerNumberAttribute()
    {
        return collect($this->rules)->sum('has');
    }

    public function getSendMethodNameAttribute()
    {
        return self::sendMethodLabelList()[$this->send_method];
    }

    public function getMultipleAttribute()
    {
        return $this->type == self::TYPE_MEMBER_INTEGRAL ? $this->rules['multiple'] : null;
    }

    public function getStatusTextAttribute()
    {
        return self::statusLabelList()[$this->status];
    }

    public function getMinAttribute()
    {
        return $this->type == self::TYPE_MEMBER_RED_PACKETS ? $this->rules['min'] : 0;
    }

    public function getMaxAttribute()
    {
        return $this->type == self::TYPE_MEMBER_RED_PACKETS ? $this->rules['max'] : 0;
    }

    public function getIsDownAttribute()
    {
        return $this->status == self::STATUS_DOWN;
    }

    public function getRulesMaxAttribute()
    {
        $max = 0;
        if (is_array($this->rules['list'])) {
            foreach ($this->rules['list'] as $k => $rule) {
                if ($k > $max) {
                    $max = $k;
                }
            }
        }
        return $max + 1;
    }

    public function rewards(Product $product)
    {
        switch ($this->type) {
            case self::TYPE_MEMBER_INTEGRAL:
                return $this->calculateIntegral($product);
                break;
            case self::TYPE_MEMBER_RED_PACKETS:
                return $this->calculateRedPackets();
                break;
            case self::TYPE_SALE_COMMISSION:
                return $this->calculateCommission($product);
                break;
        }
    }

    protected function calculateIntegral(Product $product)
    {
        return round($product->integral * $this->multiple / 100) - $product->integral;
    }

    protected function calculateRedPackets()
    {
        return rand($this->min, $this->max);
    }

    protected function calculateCommission(Product $product)
    {
        $randTotal = $this->total - $this->has_join_num;
        $begin = 0;
        $rand = random_int($begin, $randTotal);
        $commission = $product->commission;
        foreach ($this->rules['list'] as $rule) {
            $less = $rule['winning_rate'] - $rule['has'];
            if ($less > 0 && $rand > $begin && $rand < $begin + $less) {
                $commission = round($commission * $rule['rewards'] / 100, 2);
            }
        }
        return $commission;
    }

}
