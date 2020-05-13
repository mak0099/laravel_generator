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
                <h4 class="modal-title">API CRUD
                    {{-- <a href="#" class="btn btn-danger rounded pull-right" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('database.table.column.destroy', [$database, $table, $column]) }}'"><i class="fa fa-trash"></i> Delete</a> --}}
                    {{-- <a href="{{ route('database.table.column.edit', [$database, $table, $column]) }}" class="btn btn-primary rounded pull-right"><i class="fa fa-edit"></i> Edit</a> --}}
                </h4>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{ route('database.table.export_api_crud', [$database, $table]) }}" method="post">
                            @csrf @method('POST')
                            <h5><i class="fa fa-table"></i> {{ $table->name }}</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 15px; color:#ccc">#</th>
                                        <th colspan="4">Columns</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach ($table->columns as $item)
                                    <tr>
                                        <td style="color:#ccc">{{ $loop->iteration }}</td>
                                        <td>
                                            <a href=""><i class="fa fa-columns"></i> {{ $item->name }}</a> 
                                        </td>
                                        <td>
                                            <span style="color: #666"> 
                                                {{ $item->type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span style="color: #666"> 
                                                {{ !$item->nullable? 'NOT NULL':null }}  
                                            </span> 
                                        </td>
                                        <td>
                                            <span style="color: #666"> 
                                                {{ $item->unique? 'UNIQUE':null }}  
                                            </span> 
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="m-t-20 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Export API CRUD</button>
                            </div>
                        </form>
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