<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Table extends Model implements Sortable
{
    use SoftDeletes;
    use SortableTrait;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'name',
		
    ];
    public function database(){
        return $this->belongsTo(Database::class);
    }
    public function columns(){
        return $this->hasMany(Column::class);
    }
    public function create_auto_increament(){
        $column = new Column();
        $column->name = 'id';
        $column->type = 'increments';
        $column->nullable = false;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
    }
    public function create_user_tracking($foreign_table_id, $foreign_column_id, $on_delete){
        $column = new Column();
        $column->name = 'created_by';
        $column->type = 'foreign';
        $column->foreign_table_id = $foreign_table_id;
        $column->foreign_column_id = $foreign_column_id;
        $column->on_delete = $on_delete;
        $column->nullable = true;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
        $column = new Column();
        $column->name = 'updated_by';
        $column->type = 'foreign';
        $column->foreign_table_id = $foreign_table_id;
        $column->foreign_column_id = $foreign_column_id;
        $column->on_delete = $on_delete;
        $column->nullable = true;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
    }
    public function create_softdelete(){
        $column = new Column();
        $column->name = 'softDeletes()';
        $column->type = 'softDeletes';
        $column->nullable = true;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
    }
    public function create_timestamp(){
        $column = new Column();
        $column->name = 'timestamps()';
        $column->type = 'timestamps';
        $column->nullable = false;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
    }
}
