<?php

namespace App\Http\Controllers;

use App\Models\Database;
use App\Models\FileMaker;
use App\Models\Table;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Chumper\Zipper\Zipper;
use ZanySoft\Zip\Zip;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = view(config('dashboard.view_root') . 'database.index');
        $view->with('database_list', Database::orderBy('id', 'desc')->get());
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $database = new Database();
        $database->fill($request->input());
        $database->creator_user_id = Auth::id();
        $database->save();
        Notify::success('New database saved', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Database  $database
     * @return \Illuminate\Http\Response
     */
    public function show(Database $database)
    {
        $view = view(config('dashboard.view_root') . 'database.detail');
        $view->with('database', $database);
        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Database  $database
     * @return \Illuminate\Http\Response
     */
    public function edit(Database $database)
    {
        $view = view(config('dashboard.view_root') . 'database.edit');
        $view->with('database', $database);
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Database  $database
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Database $database)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $database->fill($request->input());
        $database->updator_user_id = Auth::id();
        $database->update();
        Notify::success('Database updated', 'Success');
        return redirect()->route('database.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Database  $database
     * @return \Illuminate\Http\Response
     */
    public function destroy(Database $database)
    {
        if ($database->tables->count() > 0) {
            Notify::warning('First, delete all tables belong to the database!', 'Warning');
            return redirect()->back();
        }
        $database->delete();
        $this->delete_file($database->image_path);
        Notify::success('Database deleted', 'Success');
        return redirect()->route('database.index');
    }
    public function exportation(Database $database)
    {
        $view = view(config('dashboard.view_root') . 'database.exportation');
        $view->with('database', $database);
        return $view;
    }
    public function export(Database $database, Request $request)
    {
        if (!$request->tables) {
            Notify::error('You have to select at least one table', 'Error');
            return redirect()->back();
        }
        $destination_path = 'generated_files/migration_tables.zip';
        if (file_exists($destination_path)) {
            unlink($destination_path);
        }
        $tables = Table::find($request->tables);
        foreach ($tables as $table) {
            $table->add_to_export($destination_path);
        }
        if (file_exists($destination_path)) {
            $zip_file_name = 'migrations';
            return $database->getDownload($destination_path, $zip_file_name);
        }
        Notify::error('Download Error', 'Error');
        return redirect()->back();
    }
    private function delete_file($file_path)
    {
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}
