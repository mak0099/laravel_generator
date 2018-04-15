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
        $crud->view_directory = Inflector::text($crud->crud_name)->snake_case()->get();
        $crud->route_name = Inflector::text($crud->crud_name)->camel_case(true)->get();
        return $crud;
    }
    public function generateModel() {
        $stub_location = 'resources/views/stub/model.stub';
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
        $stub_location = 'resources/views/stub/controller.stub';
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

    public function generateMigration() {
        $stub_location = 'resources/views/stub/migration.stub';
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
        $stub_location = 'resources/views/stub/create.stub';
        $file_name = $this->view_directory . '_create.blade.php';
        $file_directory = $this->project_root. '/resources/views/' . $this->view_directory;
        $replace = [
            '$view_name$' => $this->view_name,
            '$route_name$' => $this->route_name,
            '$form_fields$' => $this->form_fields(),
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
                $form_fields .= $this->get_form_field($field);
            }
        }
        return $form_fields;
    }
    public function get_form_field($field){
        $form_field = '';
        switch ($field->html_type) {
            case 'text':
                $form_field = "<div class=\"form-group\">
                                <label class=\"control-label mb-10\">{$field->field_view_name}</label>
                                <input type=\"text\" class=\"form-control\" name=\"{$field->field_name}\" value=\"{{old('{$field->field_name}')}}\">
                            </div>";
                break;
            case 'email':
                $stub_location = 'resources/views/stub/form_fields/email.stub';
                $replace = [
                    '$view_name$' => $this->view_name,
                    '$route_name$' => $this->route_name,
                ];
                $form_field = $this->get_file_content($stub_location, $replace);
                break;
            
            default:
                # code...
                break;
        }
        return $form_field;
    }

}
