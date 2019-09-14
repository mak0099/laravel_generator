@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')

<div id="edit" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="{{ URL::previous() }}">
            <button type="submit" class="close">&times;</button>
        </form>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Edit Database</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('database.update', $database) }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    {!! BootForm::text('name', 'Database Name', old('name') ?? $database->name, ['autofocus'=>'true']) !!}
                    {!! BootForm::radios('active', 'Status', ['1'=>'Active', '0'=>'Inactive',], old('active') ?? $database->active, true) !!}
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary btn-lg">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $('#edit').modal('show')
    </script>
@endsection
