@php
    // dd($errors);
@endphp
@extends('dashboard.layouts.master')
@section('style')
<style>
.profile-bg {
    background: url(@php echo asset($user->image_path ?? 'assets/img/user.jpg') @endphp);
    background-size: cover;
    height: 141px;
    color: #fff;
    padding: 20px;
}
</style>
@endsection
@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="profile-widget profile-widget3">
                <div class="profile-bg blur"></div>
                <div>
                    <a href="#" class="avatar-link">
                        <img alt="" src="{{ asset($user->image_path ?? 'assets/img/user.jpg') }}">
                    </a>
                    <div class="user-info">
                        <div class="username">
                            <a href="">{{ $user->name }}</a>
                        </div>
                        <span>
                            <a href="">@<span>{{ $user->username }}</span></a>
                        </span>
                        <div class="pull-right" style="transform: translate(-5px,-10px)">
                            <a href="#" class="btn btn-sm btn-primary rounded" data-toggle="modal" data-target="#edit_profile"><i class="fa fa-edit"></i> Edit Profile</a>
                            <a href="#" class="btn btn-sm btn-info rounded" data-toggle="modal" data-target="#change_password"><i class="fa fa-key"></i> Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="panel">
                <div class="well">
                    <div class="form-group">
                        <label>Name</label>
                        <input name="name" class="form-control" type="text" value="{{ $user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input name="username" class="form-control" type="text" value="{{ $user->username }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" class="form-control" type="email" value="{{ $user->email }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="edit_profile" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profile</h4>
            </div>
            <div class="modal-body">
                    <form action="{{ route('update_profile') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label>Name <span class="text-danger">*</span></label>
                            <input name="name" class="form-control" type="text" value="{{ old('name') ?? $user->name }}">
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>
                        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                            <label>Username <span class="text-danger">*</span></label>
                            <input name="username" class="form-control" type="text" value="{{ old('username') ?? $user->username }}">
                            <small class="text-danger">{{ $errors->first('username') }}</small>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>Email </label>
                            <input name="email" class="form-control" type="text" value="{{ old('email') ?? $user->email }}">
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>
                        <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                            @if($user->image_path)
                            <div>
                                <img src="{{ asset($user->image_path) }}" alt="image" style="height: 100px; width: 100px; border: 2px solid #ddd; margin: 2px 0;">
                            </div>
                            @endif
                            <label>Image</label>
                            <input name="image" class="form-control" type="file">
                            <small>Max: {{ config('dashboard.modules.profile.upload_max_file_size') }} KB</small>
                            <small class="text-danger">{{ $errors->first('image') }}</small>
                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary btn-lg">Save Changes</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
<div id="change_password" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                        <form action="{{ route('update_password') }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
                                <label>Current Password <span class="text-danger">*</span></label>
                                <input name="current_password" class="form-control" type="password">
                                <small class="text-danger">{{ $errors->first('current_password') }}</small>
                            </div>
                            <div class="form-group {{ $errors->has('new_password') ? ' has-error' : '' }}">
                                <label>New Password <span class="text-danger">*</span></label>
                                <input name="new_password" class="form-control" type="password">
                                <small class="text-danger">{{ $errors->first('new_password') }}</small>
                            </div>
                            <div class="form-group {{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                <label>Confirm New Password <span class="text-danger">*</span></label>
                                <input name="new_password_confirmation" class="form-control" type="password">
                                <small class="text-danger">{{ $errors->first('new_password_confirmation') }}</small>
                            </div>
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
<script>
        @if($errors->has('current_password') || $errors->has('new_password'))
        $('#change_password').modal('show')
        @elseif(count($errors) > 0)
        $('#edit_profile').modal('show')
        @endif
    </script>
@endsection
