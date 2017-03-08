<?php
/**
 * Created by PhpStorm.
 * User: dggug
 * Date: 2016/6/23
 * Time: 9:30
 */

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Product
 *
 * @property integer $id
 * @property string $model
 * @property string $name
 * @property integer $integral
 * @property float $commission
 * @property integer $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereModel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereIntegral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCommission($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProductActivity[] $activities
 * @property-read mixed $effective_activities
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'model',
        'name',
        'integral',
        'commission',
    ];

    public function getSaleRewards()
    {
        return [0, $this->commission];
    }

    public function getIntegralRewards()
    {
        return $this->integral;
    }

    public function getCommissionRewards()
    {
        return $this->commission;
    }

    public function activities()
    {
        return $this->belongsToMany('App\ProductActivity', 'product_in_activities');
    }

    /**
     * @return ProductActivity
     */

    public function getIntegralActivity()
    {
        return $this->activities()
            ->where('begin_time', '<=', Carbon::now())
            ->where('end_time', '>=', Carbon::now())
            ->where('type', ProductActivity::TYPE_MEMBER_INTEGRAL)
            ->where('status', ProductActivity::STATUS_UP)->first();
    }

    /**
     * @return ProductActivity
     */

    public function getRedPacketActivity()
    {
        return $this->activities()
            ->where('begin_time', '<=', Carbon::now())
            ->where('end_time', '>=', Carbon::now())
            ->where('type', ProductActivity::TYPE_MEMBER_RED_PACKETS)
            ->where('status', ProductActivity::STATUS_UP)->first();
    }

    /**
     * @return ProductActivity
     */

    public function getSaleActivity()
    {
        return $this->activities()
            ->where('begin_time', '<=', Carbon::now())
            ->where('end_time', '>=', Carbon::now())
            ->where('type', ProductActivity::TYPE_SALE_COMMISSION)
            ->where('status', ProductActivity::STATUS_UP)
            ->first();
    }
}