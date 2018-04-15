@extends('layout')

@section('content_header')
<h1>
    Crud Generator
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('index')}}"><i class="fa fa-home"></i> Home</a></li>
    <li class="active">Crud Generator</li>
</ol>
@endsection

@section('content')
<div class="row">
	<div class="col-sm-12">
		@include('partials/messages')
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

@endsection