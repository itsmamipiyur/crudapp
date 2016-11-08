<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = ['product_name', 'product_desc'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category')->withTrashed();
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand')->withTrashed();
    }
}
