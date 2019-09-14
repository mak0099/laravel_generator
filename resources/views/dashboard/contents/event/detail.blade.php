@extends('dashboard.layouts.master')
@section('style')
@endsection
@section('content')

<div id="detail" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="{{ route('event.index') }}">
                <button type="submit" class="close">&times;</button>
            </form>
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">Event Detail
                        <a href="#" class="btn btn-danger rounded pull-right" data-toggle="modal" data-target="#delete" ng-click="delete_url = '{{ route('event.destroy', $event) }}'"><i class="fa fa-trash"></i> Delete</a>
                        <a href="{{ route('event.edit', $event) }}" class="btn btn-primary rounded pull-right"><i class="fa fa-edit"></i> Edit</a>
                    </h4>
                    
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Event Title</label>
                    <input name="title" class="form-control" type="text" value="{{ $event->title }}" readonly>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="5" cols="5" class="form-control summernote" placeholder="Enter your description here" readonly>{{ $event->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Vanue</label>
                    <input name="vanue" class="form-control" type="text" value="{{ $event->vanue }}" readonly>
                </div>
                <div class="form-group">
                    <label>Google Map URL</label>
                    <input name="google_map_url" class="form-control" type="text" value="{{ $event->google_map_url }}" readonly>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event Start Date</label>
                            <div class="cal-icon">
                                <input name="start_date" class="form-control" type="text" value="{{ optional($event->start_date)->format(config('dashboard.input_date_format')) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Event End Date</label>
                            <div class="cal-icon">
                                <input name="end_date" class="form-control" type="text" value="{{ optional($event->end_date)->format(config('dashboard.input_date_format')) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    @if($event->image_path)
                    <label>Image</label>
                    <div>
                        <img src="{{ asset($event->image_path) }}" alt="image" style="height: auto; max-width: 100%; border: 2px solid #ddd; margin: 2px 0;">
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Featured</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="featured" {{ $event->featured ? 'checked' : null }} value="1" disabled> Featured
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="featured"  {{ !$event->featured ? 'checked' : null }} value="0" disabled> Normal
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Active</label>
                            <div class="col-md-9">
                                <label class="radio-inline">
                                    <input type="radio" name="active"  {{ $event->active ? 'checked' : null }} value="1" disabled> Active
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="active" {{ !$event->active ? 'checked' : null }} value="0" disabled> Inactive
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
                    <h4 class="modal-title">Delete Event</h4>
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