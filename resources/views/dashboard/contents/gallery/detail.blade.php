@extends('dashboard.layouts.master')
@section('style')
@endsection
@section('content')

<div id="detail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('gallery.index') }}">
                <button type="submit" class="close">&times;</button>
            </form>
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">Gallery Detail
                        <a href="#" class="btn btn-danger rounded pull-right" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('gallery.destroy', $gallery) }}'"><i class="fa fa-trash"></i> Delete</a>
                        <a href="{{ route('gallery.edit', $gallery) }}" class="btn btn-primary rounded pull-right"><i class="fa fa-edit"></i> Edit</a>
                    </h4>
                    
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" class="form-control" type="text" value="{{ $gallery->title }}" readonly>
                </div>
                <div class="form-group">
                    @if($gallery->image_path)
                    <label>Image</label>
                    <div>
                        <img src="{{ asset($gallery->image_path) }}" alt="image" style="height: auto; max-width: 100%; border: 2px solid #ddd; margin: 2px 0;">
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Featured</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="featured" {{ $gallery->featured ? 'checked' : null }} value="1" disabled> Featured
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="featured"  {{ !$gallery->featured ? 'checked' : null }} value="0" disabled> Normal
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Active</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="active"  {{ $gallery->active ? 'checked' : null }} value="1" disabled> Active
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="active" {{ !$gallery->active ? 'checked' : null }} value="0" disabled> Inactive
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script>
        $('#detail').modal('show')
    </script>
@endsection