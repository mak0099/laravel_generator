<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use App\Inflector;
use Chumper\Zipper\Zipper;

class Table extends Model implements Sortable
{
    use SoftDeletes;
    use SortableTrait;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',

    ];
    public function database()
    {
        return $this->belongsTo(Database::class);
    }
    public function columns()
    {
        return $this->hasMany(Column::class)->ordered();
    }
    public function create_auto_increament()
    {
        $column = new Column();
        $column->name = 'id';
        $column->type = 'increments';
        $column->nullable = false;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
    }
    public function create_user_tracking($foreign_table_id, $foreign_column_id, $on_delete)
    {
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
    public function create_softdelete()
    {
        $column = new Column();
        $column->name = 'softDeletes()';
        $column->type = 'softDeletes';
        $column->nullable = true;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
    }
    public function create_timestamp()
    {
        $column = new Column();
        $column->name = 'timestamps()';
        $column->type = 'timestamps';
        $column->nullable = false;
        $column->table()->associate($this);
        $column->database()->associate($this->database);
        $column->save();
    }
    public function get_migration_content()
    {
        $stub_location = 'stub/migration.stub';
        $replace = [
            '>>table_class_name<<' => $this->get_table_class_name(),
            '>>table_name<<' => $this->name,
            '>>migration_columns<<' => $this->get_migration_columns(),
        ];
        $file_content = $this->replace_stub($stub_location, $replace);
        return $file_content;
    }
    private function get_migration_columns()
    {
        $migration_columns = "";
        foreach ($this->columns as $column) {
            if ($column->type == 'foreign') {
                if ($column->foreign_column->type == 'bigIncrements' || $column->foreign_column->type == 'bigInteger') {
                    $column_type = 'bigInteger';
                } else {
                    $column_type = 'integer';
                }
                $migration_columns .= "\t\t\t\$table->" . $column_type . "('" . $column->name . "')->unsigned()";
                $column->nullable ? $migration_columns .= '->nullable()' : null;
                $migration_columns .= ";\n";
                $migration_columns .= "\t\t\t\$table->foreign('" . $column->name . "')->references('" . $column->foreign_column->name . "')->on('" . $column->foreign_table->name . "')->onDelete('" . $column->on_delete . "');\n";
            } else if($column->type == 'enum' || $column->type == 'set'){
                $migration_columns .= "\t\t\t\$table->" . $column->type . "('" . $column->name . "', [";
                $set_items = explode(',', $column->length);
                foreach($set_items as $item){
                    $migration_columns .= "'$item',";
                }
                $migration_columns .= "])";
                $migration_columns .= ";\n";
            }else if($column->type == 'timestamps'){
                $migration_columns .= "\t\t\t\$table->timestamps();\n";
            }else if($column->type == 'softDeletes'){
                $migration_columns .= "\t\t\t\$table->softDeletes();\n";
            } else {
                $migration_columns .= "\t\t\t\$table->" . $column->type . "('" . $column->name . "')";
                $migration_columns .= ";\n";
            }
        }
        return $migration_columns;
    }
    public function get_table_file_name()
    {
        return date('Y_m_d_His') . '_create_' . $this->name . '_table.php';
    }
    public function get_table_class_name()
    {
        return  'Create' . Inflector::text($this->name)->camel_case(true)->pluralize()->get() . 'Table';
    }
    public function replace_stub($stub_location, $replace)
    {
        $file = fopen($stub_location, 'r') or die("Unable to open file!");
        $read_content = fread($file, filesize($stub_location));
        $file_content = str_replace(array_keys($replace), array_values($replace), $read_content);
        return $file_content;
    }
    public function add_to_export($destination_path = 'generated_files/migration_tables.zip')
    {
        $file_name = $this->get_table_file_name() . '.php';
        $zipper = new Zipper();
        $zipper->zip($destination_path)
            ->folder('database/migrations')
            ->addString($file_name, $this->get_migration_content());
    }
}
