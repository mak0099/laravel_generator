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
<a href="{{route('add_crud')}}" class="btn btn-success">add new</a>

@endsection