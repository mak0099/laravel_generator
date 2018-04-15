<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Moderator;
use Auth;
use Session;

class ModeratorController extends Controller {

    private $root = 'moderator';

    public function index() {
        $view = view($this->root . '/moderator_index');
        $view->with('items', Moderator::all());
        return $view;
    }

    public function create() {
        $view = view($this->root . '/moderator_create');
        return $view;
    }

    public function store(Request $request) {
        
        $item = new Moderator();
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->save();
        Session::flash('alert-success', 'New item created.');
        return redirect()->route('Moderator.index');
    }

    public function show($id) {
        $view = view($this->root . '/moderator_show');
        $view->with('item', Moderator::findOrFail($id));
        return $view;
    }

    public function edit($id) {
        $view = view($this->root . '/moderator_edit');
        $view->with('item', Moderator::findOrFail($id));
        return $view;
    }

    public function update(Request $request, $id) {
        
        $item = Moderator::findOrFail($id);
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->update();
        Session::flash('alert-success', 'Item updated');
        return redirect()->route('Moderator.index');
    }

    public function destroy($id) {
        Moderator::findOrFail($id)->delete();
        Session::flash('alert-success', 'item deleted');
        return redirect()->back();
    }

}