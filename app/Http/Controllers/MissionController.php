<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = view(config('dashboard.view_root'). 'mission.index');
        $view->with('mission_list', Mission::orderBy('id', 'desc')->get());
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
            'title' => 'required|max:100',
            'description' => 'required',
            'date' => 'nullable|date_format:'.config('dashboard.input_date_format'),
            'image' => 'file|mimes:'.config('dashboard.modules.mission.upload_accept_file_type').'|max:'.config('dashboard.modules.mission.upload_max_file_size'),
        ]);
        $mission = new Mission();
        $mission->fill($request->input());
        if($request->image){
            $image = $request->image;
            $destination = config('dashboard.modules.mission.upload_file_location');
            $image_path = $destination . time() . "-" . $image->getClientOriginalName();
            $image->move($destination, $image_path);
            $mission->image_path = $image_path;
        }
        $mission->date = $request->date ? Carbon::createFromFormat(config('dashboard.input_date_format'),$request->date) : null;
        $mission->creator_user_id = Auth::id();
        $mission->save();
        Notify::success('New mission saved', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function show(Mission $mission)
    {
        $view = view(config('dashboard.view_root'). 'mission.detail');
        $view->with('mission', $mission);
        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function edit(Mission $mission)
    {
        $view = view(config('dashboard.view_root'). 'mission.edit');
        $view->with('mission', $mission);
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mission $mission)
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'description' => 'required',
            'date' => 'nullable|date_format:'.config('dashboard.input_date_format'),
            'image' => 'file|mimes:'.config('dashboard.modules.mission.upload_accept_file_type').'|max:'.config('dashboard.modules.mission.upload_max_file_size'),
        ]);
        $mission->fill($request->input());
        if($request->image){
            $image = $request->image;
            $destination = 'uploads/mission/';
            $image_path = $destination . time() . "-" . $image->getClientOriginalName();
            $image->move($destination, $image_path);
            $this->delete_file($mission->image_path);
            $mission->image_path = $image_path;
        }
        $mission->date = $request->date ? Carbon::createFromFormat(config('dashboard.input_date_format'),$request->date) : null;
        $mission->updator_user_id = Auth::id();
        $mission->update();
        Notify::success('Mission updated', 'Success');
        return redirect()->route('mission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mission $mission)
    {
        $mission->delete();
        $this->delete_file($mission->image_path);
        Notify::success('Mission deleted', 'Success');
        return redirect()->route('mission.index');
    }
    private function delete_file($file_path){
        if(file_exists($file_path)){
            unlink($file_path);
        }
    }
}
