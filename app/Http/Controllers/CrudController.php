<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Inflector;
use App\Crud;
use App\CrudField;

class CrudController extends Controller
{
    public function index()
    {
        return view(config('dashboard.view_root') . 'crud_generator.crud_index');
    }
    public function addCrud()
    {
        return view(config('dashboard.view_root') . 'crud_generator.add_crud');
    }
    public function saveCrud(Request $request)
    {
        Session::put('crud_info', $request->input());
        return redirect()->route('add_field');
    }

    public function addField()
    {
        $view = view(config('dashboard.view_root') . 'crud_generator.add_field');
        $crud_info = Session::get('crud_info');
        if(!$crud_info['crud_name']){
            Session::flash('alert-danger','Crud name required');
            return redirect()->route('add_crud');
        }
        $view->with('crud_name', $crud_info['crud_name']);
        $view->with('fa_icon', $crud_info['fa_icon']);
        $view->with('fields', Session::get('fields'));
        return $view;
    }
    public function saveFieldItem(Request $request)
    {
        $fields = array();
        if(Session::get('fields')){
            $fields = Session::get('fields');
        }
        array_push($fields, $request->input());
        
        Session::put('fields', $fields);
        Session::flash('alert-success', 'New field added');
        return redirect()->route('add_field');
    }
    public function deleteFieldItem($index)
    {
        $fields = Session::get('fields');
        unset($fields[$index]);
        $fields = array_values($fields);
        Session::put('fields', $fields);
        Session::flash('alert-success', 'field deleted');
        return redirect()->route('add_field');
    }
    public function saveField()
    {
        $s_crud = Session::get('crud_info');
        $crud = new Crud;
        $crud->crud_name = $s_crud['crud_name'];
        $crud->crud_view_name = Inflector::text($s_crud['crud_name'])->humanize()->capitalize()->get();
        $crud->table_name = Inflector::text($s_crud['crud_name'])->snake_case()->pluralize()->get();
        $crud->fa_icon = $s_crud['fa_icon'];
        $crud->soft_delete = isset($s_crud['soft_delete']) ? true : false;
        $crud->data_table = isset($s_crud['data_table']) ? true : false;
        $crud->save();
        $s_fields = Session::get('fields');
        foreach ($s_fields as $key => $s_field) {
            $field = new CrudField;
            $field->crud_id = $crud->id;
            $field->field_name = Inflector::text($s_field['field_name'])->snake_case()->get();
            $field->field_view_name = Inflector::text($s_field['field_name'])->humanize()->capitalize()->get();
            $field->html_type = $s_field['html_type'];
            $field->db_type = $s_field['db_type'];
            $field->searchable = isset($s_field['searchable']) ? true : false;
            $field->fillable = isset($s_field['fillable']) ? true : false;
            $field->editable = isset($s_field['editable']) ? true : false;
            $field->primary = isset($s_field['primary']) ? true : false;
            $field->in_form = isset($s_field['in_form']) ? true : false;
            $field->in_index = isset($s_field['in_index']) ? true : false;
            $field->in_show = isset($s_field['in_show']) ? true : false;
            $field->save();
        }
        return redirect()->route('crud_option', ['crud_id' => $crud->id]);
    }
    public function crudOption($crud_id)
    {
        $view = view(config('dashboard.view_root') . 'crud_generator.crud_option');
        $crud = Crud::findOrFail($crud_id);
        $view->with('crud', $crud);
        return $view;
    }
    public function generateCrud($crud_id, Request $request){
        $crud = Crud::generation($crud_id);
        if(isset($request->model)){
            $crud->generateModel();
        }
        if(isset($request->Controller)){
            $crud->generateController();
        }
        if(isset($request->migration)){
            $crud->generateMigration();
        }
        if(isset($request->view)){
            $crud->generateCreate();
            $crud->generateIndex();
            $crud->generateEdit();
            $crud->generateShow();
        }
        return redirect()->route('add_crud');
    }
    
}
