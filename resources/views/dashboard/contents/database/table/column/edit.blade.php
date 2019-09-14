@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')

<div id="edit" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('database.table.column.index', [$database, $table]) }}">
            <button type="submit" class="close">&times;</button>
        </form>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Edit Column</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('database.table.column.update', [$database, $table, $column]) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <span ng-init="type='{{ old('type') ?? $column->type }}'"></span>
                    @if($column->nullable)
                    <span ng-init="nullable=true"></span>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            {!! BootForm::text('name', 'Column Name', old('name') ?? $column->name, ['autofocus'=>true]) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! BootForm::select('type', 'Column Type', [''=>''] +App\Models\Column::get_laravel_types(), old('type') ?? $column->type, ['class'=>'select2', 'data-placeholder'=>'Select Column Type', 'ng-model'=>'type']) !!}
                        </div>
                    </div>
                    <div ng-show="type=='foreign'">
                        <div class="panel">
                            <div class="well">
                                <div class="row">
                                    <div class="col-sm-4">
                                        {!! BootForm::select('foreign_table_id', 'Foreign Table', [], old('foreign_table_id'), ['class'=>'select2', 'data-placeholder'=>'Select Foreign Table','data-model'=>'Table', 'data-text-field'=>'name']) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        {!! BootForm::select('foreign_column_id', 'Foreign Column', [], old('foreign_column_id'), ['class'=>'select2', 'data-placeholder'=>'Select Foreign Column','data-model'=>'Column', 'data-text-field'=>'name', 'data-dependent-element-id'=>'foreign_table_id']) !!}
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
                                {!! BootForm::text('length', ['html'=>'Enter Options <small>(separated with a comma)</small>'], old('length') ?? $column->length, ['data-role'=>'tagsinput', 'placeholder'=>'e.g: option1, option2']) !!}
                                {!! BootForm::checkbox('nullable', 'Nullable', 1, $column->nullable, ['ng-model'=>'nullable']) !!}
                                {!! BootForm::text('default', 'Default Value', old('default') ?? $column->default, ['ng-disabled'=>'nullable', 'placeholder'=>'Enter a option from above']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row" ng-if="type!='foreign' && type!='enum' && type!='set'">
                        <div class="col-sm-2">
                                {!! BootForm::hidden('nullable', 0, false) !!}
                                {!! BootForm::checkbox('nullable', 'Nullable', 1, old('nullable') ?? $column->nullable) !!}
                        </div>
                        <div class="col-sm-2">
                                {!! BootForm::hidden('unique', 0, false) !!}
                                {!! BootForm::checkbox('unique', 'Unique', 1, old('unique') ?? $column->unique) !!}
                        </div>
                        <div class="col-sm-2" ng-show="type!='enum' && type!='set'">
                                {!! BootForm::hidden('unsigned', 0, false) !!}
                                {!! BootForm::checkbox('unsigned', 'Unsigned', 1, old('unsigned') ?? $column->unsigned) !!}
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
                            {!! BootForm::radios('attribute', 'Attribute', [''=> 'NULL'] + App\Models\Column::get_attributes(), old('attribute') ?? $column->attribute, true) !!}
                        {{-- {!! BootForm::radios('nullable', 'Nullable', ['1'=>'Yes', '0'=>'No',], 1, true) !!} --}}
                            {{-- {!! BootForm::radios('unique', 'Unique', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {{-- {!! BootForm::radios('primary', 'Primary', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {{-- {!! BootForm::radios('index', 'Index', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {{-- {!! BootForm::radios('auto_increament', 'Auto Increament', ['1'=>'Yes', '0'=>'No',], 0, true) !!} --}}
                            {!! BootForm::radios('mme_type', 'MME Type', [''=> 'NULL'] + App\Models\Column::get_mme_types(), old('mme_type') ?? $column->mme_type, true) !!}
                            {!! BootForm::text('comment', 'Comments', old('comment') ?? $column->comment, []) !!}
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
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('#edit').modal('show')
    </script>
@endsection
