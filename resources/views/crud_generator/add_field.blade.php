@extends('layout')

@section('content_header')
<h1>
    Crud Generator
    <small>Add Fields</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('index')}}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Crud Generator</li>
</ol>
@endsection

@section('content')
    	@include('partials/messages')
    	<h5>
    		<i class="fa {{$fa_icon ? $fa_icon : 'fa-circle-o'}}"></i> {{$crud_name}}
    	</h5>
<table class="table table-striped table-bordered">
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