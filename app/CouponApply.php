<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\CouponApply
 *
 * @property integer $id
 * @property integer $shop_id
 * @property string $title
 * @property boolean $type
 * @property string $images
 * @property string $reason
 * @property boolean $status
 * @property string $audited_at
 * @property integer $audit_user_id
 * @property integer $employees_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property integer $coupon_id
 * @property string $thumb
 * @property string $scope
 * @property float $condition
 * @property float $money
 * @property integer $integral
 * @property float $discount
 * @property string $begin_time
 * @property string $end_time
 * @property integer $duration
 * @property boolean $time_type
 * @property-read mixed $type_name
 * @property-read mixed $type_list
 * @property-read mixed $time_type_name
 * @property-read \App\Shop $Shop
 * @property-read mixed $address
 * @property-read mixed $title_text
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereShopId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereImages($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereAuditedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereAuditUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereEmployeesId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereCouponId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereThumb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereScope($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereCondition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereIntegral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereBeginTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereEndTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereTimeType($value)
 * @mixin \Eloquent
 * @property string $description
 * @property-read mixed $employees_name
 * @property-read \App\Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\App\CouponApply whereDescription($value)
 */
class CouponApply extends Model
{
    use SoftDeletes;

    const STATUS_WAIT = 10;
    const STATUS_REFUSAL = 20;
    const STATUS_APPROVE = 30;

    const TYPE_DIYONGQUAN = 40;
    const TYPE_ZHEKOUQUAN = 50;

    const TIME_TERM = 10;
    const TIME_LENGTH = 20;

    protected $fillable = [
        'id',
        'shop_id',
        'title',
        'type',
        'status',
        'audit_user_id',
        'employees_id',
        'coupon_id',
        'time_type',
        'thumb',
        'scope',
        'condition',
        'money',
        'integral',
        'discount',
        'begin_time',
        'end_time',
        'duration',
        'images',
        'description',
    ];

    protected $attributes = [
        'status' => self::STATUS_WAIT,
        'type' => self::TYPE_DIYONGQUAN,
        'time_type' => self::TIME_TERM,
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public static function typeList()
    {
        return [
            self::TYPE_DIYONGQUAN => '抵用券',
            self::TYPE_ZHEKOUQUAN => '折扣券',
        ];
    }

    public function getTypeListAttribute()
    {
        return self::typeList()[$this->type];
    }


    public function getTimeTypeNameAttribute()
    {
        return self::timeLimit()[$this->time_type];
    }


    public static function timeLimit()
    {
        return [
            self::TIME_TERM => '固定时间',
            self::TIME_LENGTH => '固定时长',
        ];
    }


    public static function boot()
    {

        parent::boot();
        self::registerModelEvent('creating', function (self $model) {
            if (empty($model->coupon_id)) {
                $model->coupon_id = null;
            }
        });
        self::registerModelEvent('created', function (self $model) {
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackDirectCoupon();
            }
        });
        self::registerModelEvent('saving', function (self $model) {
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
        self::registerModelEvent('updating', function (self $model) {
            if (in_array($model->status, [self::STATUS_APPROVE, self::STATUS_REFUSAL]) && $model->isDirty('status')) {
                $model->audit_user_id = \Auth::guard('admin')->user()['id'];
                $model->audited_at = Carbon::now();
            }
            if ($model->status === self::STATUS_APPROVE && $model->isDirty('status')) {
                return $model->writeBackCoupon();
            }
            return true;
        });

    }

    protected function writeBackCoupon()
    {
        return Coupon::findOrNew($this->coupon_id)->setAttribute('coupon_applies_id', $this->id)
            ->setAttribute('employees_id', $this->employees_id)
            ->setAttribute('shop_id', $this->shop_id)
            ->save();
    }

    protected function writeBackDirectCoupon()
    {
        return Coupon::findOrNew($this->coupon_id)->setAttribute('coupon_applies_id', $this->id)->save();
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

    public function Shop()
    {
        return $this->belongsTo('\App\Shop', 'shop_id');
    }

    public function getAddressAttribute()
    {
        return $this->Shop->county_name;
    }

    public function getTitleTextAttribute()
    {
        if ($this->type == 40) {
            return '满' . $this->condition . '减' . $this->money . '元';
        } else {
            return '满' . $this->condition . '享' . $this->discount . '折';
        }
    }

    public function getEmployeesNameAttribute(){
        return $this->employee->name;
    }
    public function employee(){
        return $this->belongsTo('App\Employee','employees_id');
    }
}
