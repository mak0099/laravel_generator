@extends('dashboard.layouts.master')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-tagsinput.css') }}">
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <ol class="breadcrumb" style="position:relative; top:-10px">
                <li><a href="{{ route('database.index') }}">Databases</a></li>
                <li><a href="{{ route('database.table.index', $database) }}">Tables</a></li>
                <li class="active">{{ $table->name }}</li>
            </ol>
        </div>
        <div class="col-xs-8 text-right m-b-20">
            <a href="#" class="btn btn-primary rounded pull-right" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i> Create Column</a>
            <div class="view-icons">
                <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table custom-table {{ config('dashboard.modules.column.use_datatable') ? 'datatable' : null }}">
                    <thead>
                        <tr>
                            <th style="width: 15px; color:#ccc">#</th>
                            <th colspan="4">Columns</th>
                            <th style="width: 100px; text-align:center">Status</th>
                            <th style="width: 50px" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($table->auto_increament)
                        <tr>
                            <td style="color:#ccc">0</td>
                            <td><i class="fa fa-columns"></i> id</td>
                            <td>
                                <span style="color: #666">
                                    bigIncreaments
                                </span>
                            </td>
                            <td style="color: #666">NOT NULL</td>
                            <td colspan="3"></td>
                        </tr>
                        @endif
                        @foreach ($column_list as $item)
                        <tr>
                            <td style="color:#ccc">{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('database.table.column.show', [$database, $table, $item]) }}"><i class="fa fa-columns"></i> {{ $item->name }}</a>
                            </td>
                            <td>
                                <span style="color: #666">
                                    {{ $item->type }}
                                    @if ($item->type=='foreign')
                                        | {{$item->foreign_table->name}}:{{optional($item->foreign_column)->name ?? 'id'}}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span style="color: #666">
                                    {{ !$item->nullable? 'NOT NULL':'NULLABLE' }}
                                </span>
                            </td>
                            <td>
                                <span style="color: #666">
                                    {{ $item->unique? 'UNIQUE':null }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-xs rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-primary"></i> Move <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="@if(!$loop->first){{ route('move_item',['model'=>'Column', 'id'=>$item->id, 'value'=>'top']) }}@endif"><i class="fa fa-dot-circle-o text-success"></i> Move to first</a></li>
                                        <li><a href="@if(!$loop->first){{ route('move_item',['model'=>'Column', 'id'=>$item->id, 'value'=>'up']) }}@endif"><i class="fa fa-arrow-up text-success"></i> Move up</a></li>
                                        <li><a href="@if(!$loop->last){{ route('move_item',['model'=>'Column', 'id'=>$item->id, 'value'=>'down']) }}@endif"><i class="fa fa-arrow-down text-danger"></i> Move down</a></li>
                                        <li><a href="@if(!$loop->last){{ route('move_item',['model'=>'Column', 'id'=>$item->id, 'value'=>'bottom']) }}@endif"><i class="fa fa-dot-circle-o text-danger"></i> Move to last</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('database.table.column.show', [$database, $table, $item]) }}"><i class="fa fa-eye m-r-5"></i> View Detail</a></li>
                                        <li><a href="{{ route('database.table.column.edit', [$database, $table, $item]) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('database.table.column.destroy', [$database, $table, $item]) }}'"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if($table->user_tracking)
                        <tr>
                            <td style="color:#ccc">0</td>
                            <td><i class="fa fa-columns"></i> created_by</td>
                            <td>
                                <span style="color: #666">
                                    bigIntegers | unsigned | foreign | users:id
                                </span>
                            </td>
                            <td style="color: #666">NULLABLE</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td style="color:#ccc">0</td>
                            <td><i class="fa fa-columns"></i> updated_by</td>
                            <td>
                                <span style="color: #666">
                                    bigIntegers | unsigned | foreign | users:id
                                </span>
                            </td>
                            <td style="color: #666">NULLABLE</td>
                            <td colspan="3"></td>
                        </tr>
                        @endif
                        @if($table->softdelete)
                        <tr>
                            <td style="color:#ccc">0</td>
                            <td><i class="fa fa-columns"></i> deleted_at</td>
                            <td>
                                <span style="color: #666">
                                    timestamp 
                                </span>
                            </td>
                            <td style="color: #666">NULLABLE</td>
                            <td colspan="3"></td>
                        </tr>
                        @endif
                        @if($table->timestamp)
                        <tr>
                            <td style="color:#ccc">0</td>
                            <td><i class="fa fa-columns"></i> created_at</td>
                            <td>
                                <span style="color: #666">
                                    timestamp 
                                </span>
                            </td>
                            <td style="color: #666">NULLABLE</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td style="color:#ccc">0</td>
                            <td><i class="fa fa-columns"></i> updated_at</td>
                            <td>
                                <span style="color: #666">
                                    timestamp 
                                </span>
                            </td>
                            <td style="color: #666">NULLABLE</td>
                            <td colspan="3"></td>
                        </tr>
                        @endif
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
                <h4 class="modal-title">Create Column</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('database.table.column.store', [$database, $table]) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('POST')
                    <span ng-init="type='{{ old('type') ?? App\Models\Column::get_laravel_default_type() }}'"></span>
                    <div class="row">
                        <div class="col-sm-6">
                            {!! BootForm::text('name', 'Column Name', old('name'), ['autofocus'=>true]) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! BootForm::select('type', 'Column Type', [''=>''] +App\Models\Column::get_laravel_types(), old('type') ?? App\Models\Column::get_laravel_default_type(), ['class'=>'select2', 'data-placeholder'=>'Select Column Type', 'ng-model'=>'type']) !!}
                        </div>
                    </div>
                    <div ng-show="type=='foreign'">
                        <div class="panel">
                            <div class="well">
                                <div class="row">
                                    <div class="col-sm-3">
                                        {!! BootForm::select('foreign_table_id', 'Foreign Table', [], old('foreign_table_id'), ['class'=>'select2', 'data-placeholder'=>'Select Foreign Table','data-model'=>'Table', 'data-text-field'=>'name', 'data-where-column'=>'database_id', 'data-where-value'=>$database->id]) !!}
                                    </div>
                                    <div class="col-sm-2">
                                        <span ng-init="select_id='1'"></span>
                                        {!! BootForm::radios('select_id', 'Foreign Column', ['1'=>'id', '0'=>'others'], '1', true, ['ng-model'=>'select_id']) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! BootForm::select('foreign_column_id', 'Choose other column', [], old('foreign_column_id'), ['class'=>'select2', 'data-placeholder'=>'Select Foreign Column','data-model'=>'Column', 'data-text-field'=>'name', 'data-dependent-element-id'=>'foreign_table_id', "ng-disabled"=>"select_id=='1'"]) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        {!! BootForm::radios('on_delete', 'On Delete', App\Models\Column::get_on_deletes(), App\Models\Column::get_default_on_delete(), false) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div ng-show="type=='enum' || type=='set'">
                        <div class="panel">
                            <div class="well">
                                {!! BootForm::text('length', ['html'=>'Enter Options <small>(separated with a comma)</small>'], old('length'), ['data-role'=>'tagsinput', 'placeholder'=>'option1, option2, option3']) !!}
                                {!! BootForm::checkbox('nullable', 'Nullable', 1, true, ['ng-model'=>'nullable']) !!}
                                {!! BootForm::text('default', 'Default Value', old('default'), ['ng-disabled'=>'nullable', 'placeholder'=>'Enter a option from above']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-if="type!='foreign' && type!='enum' && type!='set'">
                        <div class="col-sm-2">
                            {!! BootForm::hidden('nullable', 0, false) !!}
                            {!! BootForm::checkbox('nullable', 'Nullable', 1, true, ['ng-model'=>'nullable']) !!}
                        </div>
                        <div class="col-sm-2">
                            {!! BootForm::hidden('unique', 0, false) !!}
                            {!! BootForm::checkbox('unique', 'Unique', 1, false) !!}
                        </div>
                        <div class="col-sm-2" ng-show="type!='enum' && type!='set'">
                            {!! BootForm::hidden('unsigned', 0, false) !!}
                            {!! BootForm::checkbox('unsigned', 'Unsigned', 1, false) !!}
                        </div>
                    </div>
                    <div ng-show="type!='foreign' && type!='enum' && type!='set'">
                        <a ng-init="show_more=false" ng-show="!show_more" href="#" ng-click="show_more=true">Show more</a>
                        <a ng-show="show_more" href="#" ng-click="show_more=false">Hide</a>
                        <hr>
                    </div>
                    <div ng-show="show_more">
                        <div ng-if="type!='foreign' && type!='enum' && type!='set'">
                            {!! BootForm::text('length', 'Length/Value', old('name'), []) !!}
                            {!! BootForm::text('default', 'Default Value', old('default'), []) !!}
                            {!! BootForm::radios('attribute', 'Attribute', [''=> 'NULL'] + App\Models\Column::get_attributes(), '', true) !!}
                            {{-- {!! BootForm::radios('nullable', 'Nullable', ['1'=>'Yes', '0'=>'No',], 1, true) !!} --}}
                            {{-- {!! BootForm::radios('unique', 'Unique', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {{-- {!! BootForm::radios('primary', 'Primary', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {{-- {!! BootForm::radios('index', 'Index', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {{-- {!! BootForm::radios('auto_increament', 'Auto Increament', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {!! BootForm::radios('mme_type', 'MME Type', [''=> 'NULL'] + App\Models\Column::get_mme_types(), '', true) !!}
                            {!! BootForm::text('comment', 'Comments', old('comment'), []) !!}
                        </div>
                    </div>
                    {{-- {!! BootForm::radios('active', 'Status', ['1'=>'Active', '0'=>'Inactive',], 1, true) !!} --}}
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary btn-lg">Create Column</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="delete" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h4 class="modal-title">Delete Column</h4>
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
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-tagsinput.js') }}"></script>
<script>
    @if(count($errors) > 0)
    $('#create').modal('show')
    @endif
</script>
@endsection