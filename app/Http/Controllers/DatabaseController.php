<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Database;
use App\Models\FileMaker;
use App\Models\Table;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Auth;
use DB;
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
        $database->creator_user_id = auth()->id();
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
        $database->updator_user_id = auth()->id();
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
        // if ($database->tables->count() > 0) {
        //     Notify::warning('First, delete all tables belong to the database!', 'Warning');
        //     return redirect()->back();
        // }
        $database->tables()->delete();
        $database->columns()->delete();
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
    public function import(Database $database, Request $request)
    {
        if ($request->import_type == 'laravel-migration') {
            // dd($request->files);
            foreach ($request->file('files') as $file) {
                // dd($file->openFile()->fread($file->getSize()));
                // $file_content = $file->openFile()->fread($file->getSize());
                // $arr = explode('\\n', $file_content);
                // dd($arr);
                // dd($file);
                //
                $lines = file($file);
                // dd($lines);
                $table_name_lines = $this->getLineWithString($lines, 'Schema::create(\'');
                $table_name = $this->searchStringFromLine($table_name_lines[0], "Schema::create\(\'", "',");
                $table = new Table();
                $table->name = $table_name;
                $table->creator_user_id = auth()->id();
                $table->database()->associate($database);
                $table->save();
                // dd($table_name);

                $column_lines = $this->getLineWithString($lines, '$table->');
                // dd($column_lines);
                foreach ($column_lines as $column_line) {
                    $column = new Column();
                    $column->type = $this->searchStringFromLine($column_line, '\$table->', '(');
                    $column->name = $this->searchStringFromLine($column_line, $column->type . '\(\'', '\'');
                    if ($column->type == 'softDeletes') $column->name = 'softDeletes()';
                    if ($column->type == 'timestamps') $column->name = 'timestamps()';
                    if ($column->type == 'rememberToken') $column->name = 'rememberToken()';
                    if ($column->type == 'foreign') {
                        $column = $table->columns()->where('name', $column->name)->first();
                        $column->type = 'foreign';
                        $foreign_table_name = $this->searchStringFromLine($column_line, '->on\(', ')');
                        $foreign_table = $database->tables()->where('name', $foreign_table_name)->first();
                        if (!$foreign_table) {
                            Notify::error('Foreign Table "' . $foreign_table_name . '" not found', 'Error');
                            $table->forceDelete();
                            return redirect()->back();
                            // abort(404, 'Foreign Table "' . $foreign_table_name . '" not found');
                        }
                        $column->foreign_table_id = $foreign_table->id;
                        $foreign_column_name = $this->searchStringFromLine($column_line, '->references\(', ')');
                        $column->foreign_column_id = $foreign_table->columns()->where('name', $foreign_column_name)->first()->id;
                        $column->on_delete = $this->searchStringFromLine($column_line, '->onDelete\(', ')');
                        $column->update();
                        continue;
                        // dd($column);
                    }
                    $column->length = $this->searchStringFromLine($column_line, $column->name . '\',', ')');
                    $column->default = $this->searchStringFromLine($column_line, 'default\(', ')');
                    $column->unsigned = $this->searchStringFromLine($column_line, '->unsigned\(', ')') !== null ? true : false;
                    $column->nullable = $this->searchStringFromLine($column_line, '->nullable\(', ')') !== null ? true : false;
                    $column->unique = $this->searchStringFromLine($column_line, '->unique\(', ')') !== null ? true : false;
                    $column->primary = $this->searchStringFromLine($column_line, '->primary\(', ')') !== null ? true : false;
                    $column->index = $this->searchStringFromLine($column_line, '->index\(', ')') !== null ? true : false;
                    $column->auto_increament = $column->type == 'increaments' || $column->type == 'bigIncreaments' ? true : false;
                    $column->comment = $this->searchStringFromLine($column_line, 'comment\(', ')');
                    $column->table()->associate($table);
                    $column->database()->associate($database);
                    $column->save();
                    // dd($column);
                }
            }
            Notify::success('Laravel Migration Files imported!', 'Success');
            return redirect()->back();
        }
    }
    private function searchStringFromLine($line, $beforeString, $afterString)
    {
        $pattern = '/' . $beforeString . '/';
        // dd($pattern);
        $result = preg_split($pattern, trim($line));
        if (count($result) > 1) {
            $result_split = explode($afterString, $result[1]);
            $str = trim(trim($result_split[0], "''"));
            if ($str == 'true') return true;
            if ($str == 'false') return false;
            return $str;
        }
    }
    private function getLineWithString($lines, $str)
    {
        $found_lines = [];
        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, $str) !== false) {
                $found_lines[] = $line;
            }
        }
        return $found_lines;
    }
    public function export(Database $database, Request $request)
    {
        if (!$request->tables) {
            Notify::error('You have to select at least one table', 'Error');
            return redirect()->back();
        }
        $destination_path = 'generated_files/' . $database->name . '.zip';
        if (file_exists($destination_path)) {
            unlink($destination_path);
        }
        $tables = Table::find($request->tables);
        foreach ($tables as $table) {
            if ($request->export_type == 'migration') $table->save_migration_to_zip($destination_path);
            if ($request->export_type == 'api-crud') {
                $table->save_api_crud_to_zip($destination_path);
            }
        }
        if ($request->export_type == 'api-crud') {
            $table->save_api_route_to_zip($tables, $destination_path);
        }
        if (file_exists($destination_path)) {
            $zip_file_name = $database->name . '_' . $request->export_type;
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
