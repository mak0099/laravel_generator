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
    public function tables()
    {
        return $this->hasMany(Table::class)->ordered();
    }
    public function columns()
    {
        return $this->hasMany(Column::class)->ordered();
    }
    public function getDownload($file_path, $file_name = 'migrations')
    {
        $headers = [
            'Content-Type: application/octet-stream',
            'Content-Length: '. filesize($file_path)
        ];
        return response()->download($file_path, $file_name . '.zip', $headers)->deleteFileAfterSend(true);
    }
}
