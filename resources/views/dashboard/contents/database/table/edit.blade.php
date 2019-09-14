@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')

<div id="edit" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('table.index') }}">
            <button type="submit" class="close">&times;</button>
        </form>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Edit Table</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('database.table.update', [$database, $table]) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    {!! BootForm::text('name', 'Table Name', old('name') ?? $database->name, ['autofocus'=>'true']) !!}
                    <div class="form-group">
                        <label class="control-label">Initialize Columns</label>
                        @if($table->user_tracking) 
                        <span ng-init="user_tracking=true"></span>
                        @endif
                        @if(old('user_tracking')) 
                        <span ng-init="user_tracking=true"></span>
                        @endif
                        {!! BootForm::hidden('auto_increament', 0, false) !!}
                        {!! BootForm::checkbox('auto_increament', 'AUTO INCREAMENT ID (id)', 1, old('auto_increament') ?? $table->auto_increament) !!}
                        {!! BootForm::hidden('user_tracking', 0, false) !!}
                        {!! BootForm::checkbox('user_tracking', 'USER TRACKING (created_by, updated_by)', 1, old('user_tracking') ?? $table->user_tracking, ['ng-model'=>'user_tracking']) !!}
                        <div class="panel" ng-show="user_tracking">
                            <div class="well">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {!! BootForm::select('foreign_table_id', 'Select User Table', [], old('foreign_table_id'), ['class'=>'select2', 'data-placeholder'=>'Select Foreign Table','data-model'=>'Table', 'data-text-field'=>'name']) !!}
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
                        <button class="btn btn-primary btn-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('#edit').modal('show')
    </script>
@endsection
