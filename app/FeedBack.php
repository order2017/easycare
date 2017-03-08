<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FeedBack
 *
 * @property integer $id
 * @property integer $user_id
 * @property boolean $type
 * @property string $content
 * @property boolean $mobile
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FeedBack whereDeletedAt($value)
 * @mixin \Eloquent
 */
class FeedBack extends Model
{
    const TYPE_ONE =10;
    const TYPE_TWO =20;
    const TYPE_THREE =30;
    const TYPE_FOUR =40;


    protected $fillable = [
        'type',
        'content',
        'user_id',
        'mobile'
    ];

    public static function typeList()
    {
        return [
            self::TYPE_ONE=>'配送服务',
            self::TYPE_TWO=>'产品质量',
            self::TYPE_THREE=>'优惠时间',
            self::TYPE_FOUR=>'服务质量'
        ];
    }
    
    
    
}
