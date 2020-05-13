<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Database;
use App\Models\Table;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Database $database, Table $table)
    {
        $view = view(config('dashboard.view_root'). 'database.table.column.index');
        $view->with('database', $database);
        $view->with('table', $table);
        $view->with('column_list', Column::where('database_id', $database->id)->where('table_id', $table->id)->ordered()->get());
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Database $database, Table $table)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Database $database, Table $table, Request $request)
    {
        // dd($request->input());
        $this->validate($request, [
            'name' => 'required|max:50',
          ]);
        $column = new Column();
        $column->fill($request->input());
        $column->creator_user_id = Auth::id();
        $column->database()->associate($database);
        $column->table()->associate($table);
        $column->save();
        Notify::success('New column saved', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function show(Database $database, Table $table, Column $column)
    {
        $view = view(config('dashboard.view_root'). 'database.table.column.detail');
        $view->with('database', $database);
        $view->with('table', $table);
        $view->with('column', $column);
        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function edit(Database $database, Table $table, Column $column)
    {
        $view = view(config('dashboard.view_root'). 'database.table.column.edit');
        $view->with('database', $database);
        $view->with('table', $table);
        $view->with('column', $column);
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function update(Database $database, Table $table, Request $request, Column $column)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
          ]);
        $column->fill($request->input());
        $column->updator_user_id = Auth::id();
        $column->database()->associate($database);
        $column->table()->associate($table);
        $column->update();
        Notify::success('Column updated', 'Success');
        return redirect()->route('database.table.column.index', [$database, $table]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function destroy(Database $database, Table $table, Column $column)
    {
        $column->delete();
        $this->delete_file($column->image_path);
        Notify::success('Column deleted', 'Success');
        return redirect()->route('database.table.column.index', [$database, $table]);
    }
    private function delete_file($file_path){
        if(file_exists($file_path)){
            unlink($file_path);
        }
    }
}
