<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Setting
 *
 * @mixin \Eloquent
 * @property string $key
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Setting whereDeletedAt($value)
 */
class Setting extends Model
{
    const KEY_WECHAT_BARCODE = 'wechat_barcode';
    const KEY_INTEGRAL_PROPORTION = 'integral_proportion';

    protected $primaryKey = 'key';

    protected $fillable = [
        'key'
    ];

    public static function keyList()
    {
        return [
            self::KEY_WECHAT_BARCODE,
            self::KEY_INTEGRAL_PROPORTION,
        ];
    }

    public static function setValue($key, $value)
    {
        if (!$m = self::where(['key' => $key])->first()) {
            $m = (new self())->setAttribute('key', $key);
        }
        return $m->setAttribute('name', $value)->save();
    }

    public static function getValue($key, $default = null)
    {
        if ($value = self::whereKey($key)->first()) {
            return $value['name'];
        }
        return $default;
    }

    public static function integralProportion()
    {
        return self::getValue(self::KEY_INTEGRAL_PROPORTION, 0);
    }

    public static function wechatBarcode()
    {
        return self::getValue(self::KEY_WECHAT_BARCODE);
    }
}
