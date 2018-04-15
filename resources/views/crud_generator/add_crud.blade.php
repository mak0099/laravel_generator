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
		<form method="post" action="{{route('save_crud')}}" class="form-horizontal">
			{{csrf_field()}}
			<div class="form-group">
				<label class="control-label col-sm-3">Crud Name</label>
				<div class="col-sm-6">
					<input type="text" name="crud_name" class="form-control" placeholder="Crud Name" autofocus="">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">Font-awesome Icon</label>
				<div class="col-sm-6">
					<input type="text" name="fa_icon" class="form-control" placeholder="fa-circle-o">
				</div>
			</div>
			<div class="form-group">
			    <div class="col-sm-offset-3 col-sm-6">
			        <div class="checkbox">
			        	<label><input type="checkbox" name="soft_delete" checked> Soft Delete</label>
			        </div>
			        <div class="checkbox">
			        	<label><input type="checkbox" name="data_table" checked> Data Table</label>
			        </div>
			    </div>
			    </div>
			</div> 
			<div class="col-sm-offset-3 col-sm-6">
				<button type="submit" class="btn btn-success">Next</button>
			</div>
		</form>
	</div>
</div>

@endsection