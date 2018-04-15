<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'product_name',
		'product_type',
		
    ];
}

