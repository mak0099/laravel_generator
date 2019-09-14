@extends('layout')
@section('title','Database Management')
@section('style')
<link href="{{asset('admin/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<!-- Row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Database Management</h6>
                </div>
                <div class="pull-right">
                    <a href="{{route('database-management.create')}}" class="btn btn-primary">Add New</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    @include('partials.messages')
                    <div class="table-wrap">
                        <div class="table-responsive">
                            <table id="datable_1" class="table table-hover display  pb-30" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
										
                                        <th>Action</th>
                                    </tr> 
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
										
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
										
                                        <td class="text-nowrap">
                                            <form action="{{route('database-management.destroy', ['id'=> $item->id])}}" method="post">
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                                <a href="{{route('database-management.show', ['id'=> $item->id])}}" class="mr-25" data-toggle="tooltip" data-original-title="Show"> <i class="fa fa-eye text-inverse m-r-10"></i> </a> 
                                                <a href="{{route('database-management.edit', ['id'=> $item->id])}}" class="mr-25" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a> 
                                                <button type="submit" data-toggle="tooltip" data-original-title="Delete" class="btn-link" onclick="return confirm('Are you sure to delete this?')"> <i class="fa fa-close text-danger"></i> </button> 
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>
<!-- /Row -->
@endsection
@section('script')
<!-- Data table JavaScript -->
<script src="{{asset('admin/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script>
$(document).ready(function () {
    $('#datable_1').DataTable();
});
</script>
@endsection