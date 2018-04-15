<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCategory;
use Auth;
use Session;

class ProductCategoryController extends Controller {

    private $root = 'product_category';

    public function index() {
        $view = view($this->root . '/product_category_index');
        $view->with('items', ProductCategory::all());
        return $view;
    }

    public function create() {
        $view = view($this->root . '/product_category_create');
        return $view;
    }

    public function store(Request $request) {
        
        $item = new ProductCategory();
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->save();
        Session::flash('alert-success', 'New item created.');
        return redirect()->route('ProductCategory.index');
    }

    public function show($id) {
        $view = view($this->root . '/product_category_show');
        $view->with('item', ProductCategory::findOrFail($id));
        return $view;
    }

    public function edit($id) {
        $view = view($this->root . '/product_category_edit');
        $view->with('item', ProductCategory::findOrFail($id));
        return $view;
    }

    public function update(Request $request, $id) {
        
        $item = ProductCategory::findOrFail($id);
        $item->fill($request->input());
        $item->created_by = Auth::id();
        $item->update();
        Session::flash('alert-success', 'Item updated');
        return redirect()->route('ProductCategory.index');
    }

    public function destroy($id) {
        ProductCategory::findOrFail($id)->delete();
        Session::flash('alert-success', 'item deleted');
        return redirect()->back();
    }

}
