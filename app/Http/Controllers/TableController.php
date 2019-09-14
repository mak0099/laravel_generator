<?php

namespace App\Http\Controllers;

use App\Models\Database;
use App\Models\Table;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Database $database)
    {
        $view = view(config('dashboard.view_root'). 'database.table.index');
        $view->with('database', $database);
        $view->with('table_list', Table::where('database_id', $database->id)->ordered()->get());
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Database $database)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Database $database, Request $request)
    {
        if($request->user_tracking){
            $this->validate($request, [
                'name' => 'required|max:100|unique:tables',
                'foreign_table_id' => 'required',
                'foreign_column_id' => 'required',
                ]);
        }else{
            $this->validate($request, [
                'name' => 'required|max:100|unique:tables',
              ]);
        }
        $table = new Table();
        $table->fill($request->input());
        $table->creator_user_id = Auth::id();
        $table->database()->associate($database);
        $table->save();
        $request->auto_increament ? $table->create_auto_increament() : null;
        $request->user_tracking ? $table->create_user_tracking($request->foreign_table_id, $request->foreign_column_id, $request->on_delete) : null;
        $request->softdelete ? $table->create_softdelete() : null;
        $request->timestamp ? $table->create_timestamp() : null;
        Notify::success('New table saved', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Database $database, Table $table)
    {
        $view = view(config('dashboard.view_root'). 'database.table.detail');
        $view->with('table', $table);
        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Database $database, Table $table)
    {
        $view = view(config('dashboard.view_root'). 'database.table.edit');
        $view->with('table', $table);
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Database $database, Request $request, Table $table)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
         ]);
        $table->fill($request->input());
        $table->updator_user_id = Auth::id();
        $table->update();
        Notify::success('Table updated', 'Success');
        return redirect()->route('database.table.index', $database);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Database $database, Table $table)
    {
        $table->delete();
        $this->delete_file($table->image_path);
        Notify::success('Table deleted', 'Success');
        return redirect()->route('database.table.index', $database);
    }
    private function delete_file($file_path){
        if(file_exists($file_path)){
            unlink($file_path);
        }
    }
}
