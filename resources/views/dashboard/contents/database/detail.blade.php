@extends('dashboard.layouts.master')
@section('style')
<link href="{{ asset('vendor/bootstrap-toggle/bootstrap-toggle.min.css') }}" rel="stylesheet">
<style>
.panel-title > a:before {
    float: right !important;
    font-family: FontAwesome;
    content:"\f068";
    padding-right: 5px;
}
.panel-title > a.collapsed:before {
    float: right !important;
    content:"\f067";
}
.panel-title > a:hover, 
.panel-title > a:active, 
.panel-title > a:focus  {
    text-decoration:none;
}
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
                <h4 class="modal-title pull-left">Database Detail</h4>
                <div class="pull-right">
                    <a href="{{ route('database.edit', [$database]) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Database</a>
                    <a href="{{ route('database.table.index', [$database]) }}" class="btn btn-info"><i class="fa fa-table"></i> Manage Tables</a>
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle" aria-expanded="false">Export Database <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('database.exportation', [$database]) }}">Laravel Migration</a></li>
                            <li><a href="#">SQL File</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Under Construction</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <h3><i class="fa fa-database"></i> {{ $database->name }}
                    <input type="checkbox" class="pull-right" data-toggle="toggle" data-style="android" data-onstyle="primary" data-size="mini" data-on="Open All" data-off="Close All" onchange='openAll(this)'>
                </h3>
                <div class="panel-group" id="accordion">
                    @foreach($database->tables->where('active', true) as $item)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" class="collapsed" href="#{{ $item->name }}"><i class="fa fa-table"></i> {{ $item->name }}</a>
                            </h4>
                        </div>
                        <div id="{{ $item->name }}" class="panel-collapse collapse multi-collapse">
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 15px; color:#ccc">#</th>
                                            <th colspan="4">Columns</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @foreach ($item->columns as $item)
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
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> 
            </div>
        </div>
    </div>
</div>
<div id="delete" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h4 class="modal-title">Delete Database</h4>
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
<script src="{{ asset('vendor/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <script>
        $('#detail').modal('show')
        app.controller('myCtrl', function($scope) {
            
        });
        function openAll(el){
            if(el.checked){
                // $('.panel-collapse').each(function(){
                //     $(this).addClass('in');
                //     $('.panel-title > a').removeClass('collapsed');
                // })
                $('.panel-collapse').collapse('show');
                    $('.panel-title').attr('data-toggle', '');
            }else{
                // $('.panel-collapse').each(function(){
                //     $(this).removeClass('in');
                //     $('.panel-title > a').addClass('collapsed');
                // })
                $('.panel-collapse').collapse('hide');
                    $('.panel-title').attr('data-toggle', 'collapse');
            }
        }
    </script>
@endsection