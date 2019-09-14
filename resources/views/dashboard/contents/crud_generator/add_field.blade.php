@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <h4 class="page-title"><i class="fa {{$fa_icon ? $fa_icon : 'fa-circle-o'}}"></i> {{$crud_name}}</h4>
        </div>
        {{-- <div class="col-xs-8 text-right m-b-20">
            <a href="#" class="btn btn-primary rounded pull-right" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i> Create Mission</a>
            <div class="view-icons">
                <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table custom-table {{ config('dashboard.modules.mission.use_datatable') ? 'datatable' : null }}">
                    <thead>
						<tr>
							<th>Field Name</th>
							<th>HTML Type</th>
							<th>DB Type</th>
							<th>Searchable</th>
							<th>Fillable</th>
							<th>Primary</th>
							<th>In Form</th>
							<th>In Index</th>
							<th>In View</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php //dd(Session::get('fields')); 
							$fields = Session::get('fields');
						?>
						@isset($fields)
						@foreach($fields as $field)
						<tr>
							<td>{{$field['field_name']}}</td>
							<td>{{$field['html_type']}}</td>
							<td>{{$field['db_type']}}</td>
							<td>@isset($field['searchable']) <i class="fa fa-check text-success"></i> @else <i class="fa fa-times text-danger"></i> @endif </td>
							<td>@isset($field['fillable']) <i class="fa fa-check text-success"></i> @else <i class="fa fa-times text-danger"></i> @endif </td>
							<td>@isset($field['primary']) <i class="fa fa-check text-success"></i> @else <i class="fa fa-times text-danger"></i> @endif </td>
							<td>@isset($field['in_form']) <i class="fa fa-check text-success"></i> @else <i class="fa fa-times text-danger"></i> @endif </td>
							<td>@isset($field['in_index']) <i class="fa fa-check text-success"></i> @else <i class="fa fa-times text-danger"></i> @endif </td>
							<td>@isset($field['in_view']) <i class="fa fa-check text-success"></i> @else <i class="fa fa-times text-danger"></i> @endif </td>
							<td>
								<!-- <a href="" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit </a> -->
								<a href="{{route('delete_field_item', ['index' => $loop->index])}}" class="btn btn-default btn-xs"><i class="fa fa-trash"></i> Delete</a>
							</td>
						</tr>
						@endforeach
						@endisset
					</tbody>
				</table>
				<div class="text-center">
					<a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default">+ New</a>
				</div>
				<div class="pull-left">
					<a href="{{route('add_crud')}}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Previous</a>
				</div>
				<div class="pull-right">
					<a href="{{route('save_field')}}" class="btn btn-default">Next <i class="fa fa-chevron-right"></i></a>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
		<form method="post" action="{{route('save_field_item')}}" class="form-horizontal">
			{{csrf_field()}}
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Add new field</h4>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
				<label class="control-label col-sm-3">Field Name</label>
				<div class="col-sm-6">
					<input type="text" name="field_name" class="form-control" placeholder="Field Name" autofocus="">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">HTML Type</label>
				<div class="col-sm-6">
					<select class="form-control" name="html_type">
						<option>text</option>
						<option>number</option>
						<option>email</option>
						<option>password</option>
						<option>date</option>
						<option>textarea</option>
						<option>radio</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">DB Type</label>
				<div class="col-sm-6">
					<select class="form-control" name="db_type">
						<option>string</option>
						<option>integer</option>
						<option>date</option>
						<option>text</option>
						<option>double</option>
						<option>boolean</option>
						<option>tinyint</option>
					</select>
				</div>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-3 col-sm-3">
			        <div class="checkbox">
			        	<label><input type="checkbox" name="searchable" checked> Searchable</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="fillable" checked> Fillable</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="editable" checked> Editable</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="primary"> Primary</label>
			        </div>

			    </div>
			    <div class="col-sm-3">
			    	<div class="checkbox">
			        	<label><input type="checkbox" name="in_index" checked> In Index</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="in_form" checked> In Form</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="in_show" checked> In Show</label>
			        </div>
			    </div>
			</div> 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success">Save</button>
	      </div>
     	</form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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