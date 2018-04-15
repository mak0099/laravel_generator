<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CrudField;
use App\Inflector;

class Crud extends Model
{
	private $project_root;
	private $model_name;
	private $i;
	public function __construct(){
	}
    public function generateModel(){
		$this->project_root = "generated_files/". $this->crud_name;
		$this->model_name = Inflector::text($this->crud_name)->camel_case(true)->get();
    	$file_content = fopen('resources/views/stub/model.stub', 'r') or die("Unable to open file!");
        dd(fread($file_content, filesize('resources/views/stub/model.stub')));
		return $this->createFile($this->model_name, "{$this->project_root}/app", $file_content);
    }
    public function generateController(){
		$this->project_root = "generated_files/". $this->crud_name;
		$this->model_name = Inflector::text($this->crud_name)->camel_case(true)->get();
		$this->controller_name = Inflector::text($this->crud_name)->camel_case(true)->get() . 'Controller';
		$this->view_directory = Inflector::text($this->crud_name)->snake_case()->get();
		$this->route_name = Inflector::text($this->crud_name)->camel_case(true)->get();
    	$file_content =  
"<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\\{$this->model_name};
use Auth;
use Session;

class {$this->controller_name} extends Controller {

    private \$root = '{$this->view_directory}';

    public function index() {
        \$view = view(\$this->root . '/{$this->view_directory}_index');
        \$view->with('items', {$this->model_name}::all());
        return \$view;
    }

    public function create() {
        \$view = view(\$this->root . '/{$this->view_directory}_create');
        return \$view;
    }

    public function store(Request \$request) {
        {$this->storing_validations()}
        \$item = new {$this->model_name}();
        \$item->fill(\$request->input());
        \$item->created_by = Auth::id();
        \$item->save();
        Session::flash('alert-success', 'New item created.');
        return redirect()->route('{$this->route_name}.index');
    }

    public function show(\$id) {
        \$view = view(\$this->root . '/{$this->view_directory}_show');
        \$view->with('item', {$this->model_name}::findOrFail(\$id));
        return \$view;
    }

    public function edit(\$id) {
        \$view = view(\$this->root . '/{$this->view_directory}_edit');
        \$view->with('item', {$this->model_name}::findOrFail(\$id));
        return \$view;
    }

    public function update(Request \$request, \$id) {
        {$this->updating_validations()}
        \$item = {$this->model_name}::findOrFail(\$id);
        \$item->fill(\$request->input());
        \$item->created_by = Auth::id();
        \$item->update();
        Session::flash('alert-success', 'Item updated');
        return redirect()->route('{$this->route_name}.index');
    }

    public function destroy(\$id) {
        {$this->model_name}::findOrFail(\$id)->delete();
        Session::flash('alert-success', 'item deleted');
        return redirect()->back();
    }

}
";
		return $this->createFile($this->controller_name, "{$this->project_root}/app/Http/Controllers", $file_content);
    }
    public function generateMigration(){
		$this->project_root = "generated_files/". $this->crud_name;
		$this->model_name = Inflector::text($this->crud_name)->camel_case(true)->get();
		$this->controller_name = Inflector::text($this->crud_name)->camel_case(true)->get() . 'Controller';
		$this->view_directory = Inflector::text($this->crud_name)->snake_case()->get();
		$this->route_name = Inflector::text($this->crud_name)->camel_case(true)->get();
		$this->model_name_plural = Inflector::text($this->model_name)->pluralize()->get();
    	$file_content =  
"<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create{$this->model_name_plural}Table extends Migration
{
    public function up()
    {
        Schema::create('{$this->table_name}', function (Blueprint \$table) {
            \$table->increments('id');{$this->table_fields()}
            \$table->softDeletes();
            \$table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('{$this->table_name}');
    }
}

";
		return $this->createFile(date('Y_m_d_His') . '_create_' . $this->table_name . '_table', "{$this->project_root}/database/migrations", $file_content);
    }
    public function fillable_fields(){
    	$fillable_fields = "";
    	$fields = CrudField::where('crud_id', $this->id)->get();
		foreach($fields as $field){
		    $fillable_fields .= "'" . $field->field_name . "',\n\t\t";
		}
		return $fillable_fields;
    }
    public function createFile($file_name, $directory, $file_content){
    	if (!file_exists($directory)) {
		    mkdir($directory, 0777, true);
		}
		$myfile = fopen("{$directory}/{$file_name}.php", "w") or die("Unable to make model!");
		fwrite($myfile, $file_content);
		fclose($myfile);
		return true;
    }
    public function storing_validations(){
    	return '';
    }
    public function updating_validations(){
    	return '';
    }
    public function table_fields(){
    	$table_fields = "";
    	$fields = CrudField::where('crud_id', $this->id)->get();
    	foreach($fields as $field){
		    $table_fields .= "\n\t\t\t\$table->" . $field->db_type . "('" . $field->field_name . "')";
		    $table_fields .= ";";
		}
		return $table_fields;
    }
}
