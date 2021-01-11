<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name','uuid','category_id','description','is_active'];
    
    public function category() {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }
    
     public function images() {
        return $this->hasMany('App\ProductImage','product_id','id');
    }
}
