<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $table = 'brands';
    protected $fillable = ['brand_name', 'brand_desc'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
