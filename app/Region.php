<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Region
 *
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property integer $parent
 * @property string $code
 * @property string $phone
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereParent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Region wherePhone($value)
 * @mixin \Eloquent
 */
class Region extends Model
{
    protected $table = 'region';

    protected $connection = 'region';

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */

    public static function provinceList()
    {
        return self::whereLevel(1)->get();
    }

    public static function cityList($province_id = null)
    {
        $province_id = $province_id === null ? self::provinceList()->first()->id : $province_id;
        return self::whereParent($province_id)->whereLevel(2)->get();
    }

    public static function countyList($city_id = null)
    {
        $city_id = $city_id === null ? self::cityList()->first()->id : $city_id;
        return self::whereLevel(3)->whereParent($city_id)->get();
    }

    public static function getName($id)
    {
        $model = self::find($id);
        return empty($model) ? '' : $model->name;
    }

}
