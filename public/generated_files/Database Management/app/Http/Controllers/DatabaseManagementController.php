<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatabaseManagement;
use Auth;
use Session;

class DatabaseManagementController extends Controller {

    private $root = 'database_management';

    public function index() {
        $view = view($this->root . '/database_management_index');
        $view->with('items', DatabaseManagement::all());
        return $view;
    }

    public function create() {
        $view = view($this->root . '/database_management_create');
        return $view;
    }

    public function store(Request $request) {
        
        $item = new DatabaseManagement();
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->save();
        Session::flash('alert-success', 'New item created.');
        return redirect()->route('database-management.index');
    }

    public function show($id) {
        $view = view($this->root . '/database_management_show');
        $view->with('item', DatabaseManagement::findOrFail($id));
        return $view;
    }

    public function edit($id) {
        $view = view($this->root . '/database_management_edit');
        $view->with('item', DatabaseManagement::findOrFail($id));
        return $view;
    }

    public function update(Request $request, $id) {
        
        $item = DatabaseManagement::findOrFail($id);
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->update();
        Session::flash('alert-success', 'Item updated');
        return redirect()->route('database-management.index');
    }

    public function destroy($id) {
        DatabaseManagement::findOrFail($id)->delete();
        Session::flash('alert-success', 'item deleted');
        return redirect()->back();
    }

}