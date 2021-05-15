@extends('dashboard.layouts.master')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <h4 class="page-title">Database Managements</h4>
        </div>
        <div class="col-xs-8 text-right m-b-20">
            <a href="#" class="btn btn-primary rounded pull-right" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i> Create Database</a>
            <div class="view-icons">
                <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table custom-table {{ config('dashboard.modules.database.use_datatable') ? 'datatable' : null }}">
                    <thead>
                        <tr>
                            <th style="width: 15px; color:#ccc">#</th>
                            <th colspan="3">Databases</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($database_list as $item)
                        <tr>
                            <td style="color:#ccc">{{ $loop->iteration }}</td>
                            <td>
                                <h3><a href="{{ route('database.table.index', $item) }}"><i class="fa fa-database"></i> {{ $item->name }}</a></h3>
                            </td>
                            <td style="width: 150px">
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o {{ $item->active ? 'text-success' : 'text-danger' }}"></i> {{ $item->active ? 'Active' : 'Inactive' }} <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="@if(!$item->active){{ route('change_activation',['model'=>'Database', 'id'=>$item->id, 'active'=>true]) }}@endif"><i class="fa fa-dot-circle-o text-success"></i> Active</a></li>
                                        <li><a href="@if($item->active){{ route('change_activation',['model'=>'Database', 'id'=>$item->id, 'active'=>false]) }}@endif"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td style="width:10px">
                                <div class="dropdown">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('database.show', $item) }}"><i class="fa fa-list m-r-5"></i> View Tables with Columns</a></li>
                                        <li><a href="{{ route('database.edit', $item) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
                                        <li><a href="{{ route('database.exportation', [$item]) }}"><i class="fa fa-download m-r-5"></i> Export</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('database.destroy', $item) }}'"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
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
                <h4 class="modal-title">Create Database</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('database.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    {!! BootForm::text('name', 'Database Name', old('name'), ['autofocus'=>'true']) !!}
                    {!! BootForm::hidden('user_table', 0, false) !!}
                    {!! BootForm::checkbox('user_table', 'USER Table', 1, old('user_table') ?? false, ['ng-model'=>'user_table']) !!}
                    {!! BootForm::hidden('user_permission', 0, false) !!}
                    {!! BootForm::checkbox('user_permission', 'USER Role/Permission (Spatie)', 1, old('user_permission') ?? false, ['ng-model'=>'user_permission', 'ng-disabled'=>'!user_table']) !!}
                    {!! BootForm::radios('active', 'Status', ['1'=>'Active', '0'=>'Inactive',], old('active') ?? 1, true) !!}
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary btn-lg">Create Database</button>
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
                <h4 class="modal-title">Delete Database</h4>
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
</script>
@endsection