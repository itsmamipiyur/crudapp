<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    protected $table = 'branches';
    protected $fillable = ['branch_name', 'branch_desc'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
