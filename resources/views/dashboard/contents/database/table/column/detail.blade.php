@extends('dashboard.layouts.master')
@section('style')
@endsection
@section('content')

<div id="detail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('database.table.column.index', [$database, $table]) }}">
            <button type="submit" class="close">&times;</button>
        </form>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Database Management Detail
                    <a href="#" class="btn btn-danger rounded pull-right" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('database.table.column.destroy', [$database, $table, $column]) }}'"><i class="fa fa-trash"></i> Delete</a>
                    <a href="{{ route('database.table.column.edit', [$database, $table, $column]) }}" class="btn btn-primary rounded pull-right"><i class="fa fa-edit"></i> Edit</a>
                </h4>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        {!! BootForm::text('name', 'Column Name', $column->name, ['readonly'=>true]) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! BootForm::text('type', 'Column Type', $column->type, ['readonly'=>true]) !!}
                    </div>
                </div>
                @if($column->type == 'foreign')
                    {!! BootForm::text('foreign_table_id', 'Foreign Table', $column->foreign_table->name, ['readonly'=>true]) !!}
                    {!! BootForm::text('foreign_column_id', 'Foreign Column', $column->foreign_column->name,['readonly'=>true]) !!}
                    {!! BootForm::text('on_delete', 'On Delete',  $column->on_delete, ['readonly'=>true]) !!}
            
                @endif
                @if($column->type == 'enum' || $column->type == 'set')
                    {!! BootForm::text('length', 'Options', $column->length, ['readonly'=>true]) !!}
                    {!! BootForm::checkbox('nullable', 'Nullable', 1, $column->nullable, ['disabled'=>'disabled']) !!}
                    {!! BootForm::text('default', 'Default Value', $column->default, ['readonly'=>true]) !!}
            
                @endif
                @if($column->type != 'foreign' && $column->type != 'enum' && $column->type != 'set')
                    <div class="row">
                        <div class="col-sm-2">
                                {!! BootForm::checkbox('nullable', 'Nullable', 1, $column->nullable, ['disabled'=>'disabled']) !!}
                        </div>
                        <div class="col-sm-2">
                                {!! BootForm::checkbox('unique', 'Unique', 1, $column->unique, ['disabled'=>'disabled']) !!}
                        </div>
                        <div class="col-sm-2">
                                {!! BootForm::checkbox('unsigned', 'Unsigned', 1, $column->unsigned, ['disabled'=>'disabled']) !!}
                        </div>
                    </div>
                    {!! BootForm::text('length', 'Length/Value', $column->length, ['readonly'=>true]) !!}
                    {!! BootForm::text('default', 'Default Value', $column->default, ['readonly'=>true]) !!}
                    {!! BootForm::text('attribute', 'Attribute', $column->attribute, ['readonly'=>true]) !!}
                    {!! BootForm::text('mme_type', 'MME Type', $column->mme_type, ['readonly'=>true]) !!}
                    {!! BootForm::text('comment', 'Comments', $column->comment, ['readonly'=>true]) !!}
                @endif
            </div>
        </div>
    </div>
</div>
<div id="delete" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content modal-md">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Database Management</h4>
                </div>
                <div class="modal-body card-box">
                    <p>Are you sure want to delete this?</p>
                    <form action="@{{ delete_url }}" method="post">
                        @csrf @method('DELETE')
                        <div class="m-t-20"> <a href="#" class="btn btn-default" data-toggle="modal" data-target="#detail">Close</a>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#detail').modal('show')
    </script>
@endsection