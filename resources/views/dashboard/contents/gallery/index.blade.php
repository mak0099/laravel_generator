@extends('dashboard.layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <h4 class="page-title">Gallery</h4>
        </div>
        <div class="col-xs-8 text-right m-b-20">
            <a href="#" class="btn btn-primary rounded pull-right" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i> Create Gallery</a>
            <div class="view-icons">
                <a href="#" class="grid-view btn btn-link"><i class="fa fa-th"></i></a>
                <a href="#" class="list-view btn btn-link active"><i class="fa fa-bars"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table custom-table {{ config('dashboard.modules.gallery.use_datatable') ? 'datatable' : null }}">
                    <thead>
                        <tr>
                            <th style="width: 15px">#</th>
                            <th>Gallery</th>
                            <th style="width: 100px">Featured</th>
                            <th style="width: 100px">Status</th>
                            <th style="width: 50px" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gallery_list as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="product-det">
                                    <img src="{{ asset($item->image_path ?? 'images/no-image.png') }}" alt="image" style="height: 50px; width: 50px; margin-top: -5px;">
                                    <div class="product-desc">
                                        <h2><a href="{{ route('gallery.show', $item) }}">{{ str_limit($item->title,60) }}</a></h2></div>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o {{ $item->featured ? 'text-success' : 'text-primary' }}"></i> {{ $item->featured ? 'Featured' : 'Normal' }} <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="@if(!$item->featured){{ route('change_feature',['model'=>'Gallery', 'id'=>$item->id, 'featured'=>true]) }}@endif"><i class="fa fa-dot-circle-o text-success"></i> Featured</a></li>
                                        <li><a href="@if($item->featured){{ route('change_feature',['model'=>'Gallery', 'id'=>$item->id, 'featured'=>false]) }}@endif"><i class="fa fa-dot-circle-o text-primary"></i> Normal</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown action-label">
                                    <a class="btn btn-white btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o {{ $item->active ? 'text-success' : 'text-danger' }}"></i> {{ $item->active ? 'Active' : 'Inactive' }} <i class="caret"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="@if(!$item->active){{ route('change_activation',['model'=>'Gallery', 'id'=>$item->id, 'active'=>true]) }}@endif"><i class="fa fa-dot-circle-o text-success"></i> Active</a></li>
                                        <li><a href="@if($item->active){{ route('change_activation',['model'=>'Gallery', 'id'=>$item->id, 'active'=>false]) }}@endif"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('gallery.show', $item) }}"><i class="fa fa-eye m-r-5"></i> View Detail</a></li>
                                        <li><a href="{{ route('gallery.edit', $item) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('gallery.destroy', $item) }}'"><i class="fa fa-trash-o m-r-5"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="create" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Create Gallery</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('gallery.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                        <label>Title <span class="text-danger">*</span></label>
                        <input name="title" class="form-control" type="text" value="{{ old('title') }}">
                        <small class="text-danger">{{ $errors->first('title') }}</small>
                    </div>
                    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                        <label>Image <span class="text-danger">*</span></label>
                        <input name="image" class="form-control" type="file" required>
                        <small>Max: {{ config('dashboard.modules.gallery.upload_max_file_size') }} KB</small>
                        <small class="text-danger">{{ $errors->first('image') }}</small>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Featured</label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        @php
                                            $featured_remain_count = \App\Models\Gallery::featured_remain_count();
                                        @endphp
                                        <input type="radio" name="featured" value="1" @if ($featured_remain_count <= 0) disabled @endif> Featured 
                                        @if ($featured_remain_count <= 0) 
                                        <small class="text-danger" title="Max feature item: {{ config('dashboard.modules.gallery.featured_max_item') }}">(Exceed limit)</small>
                                        @else 
                                        <small class="text-primary" title="Max feature item: {{ config('dashboard.modules.gallery.featured_max_item') }}">(Remain {{ $featured_remain_count }})</small>
                                        @endif
                                    </label>
                                        
                                        
                                    <label class="radio-inline">
                                        <input type="radio" name="featured" checked="checked" value="0"> Normal
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Active</label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="active" checked="checked" value="1"> Active
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="active" value="0"> Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary btn-lg">Create Gallery</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="delete" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header">
                <h4 class="modal-title">Delete Gallery</h4>
            </div>
            <div class="modal-body card-box">
                <p>Are you sure want to delete this?</p>
                <form action="@{{ delete_url }}" method="post">
                    @csrf @method('DELETE')
                    <div class="m-t-20"> <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
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