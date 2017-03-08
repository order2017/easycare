<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ProductInActivity
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $product_id
 * @property integer $product_activity_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ProductInActivity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductInActivity whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductInActivity whereProductActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductInActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductInActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProductInActivity whereDeletedAt($value)
 */
class ProductInActivity extends Model
{
    //
}
