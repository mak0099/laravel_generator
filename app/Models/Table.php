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
    public function get_model_name()
    {
        return Inflector::text($this->name)->camel_case(true)->singularize()->get();
    }
    public function get_controller_name()
    {
        return Inflector::text($this->name)->camel_case(true)->singularize()->get() . 'Controller';
    }
    public function get_variable_name()
    {
        return Inflector::text($this->name)->snake_case()->singularize()->get();
    }
    public function get_resource_name()
    {
        return Inflector::text($this->name)->camel_case(true)->singularize()->get() . 'Resource';
    }
    public function get_route_name()
    {
        return Inflector::text($this->name)->slug()->pluralize()->get();
    }
    public function get_table_name()
    {
        return Inflector::text($this->name)->snake_case()->pluralize()->get();
    }
    public function get_table_file_name()
    {
        return date('Y_m_d_His', strtotime($this->created_at)) . '_create_' . $this->get_table_name() . '_table.php';
    }
    public function get_table_class_name()
    {
        return  'Create' . Inflector::text($this->name)->camel_case(true)->pluralize()->get() . 'Table';
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
            '>>table_name<<' => $this->get_table_name(),
            '>>migration_columns<<' => $this->get_migration_columns(),
        ];
        $file_content = $this->replace_stub($stub_location, $replace);
        return $file_content;
    }
    public function get_model_content()
    {
        $stub_location = 'stub/model.stub';
        $replace = [
            '>>MODEL_NAME<<' => $this->get_model_name(),
            '>>FILLABLE_FIELDS<<' => $this->fillable_fields(),
            '>>MODEL_RELATIONS<<' => $this->model_relation_functions(),
        ];
        $file_content = $this->replace_stub($stub_location, $replace);
        return $file_content;
    }
    public function model_relation_functions()
    {
        $foreign_belongs_columns = $this->columns()->where('type', 'foreign')->get();
        $fn = "";
        foreach ($foreign_belongs_columns as $column) {
            $fn .= "\tpublic function ";
            $foreign_table = $column->foreign_table;
            if (trim($column->name, '_id') == Inflector::text($foreign_table->get_table_name())->singularize()->get()) {
                $fn .= trim($column->name, '_id') . "()\n\t{\n";
                $fn .= "\t\treturn \$this->belongsTo(" . $foreign_table->get_model_name() . "::class);\n\t}\n";
            } else {
                $fn .= $column->name . "_" . $foreign_table->get_variable_name() . "()\n\t{\n";
                $fn .= "\t\treturn \$this->belongsTo(" . $foreign_table->get_model_name() . "::class, '" . $column->name . "');\n\t}\n";
            }
        }
        $foreign_has_columns = $this->database->columns()->where('foreign_table_id', $this->id)->get();
        foreach ($foreign_has_columns as $column) {
            $fn .= "\tpublic function ";
            $fn .= $column->table()->first()->get_table_name() . "()\n\t{\n";
            $fn .= "\t\treturn \$this->hasMany(" . $column->table()->first()->get_model_name() . "::class);\n\t}\n";
        }
        return $fn;
    }
    public function get_controller_content()
    {
        $stub_location = 'stub/api/controller.stub';
        $replace = [
            '>>MODEL_NAME<<' => $this->get_model_name(),
            '>>VARIABLE_NAME<<' => $this->get_variable_name(),
            '>>STORE_VALIDATIONS<<' => $this->get_store_validations(),
            '>>UPDATE_VALIDATIONS<<' => $this->get_update_validations()
        ];
        $file_content = $this->replace_stub($stub_location, $replace);
        return $file_content;
    }
    public function get_store_validations()
    {
        $validation_items = "";
        foreach ($this->columns as $column) {
            if ($column->type != 'increments' && $column->type != 'timestamps' && $column->type != 'softDeletes') {
                $validation_rules = [];
                $column->nullable ? null : $validation_rules[] = 'required';
                $column->type == 'date' ? $validation_rules[] = 'date' : null;
                $column->type == 'integer' ? $validation_rules[] = 'integer' : null;
                $column->type == 'double' ? $validation_rules[] = 'numeric' : null;
                $column->unsigned && $column->type != 'foreign' ? $validation_rules[] = 'min:0' : null;
                $column->unique ? $validation_rules[] = 'unique:' . $this->get_table_name() : null;
                if ($validation_rules) {
                    $validation_items .= "\n\t\t\t\"" . $column->name . "\"=>\"" . implode('|', $validation_rules) . "\",";
                }
            }
        }
        $validations = "";
        if ($validation_items) {
            $validations .= "\n\t\t\$validator = Validator::make(\$request->all(), [";
            $validations .= $validation_items;
            $validations .= "\n\t\t]);";
            $validations .= "\n\t\tif(\$validator->fails()){";
            $validations .= "\n\t\t\treturn response()->json(\$validator->errors(), 202);";
            $validations .= "\n\t\t}";
        }
        return $validations;
    }
    public function get_update_validations()
    {
        $validation_items = "";
        foreach ($this->columns as $column) {
            if ($column->type != 'increments' && $column->type != 'timestamps' && $column->type != 'softDeletes') {
                $validation_rules = [];
                $column->nullable ? null : $validation_rules[] = 'required';
                $column->type == 'date' ? $validation_rules[] = 'date' : null;
                $column->type == 'integer' ? $validation_rules[] = 'integer' : null;
                $column->type == 'double' ? $validation_rules[] = 'numeric' : null;
                $column->unsigned && $column->type != 'foreign' ? $validation_rules[] = 'min:0' : null;
                $column->unique ? $validation_rules[] = "unique:{$this->get_table_name()},{$column->name},{\${$this->get_variable_name()}->id}" : null;
                if ($validation_rules) {
                    $validation_items .= "\n\t\t\t\"" . $column->name . "\"=>\"" . implode('|', $validation_rules) . "\",";
                }
            }
        }
        $validations = "";
        if ($validation_items) {
            $validations .= "\n\t\t\$validator = Validator::make(\$request->all(), [";
            $validations .= $validation_items;
            $validations .= "\n\t\t]);";
            $validations .= "\n\t\tif(\$validator->fails()){";
            $validations .= "\n\t\t\treturn response()->json(\$validator->errors(), 202);";
            $validations .= "\n\t\t}";
        }
        return $validations;
    }
    public function fillable_fields()
    {
        $fillable_fields = "";
        foreach ($this->columns as $column) {
            if ($column->name == 'id') continue;
            if ($column->name == 'softDeletes()') continue;
            if ($column->name == 'timestamps()') continue;
            $fillable_fields .= "'" . $column->name . "',\n\t\t";
        }
        return $fillable_fields;
    }
    public function get_resource_content()
    {
        $stub_location = 'stub/api/resource.stub';
        $replace = [
            '>>MODEL_NAME<<' => $this->get_model_name(),
            '>>RESOURCE_FIELDS<<' => $this->resource_fileds(),
        ];
        $file_content = $this->replace_stub($stub_location, $replace);
        return $file_content;
    }
    public function resource_fileds()
    {
        $resource_fields = "";
        foreach ($this->columns as $column) {
            if ($column->name == 'softDeletes()') continue;
            if ($column->name == 'timestamps()') {
                $resource_fields .= "\t\t\t'created_at'=>\$this->created_at,";
                $resource_fields .= "\n\t\t\t'updated_at'=>\$this->updated_at,";
                continue;
            }
            $resource_fields .= "\n\t\t\t'" . $column->name . "'=>\$this->" . $column->name;
            $resource_fields .= ",\n";
        }
        return $resource_fields;
    }
    public function get_api_route_content()
    {
        return "Route::apiResource('" . $this->get_route_name() . "', '" . $this->get_controller_name() . "');";
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
            } else if ($column->type == 'enum' || $column->type == 'set') {
                $migration_columns .= "\t\t\t\$table->" . $column->type . "('" . $column->name . "', [";
                $set_items = explode(',', $column->length);
                foreach ($set_items as $item) {
                    $migration_columns .= "'$item',";
                }
                $migration_columns .= "])";
                $migration_columns .= ";\n";
            } else if ($column->type == 'timestamps') {
                $migration_columns .= "\t\t\t\$table->timestamps();\n";
            } else if ($column->type == 'softDeletes') {
                $migration_columns .= "\t\t\t\$table->softDeletes();\n";
            } else {
                $migration_columns .= "\t\t\t\$table->" . $column->type . "('" . $column->name . "')";
                $column->unsigned ? $migration_columns .= '->unsigned()' : null;
                $column->nullable ? $migration_columns .= '->nullable()' : null;
                $migration_columns .= ";\n";
            }
        }
        return $migration_columns;
    }
    public function replace_stub($stub_location, $replace)
    {
        $file = fopen($stub_location, 'r') or die("Unable to open file!");
        $read_content = fread($file, filesize($stub_location));
        $file_content = str_replace(array_keys($replace), array_values($replace), $read_content);
        return $file_content;
    }
    public function save_migration_to_zip($destination_path = 'generated_files/migration_tables.zip')
    {
        $file_name = $this->get_table_file_name();
        $zipper = new Zipper();
        $zipper->zip($destination_path)
            ->folder('database/migrations')
            ->addString($file_name, $this->get_migration_content());
    }
    public function save_model_to_zip($destination_path)
    {
        $file_name = $this->get_model_name() . '.php';
        $zipper = new Zipper();
        $zipper->zip($destination_path)
            ->folder('app/Models')
            ->addString($file_name, $this->get_model_content());
    }
    public function save_api_controller_to_zip($destination_path)
    {
        $file_name = $this->get_controller_name() . '.php';
        $zipper = new Zipper();
        $zipper->zip($destination_path)
            ->folder('app/Http/Controllers')
            ->addString($file_name, $this->get_controller_content());
    }
    public function save_api_resource_to_zip($destination_path)
    {
        $file_name = $this->get_resource_name() . '.php';
        $zipper = new Zipper();
        $zipper->zip($destination_path)
            ->folder('app/Http/Resources')
            ->addString($file_name, $this->get_resource_content());
    }
    public function save_api_route_to_zip($tables, $destination_path)
    {
        $route_content = '';
        foreach ($tables as $table) {
            $route_content .= "\t" . $table->get_api_route_content() . "\n";
        }
        $replace = [
            '>>ROUTE_CONTENT<<' => $route_content,
        ];
        $stub_location = 'stub/api/route.stub';
        $file_content = $this->replace_stub($stub_location, $replace);
        $file_name = 'api.php';
        $zipper = new Zipper();
        $zipper->zip($destination_path)
            ->folder('routes')
            ->addString($file_name, $file_content);
    }
    public function save_api_crud_to_zip($destination_path)
    {
        $this->save_model_to_zip($destination_path);
        $this->save_api_controller_to_zip($destination_path);
        $this->save_api_resource_to_zip($destination_path);
        $this->save_migration_to_zip($destination_path);
    }
}
