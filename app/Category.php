<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name','parent_id'];
    
    public function parent() {
        return $this->hasOne('App\Category', 'id', 'parent_id');
    }
    
    public function parents()
    {
        return $this->parent()->with('parents');
    }
     public function subCategory()
   {
      return $this->hasMany(Category::class, 'parent_id')->with('subCategory');
    }
    
}
