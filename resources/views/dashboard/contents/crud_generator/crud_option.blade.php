@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <h4 class="page-title">Create CRUD</h4>
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
		<form method="post" action="{{route('generate_crud', ['crud_id' => $crud->id])}}" class="form-horizontal">
			{{csrf_field()}}
			<div class="col-sm-3">
				<p><strong>Crud Name : </strong>{{$crud->crud_name}}</p>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-3 col-sm-6">
			    	<div class="checkbox">
			        	<label><input type="checkbox" name="model" checked> Model</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="Controller" checked> Controller</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="view" checked> Views</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="migration" checked> Migrations</label>
			        </div>
			    </div>
			</div> 
			<div class="col-sm-offset-3">
				<button type="submit" class="btn btn-success">Generate Crud</button>
			</div>
		</form>
	</div>
</div>
</div>
@endsection