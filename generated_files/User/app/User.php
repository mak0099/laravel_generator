<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected \$dates = ['deleted_at'];
    
    protected \$fillable = [
        'username',
		'email',
		'password',
		
    ];
}
