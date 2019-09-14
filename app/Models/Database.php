<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Database extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'name',
		
    ];
    public function tables(){
        return $this->hasMany(Table::class);
    }
    public function columns(){
        return $this->hasMany(Column::class);
    }
}
