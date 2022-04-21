@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">Create organization
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('organizations.index') }}">Organizations</a>
                </span>
            </div>

            <div class="card-body">
                {!! Form::open(array('route' => 'organizations.store', 'method'=>'POST')) !!}
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <strong>Description:</strong>
                        {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control')) !!}
                    </div>
                {!! Form::open(array('route' => 'organizations.store', 'method'=>'POST')) !!}
                <div class="form-group">
                    <strong>Facebook:</strong>
                    {!! Form::text('facebook', null, array('placeholder' => 'Facebook','class' => 'form-control')) !!}
                </div>
                {!! Form::open(array('route' => 'organizations.store', 'method'=>'POST')) !!}
                <div class="form-group">
                    <strong>Twitter:</strong>
                    {!! Form::text('twitter', null, array('placeholder' => 'Twitter','class' => 'form-control')) !!}
                </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
