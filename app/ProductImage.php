<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['product_id','image'];
}
