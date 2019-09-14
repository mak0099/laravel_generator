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
					<input type="text" name="fa_icon" class="form-control" placeholder="fa-circle-o" value="{{ old('fa_icon') }}">
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