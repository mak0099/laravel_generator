<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MarketPlace;
use Auth;
use Session;

class MarketPlaceController extends Controller {

    private $root = 'market_place';

    public function index() {
        $view = view($this->root . '/market_place_index');
        $view->with('items', MarketPlace::all());
        return $view;
    }

    public function create() {
        $view = view($this->root . '/market_place_create');
        return $view;
    }

    public function store(Request $request) {
        
        $item = new MarketPlace();
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->save();
        Session::flash('alert-success', 'New item created.');
        return redirect()->route('MarketPlace.index');
    }

    public function show($id) {
        $view = view($this->root . '/market_place_show');
        $view->with('item', MarketPlace::findOrFail($id));
        return $view;
    }

    public function edit($id) {
        $view = view($this->root . '/market_place_edit');
        $view->with('item', MarketPlace::findOrFail($id));
        return $view;
    }

    public function update(Request $request, $id) {
        
        $item = MarketPlace::findOrFail($id);
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->update();
        Session::flash('alert-success', 'Item updated');
        return redirect()->route('MarketPlace.index');
    }

    public function destroy($id) {
        MarketPlace::findOrFail($id)->delete();
        Session::flash('alert-success', 'item deleted');
        return redirect()->back();
    }

}