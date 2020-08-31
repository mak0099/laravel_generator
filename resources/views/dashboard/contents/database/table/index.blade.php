@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <ol class="breadcrumb" style="position:relative; top:-10px">
                <li><a href="{{ route('database.index') }}">Databases</a></li>
                <li class="active">{{ $database->name }}</li>
            </ol>
        </div>
        <div class="col-xs-8 text-right m-b-20">
            <a href="#" class="btn btn-info rounded pull-right" data-toggle="modal" data-target="#import"><i class="fa fa-cloud-upload"></i> Import Table</a>
            <a href="#" class="btn btn-primary rounded pull-right" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i> Create Table</a>
            <div class="view-icons">
                <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table custom-table {{ config('dashboard.modules.table.use_datatable') ? 'datatable' : null }}">
                    <thead>
                        <tr>
                            <th style="width: 15px; color:#ccc">#</th>
                            <th colspan="4">Tables</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table_list as $item)
                        <tr>
                            <td style="color:#ccc">{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('database.table.column.index', [$database, $item]) }}"><i class="fa fa-table"></i> {{ $item->name }}</a> 
                            </td>
                            <td style="width:100px">
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-xs rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-primary"></i> Move <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="@if(!$loop->first){{ route('move_item',['model'=>'Table', 'id'=>$item->id, 'value'=>'top']) }}@endif"><i class="fa fa-dot-circle-o text-success"></i> Move to first</a></li>
                                        <li><a href="@if(!$loop->first){{ route('move_item',['model'=>'Table', 'id'=>$item->id, 'value'=>'up']) }}@endif"><i class="fa fa-arrow-up text-success"></i> Move up</a></li>
                                        <li><a href="@if(!$loop->last){{ route('move_item',['model'=>'Table', 'id'=>$item->id, 'value'=>'down']) }}@endif"><i class="fa fa-arrow-down text-danger"></i> Move down</a></li>
                                        <li><a href="@if(!$loop->last){{ route('move_item',['model'=>'Table', 'id'=>$item->id, 'value'=>'bottom']) }}@endif"><i class="fa fa-dot-circle-o text-danger"></i> Move to last</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td style="width:150px">
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o {{ $item->active ? 'text-success' : 'text-danger' }}"></i> {{ $item->active ? 'Active' : 'Inactive' }} <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="@if(!$item->active){{ route('change_activation',['model'=>'Table', 'id'=>$item->id, 'active'=>true]) }}@endif"><i class="fa fa-dot-circle-o text-success"></i> Active</a></li>
                                        <li><a href="@if($item->active){{ route('change_activation',['model'=>'Table', 'id'=>$item->id, 'active'=>false]) }}@endif"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td style="width:10px">
                                <div class="dropdown">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('database.table.api_crud', [$database, $item]) }}"><i class="fa fa-eye m-r-5"></i> Make API CRUD</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('database.table.destroy', [$database, $item]) }}'"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="create" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Create Table</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('database.table.store', $database) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')
                    {!! BootForm::text('name', 'Table Name', old('name'), ['autofocus'=>'true']) !!}
                    <div class="form-group">
                        <label class="control-label">Initialize Columns</label>
                        @if(old('user_tracking')) 
                        <span ng-init="user_tracking=true"></span>
                        @endif
                        {!! BootForm::hidden('auto_increament', 0, false) !!}
                        {!! BootForm::checkbox('auto_increament', 'AUTO INCREAMENT ID (id)', 1, old('auto_increament') ?? true) !!}
                        {!! BootForm::hidden('user_tracking', 0, false) !!}
                        {!! BootForm::checkbox('user_tracking', 'USER TRACKING (created_by, updated_by)', 1, old('user_tracking') ?? false, ['ng-model'=>'user_tracking']) !!}
                        <div class="panel" ng-show="user_tracking">
                            <div class="well">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {!! BootForm::select('foreign_table_id', 'Select User Table', [], old('foreign_table_id'), ['class'=>'select2', 'data-placeholder'=>'Select Foreign Table','data-model'=>'Table', 'data-text-field'=>'name', 'data-where-column'=>'database_id', 'data-where-value'=>$database->id]) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        {!! BootForm::select('foreign_column_id', 'Select ID Field', [], old('foreign_column_id'), ['class'=>'select2', 'data-placeholder'=>'Select Foreign Column','data-model'=>'Column', 'data-text-field'=>'name', 'data-dependent-element-id'=>'foreign_table_id']) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        {!! BootForm::radios('on_delete', 'On Delete', App\Models\Column::get_on_deletes(), old('on_delete') ?? App\Models\Column::get_default_on_delete(), false) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! BootForm::hidden('softdelete', 0, old('softdelete') ?? false) !!}
                        {!! BootForm::checkbox('softdelete', 'SOFT DELETE (deleted_at)', 1, old('softdelete') ?? false) !!}
                        {!! BootForm::hidden('timestamp', 0, false) !!}
                        {!! BootForm::checkbox('timestamp', 'TIMESTAMP (created_at, updated_at)', 1, old('timestamp') ?? true) !!}
                    </div>
                    {!! BootForm::radios('active', 'Status', ['1'=>'Active', '0'=>'Inactive',], old('active') ?? 1, true) !!}
                    
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary btn-lg">Create Table</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="import" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Import Tables</h4>
            </div>
            <div class="modal-body">
                <div class="card-box">
                    <h6 class="card-title">Import from...</h6>
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                        <li class="active"><a href="#bottom-justified-tab1" data-toggle="tab">Laravel Migration</a></li>
                        <li><a href="#bottom-justified-tab2" data-toggle="tab">SQL</a></li>
                        <li><a href="#bottom-justified-tab3" data-toggle="tab">Other</a></li>
                    </ul>
                    <div class="tab-content" style="min-height: 500px">
                        <div class="tab-pane active" id="bottom-justified-tab1">
                            <form action="{{ route('database.import', $database) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <label style="
                                    border: 3px dashed #ccc;
                                    border-radius: 20px;
                                    display: inline-block;
                                    width: 80%;
                                    margin: 5% 10%;
                                    padding: 5%;
                                    font-size: 2em;
                                    text-align: center;
                                    cursor: pointer;"
                                >
                                <input type="hidden" name="import_type" value="laravel-migration">
                                    <input type="file" id="files" name="files[]" multiple onchange="javascript:updateList()" style="display: none"/>
                                    <i class="fa fa-cloud-upload"></i> Choose Files
                                </label>
                                <ul class="list-group" id="fileList"></ul>
                                <div class="m-t-20 text-center">
                                    <button class="btn btn-primary btn-lg"><span class="fa fa-upload"></span>  Import</button>
                                </div>
                            </form>
                            
                        </div>
                        <div class="tab-pane" id="bottom-justified-tab2">
                            Under Construction
                        </div>
                        <div class="tab-pane" id="bottom-justified-tab3">
                            Under Construction
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="delete" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h4 class="modal-title">Delete Table</h4>
            </div>
            <div class="modal-body card-box">
                <p>Are you sure want to delete this?</p>
                <form action="@{{ delete_url }}" method="post">
                    @csrf @method('DELETE')
                    <div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
    <script>
        @if(count($errors) > 0)
        $('#create').modal('show')
        @endif
        updateList = function() {
            var input = document.getElementById('files');
            var output = document.getElementById('fileList');
            var children = "";
            for (var i = 0; i < input.files.length; ++i) {
                children +=  '<li class="list-group-item"><span class="fa fa-table"></span> '+ input.files.item(i).name+ '<span style="margin-left:15px" class="fa fa-times text-danger pull-right" onclick="remove(this,'+ i +')"></span>' +'<span class="text-muted pull-right">'+ input.files.item(i).size/100 +'KB</span>' + '</li>'
            }
            output.innerHTML = children;
        }
        remove = function(event, index){
            // return event.parentNode.remove();
        }
    </script>
@endsection