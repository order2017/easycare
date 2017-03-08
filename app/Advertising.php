<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Advertising
 *
 * @property integer $id
 * @property integer $type
 * @property string $image
 * @property integer $order
 * @property boolean $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $image_url
 * @property string $link
 * @method static \Illuminate\Database\Query\Builder|\App\Advertising whereLink($value)
 */
class Advertising extends Model
{
    const STATUS_NORMAL = 10;
    const STATUS_LEAVE = 20;

    const TYPE_INDEX_BANNER = 10;
    const TYPE_INDEX_AD1 = 20;

    protected $fillable = [
        'image',
        'order',
        'type',
        'link',
    ];
    
    protected $attributes = [
        'status' => self::STATUS_NORMAL
    ];

    public static function typeLabelList()
    {
        return [
            self::TYPE_INDEX_BANNER => '首页Banner图',
            self::TYPE_INDEX_AD1 => '首页广告位1'
        ];
    }

    public function getImageUrlAttribute()
    {
        return route('widget.images', ['name' => $this->image]);
    }
}
