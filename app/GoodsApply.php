<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\GoodsApply
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $shop_id
 * @property string $name
 * @property float $price
 * @property float $original_price
 * @property float $shipping
 * @property integer $inventory
 * @property string $intro
 * @property string $reason
 * @property boolean $status
 * @property string $audited_at
 * @property integer $audit_user_id
 * @property integer $employees_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereOriginalPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereShipping($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereInventory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereIntro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereAuditedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereDeletedAt($value)
 * @property string $images
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereImages($value)
 * @property integer $goods_id
 * @property \App\Shop $shop
 * @property string $shop_name
 * @property text thumb
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereThumb($value)
 * @property string $thumb
 * @property-read mixed $thumb_url
 * @property string $description
 * @property-read mixed $employees_name
 * @property-read \App\Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\App\GoodsApply whereDescription($value)
 */
class GoodsApply extends Model
{
    use SoftDeletes;

    const STATUS_WAIT = 10;
    const STATUS_REFUSAL = 20;
    const STATUS_APPROVE = 30;

    protected $fillable = [
        'id',
        'shop_id',
        'name',
        'price',
        'original_price',
        'audit_user_id',
        'employees_id',
        'goods_id',
        'intro',
        'inventory',
        'thumb',
        'images',
        'status',
        'reason',
        'description'
    ];

    protected $attributes = [
        'status' => self::STATUS_WAIT,
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public static function boot()
    {
        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            if (empty($model->goods_id)) {
                $model->goods_id = null;
            }
            if (!\Storage::exists($model->thumb)) {
                \Storage::put($model->thumb, app('wechat')->material_temporary->getStream($model->thumb));
            }
            if (!empty($model->images) && is_array($model->images)) {
                foreach ($model->images as $image) {
                    if (!empty($image) && !\Storage::exists($image)) {
                        \Storage::put($image, app('wechat')->material_temporary->getStream($image));
                    }
                }
            }

        });
        self::registerModelEvent('created', function (self $model) {
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackDirectGoods();
            }

        });
        self::registerModelEvent('updating', function (self $model) {
            if (in_array($model->status, [self::STATUS_APPROVE, self::STATUS_REFUSAL]) && $model->isDirty('status')) {
                $model->audit_user_id = \Auth::guard('admin')->user()['id'];
                $model->audited_at = Carbon::now();
            }
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackGoods();
            }
            return true;
        });
    }

    public function getThumbUrlAttribute()
    {
        return route('widget.images', ['name' => $this->thumb]);
    }

    protected function writeBackGoods()
    {
        return Goods::findOrNew($this->goods_id)->setAttribute('goods_apply_id', $this->id)
            ->setAttribute('employees_id', $this->employees_id)
            ->setAttribute('shop_id', $this->shop_id)
            ->save();

    }

    protected function writeBackDirectGoods()
    {
        return Goods::findOrNew($this->goods_id)->setAttribute('goods_apply_id', $this->id)->save();
    }


    public static function checkHasApply($id)
    {
        return self::whereStatus(self::STATUS_WAIT)->whereId($id)->exists();
    }

    public function approve()
    {
        return $this->setAttribute('status', self::STATUS_APPROVE)->saveOrFail();
    }

    public function refusal($reason)
    {
        return $this->setAttribute('status', self::STATUS_REFUSAL)->setAttribute('reason', $reason)->save();
    }

    public function getShopNameAttribute(){
        return $this->shop->name;
    }

    public function shop()
    {
        return $this->belongsTo('App\Shop', 'shop_id');
    }

    public function getEmployeesNameAttribute(){
        return $this->employee->name;
    }
    public function employee(){
        return $this->belongsTo('App\Employee','employees_id');
    }


}
