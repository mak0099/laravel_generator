@extends('dashboard.layouts.master')
@section('style')
<link href="{{ asset('vendor/bootstrap-toggle/bootstrap-toggle.min.css') }}" rel="stylesheet">
<style>

</style>
@endsection
@section('content')

<div id="detail" class="modal custom-modal fade" role="dialog" ng-controller="myCtrl">
    <div class="modal-dialog">
        <form action="{{ URL::previous() }}">
            <button type="submit" class="close">&times;</button>
        </form>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title pull-left">Export Laravel Migrations (.zip)</h4>
                <div class="pull-right">
                    <a href="{{ route('database.index') }}" class="btn btn-primary"><i class="fa fa-database"></i> Manage Database</a>
                    <a href="{{ route('database.table.index', [$database]) }}" class="btn btn-info"><i class="fa fa-table"></i> Manage Tables</a>
                </div>
            </div>
            <div class="modal-body">
                <h3><i class="fa fa-database"></i> {{ $database->name }}</h3>
                <div style="margin: 25px auto">
                    <form action="{{ route('database.export', [$database]) }}" method="POST">
                        @csrf @method('POST')
                        <h4>Select Tables to export 
                            <input type="checkbox" class="pull-right" data-toggle="toggle" data-onstyle="primary" data-size="mini" data-on="All" data-off="Check All" onchange='openAll(this)'>
                        </h4>
                        @foreach($database->tables->where('active', true) as $table)
                        <div class="checkbox">
                            <label><input type="checkbox" name="tables[]" value="{{ $table->id }}"><i class="fa fa-table"></i> {{ $table->name }}</label>
                        </div>
                        @endforeach
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary btn-lg">Export</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('vendor/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <script>
        $('#detail').modal('show')
        app.controller('myCtrl', function($scope) {
            
        });
        function openAll(el){
            $('input:checkbox').not(el).prop('checked', el.checked);
        }
    </script>
@endsection