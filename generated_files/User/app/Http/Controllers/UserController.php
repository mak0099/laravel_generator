<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Session;

class UserController extends Controller {

    private $root = 'user';

    public function index() {
        $view = view($this->root . '/user_index');
        $view->with('items', User::all());
        return $view;
    }

    public function create() {
        $view = view($this->root . '/user_create');
        return $view;
    }

    public function store(Request $request) {
        
        $item = new User();
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->save();
        Session::flash('alert-success', 'New item created.');
        return redirect()->route('User.index');
    }

    public function show($id) {
        $view = view($this->root . '/user_show');
        $view->with('item', User::findOrFail($id));
        return $view;
    }

    public function edit($id) {
        $view = view($this->root . '/user_edit');
        $view->with('item', User::findOrFail($id));
        return $view;
    }

    public function update(Request $request, $id) {
        
        $item = User::findOrFail($id);
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->update();
        Session::flash('alert-success', 'Item updated');
        return redirect()->route('User.index');
    }

    public function destroy($id) {
        User::findOrFail($id)->delete();
        Session::flash('alert-success', 'item deleted');
        return redirect()->back();
    }

}