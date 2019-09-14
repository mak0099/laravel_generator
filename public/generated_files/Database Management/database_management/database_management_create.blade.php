@extends('layout')
@section('title','Database Management')
@section('style')


@endsection
@section('content')
<!-- Row -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Add Database Management</h6>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="form-wrap">
                        @include('partials.messages')
                        <form action="{{route('database-management.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

                           
                            <div class="form-group mb-0">
                                <a href="{{route('database-management.index')}}" class="btn btn-default">Cancel</a>
                                <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Save</span></button>
                            </div>	
                        </form>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>
<!-- /Row -->
@endsection
@section('script')

@endsection