<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CrudField;
use App\Inflector;

class Crud extends Model {

    public static function generation($crud_id){
        $crud = Crud::findOrFail($crud_id);
        $crud->project_root = "generated_files/" . $crud->crud_name;
        $crud->model_name = Inflector::text($crud->crud_name)->camel_case(true)->get();
        $crud->controller_name = Inflector::text($crud->crud_name)->camel_case(true)->get() . 'Controller';
        $crud->view_directory = $crud->project_root . "/resources/views/" . Inflector::text($crud->crud_name)->snake_case()->get();
        $crud->route_name = Inflector::text($crud->crud_name)->camel_case(true)->get();
        return $crud;
    }
    public function generateModel() {
        $stub_location = 'stub/model.stub';
        $file_name = $this->model_name . '.php';
        $file_directory = $this->project_root. '/app';
        $replace = [
            '$model_name$' => $this->model_name,
            '$fillable_fields$' => $this->fillable_fields(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateController() {
        $stub_location = 'stub/controller.stub';
        $file_name = $this->controller_name . '.php';
        $file_directory = $this->project_root. '/app/Http/Controllers';
        $replace = [
            '$model_name$' => $this->model_name,
            '$controller_name$' => $this->controller_name,
            '$view_directory$' => $this->view_directory,
            '$route_name$' => $this->route_name,
            '$storing_validations$' => $this->storing_validations(),
            '$updating_validations$' => $this->updating_validations(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateApiController() {
        $stub_location = 'stub/api/controller.stub';
        $file_name = $this->controller_name . '.php';
        $file_directory = $this->project_root. '/app/Http/Controllers';
        $replace = [
            '$MODEL_NAME$' => $this->model_name,
            '$ROUTE_NAME$' => $this->route_name,
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateApiResource() {
        $stub_location = 'stub/api/resource.stub';
        $file_name = $this->model_name . 'Resource.php';
        $file_directory = $this->project_root. '/app/Http/Resources';
        $replace = [
            '$MODEL_NAME$' => $this->model_name,
            '$ROUTE_NAME$' => $this->route_name,
            '$ROUTE_NAME_PLURAL$' => Inflector::text($this->route_name)->pluralize()->get(),
            '$RESOURCE_FIELDS$' => $this->resource_fileds(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateMigration() {
        $stub_location = 'stub/migration.stub';
        $file_name = date('Y_m_d_His') . '_create_' . $this->table_name . '_table.php';
        $file_directory = $this->project_root. '/database/migrations';
        $replace = [
            '$model_name$' => $this->model_name,
            '$model_name_plural$' => Inflector::text($this->model_name)->pluralize()->get(),
            '$table_name$' => $this->table_name,
            '$migration_fields$' => $this->migration_fields(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateCreate() {
        $stub_location = 'stub/create.stub';
        $file_name = $this->view_directory . '_create.blade.php';
        $file_directory = $this->project_root. '/' . $this->view_directory;
        $replace = [
            '$view_name$' => $this->crud_view_name,
            '$ROUTE_NAME$' => $this->route_name,
            '$form_fields$' => $this->form_fields(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateIndex() {
        $stub_location = 'stub/index.stub';
        $file_name = $this->view_directory . '_index.blade.php';
        $file_directory = $this->project_root. '/' . $this->view_directory;
        $replace = [
            '$VIEW_NAME$' => $this->crud_view_name,
            '$ROUTE_NAME$' => $this->route_name,
            '$TABLE_HEADERS$' => $this->table_headers(),
            '$TABLE_CELLS$' => $this->table_cells(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateEdit() {
        $stub_location = 'stub/edit.stub';
        $file_name = $this->view_directory . '_edit.blade.php';
        $file_directory = $this->project_root. '/' . $this->view_directory;
        $replace = [
            '$VIEW_NAME$' => $this->crud_view_name,
            '$ROUTE_NAME$' => $this->route_name,
            '$form_fields$' => $this->form_fields(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }
    public function generateShow() {
        $stub_location = 'stub/show.stub';
        $file_name = $this->view_directory . '_show.blade.php';
        $file_directory = $this->project_root. '/' . $this->view_directory;
        $replace = [
            '$VIEW_NAME$' => $this->crud_view_name,
            '$ROUTE_NAME$' => $this->route_name,
            '$SHOW_TABLE_CELLS$' => $this->show_table_cells(),
        ];
        $file_content = $this->get_file_content($stub_location, $replace);
        return $this->createFile($file_name, $file_directory, $file_content);
    }



    public function fillable_fields() {
        $fillable_fields = "";
        $fields = CrudField::where('crud_id', $this->id)->get();
        foreach ($fields as $field) {
            $fillable_fields .= "'" . $field->field_name . "',\n\t\t";
        }
        return $fillable_fields;
    }

    public function get_file_content($stub_location, $replace){
        $file = fopen($stub_location, 'r') or die("Unable to open file!");
        $read_content = fread($file, filesize($stub_location));
        $file_content = str_replace(array_keys($replace),array_values($replace), $read_content);
        return $file_content;
    }
    public function createFile($file_name, $directory, $file_content) {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $myfile = fopen("{$directory}/{$file_name}", "w") or die("Unable to make model!");
        fwrite($myfile, $file_content);
        fclose($myfile);
        return true;
    }

    public function storing_validations() {
        return '';
    }

    public function updating_validations() {
        return '';
    }

    public function migration_fields() {
        $migration_fields = "";
        $fields = CrudField::where('crud_id', $this->id)->get();
        foreach ($fields as $field) {
            $migration_fields .= "\n\t\t\t\$table->" . $field->db_type . "('" . $field->field_name . "')";
            $migration_fields .= ";";
        }
        return $migration_fields;
    }
    public function form_fields() {
        $form_fields = "";
        $fields = CrudField::where('crud_id', $this->id)->get();
        foreach ($fields as $field) {
            if($field['fillable']){
                $stub_location = 'stub/form_fields/'. $field->html_type.'.stub';
                $replace = [
                    '$FIELD_NAME_TITLE$' => $field->field_view_name,
                    '$FIELD_NAME$' => $field->field_name,
                ];
                $form_fields .= $this->get_file_content($stub_location, $replace) . "\r\n";
            }
        }
        return $form_fields;
    }
    public function resource_fileds(){
        $resource_fields = "";
        $fields = CrudField::where('crud_id', $this->id)->get();
        foreach ($fields as $field) {
            $resource_fields .= "\n\t\t\t'" . $field->field_name . "'=>\$this->" . $field->field_name;
            $resource_fields .= ",";
        }
        return $resource_fields;
    }
    public function table_headers(){
        $table_headers = "";
        $fields = CrudField::where('crud_id', $this->id)->get();
        foreach ($fields as $field) {
            if($field->in_index){
                $table_headers .= "<th>" . $field->field_view_name . "</th>\r\n\t\t\t\t\t\t\t\t\t\t";
            }
        }
        return $table_headers;
    }
    public function table_cells(){
        $table_cells = "";
        $fields = CrudField::where('crud_id', $this->id)->get();
        foreach ($fields as $field) {
            if($field->in_index){
                $table_cells .= "<td>{{\$item->" . $field->field_name . "}}</td>\r\n\t\t\t\t\t\t\t\t\t\t";
            }
        }
        return $table_cells;
    }
    public function show_table_cells(){
        $show_table_cells = "";
        $fields = CrudField::where('crud_id', $this->id)->get();
        foreach ($fields as $field) {
            if($field->in_show){
                $show_table_cells .= "<tr><th>" . $field->field_view_name ."</th></tr>\r\n\t\t\t\t\t\t";
                $show_table_cells .= "<tr><td>{{\$item->" . $field->field_name ."}}</td></tr>\r\n\t\t\t\t\t\t";
            }
        }
        return $show_table_cells;
    }

}
