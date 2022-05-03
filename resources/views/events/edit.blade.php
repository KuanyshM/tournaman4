<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Events</title>
</head>
<body>
@extends('layouts.app')

@section('content')
    <div class="container">

        @if ($errors->any())
            <div class="alert alert-warning">
                <ol>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ol>
            </div>
        @endif

        <form action="{{url('/events/update/'.$event->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">

                    <h5 class="card-title">About the tournament</h5>
                    <div class="mb-3">
                        <label>Title</label>
                        <input value="{{ $event->title }}" required type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label> Description</label>
                        <textarea required name="body" class="form-control">{{ $event->body }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select required name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option @if($category->id==$event->category_id) selected @endif value="{{ $category['id'] }}">
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <img height="180" width="286" class="border border-1 border-secondary" src="{{url("images/$event->photo")}}" >
                        <br>
                        <label>Upload photo (2MB)</label><br>
                        <input value="{{url("images/$event->photo")}}" onchange="checkSize()"  name="photo" type="file" class="form-control-file" >
                    </div>
<hr>
                    <h5 class="card-title">Quick details</h5>
                    <div class="form-control mb-3">
                        <label>Registration start date</label><br>
                        <input value="{{$event->getDateTime($event->reg_start_date)}}" required name="reg_start_date" type="datetime-local">
                    </div>
                    <div class="form-control mb-3">
                        <label>Registration end date</label><br>
                        <input value="{{$event->getDateTime($event->reg_end_date)}}" required name="reg_end_date" type="datetime-local">
                    </div>
                    <div class="form-control mb-3">
                        <label>Event Start date</label><br>
                        <input value="{{$event->getDateTime($event->start_date)}}" required name="start_date" type="datetime-local">
                    </div>
                    <div class="form-control mb-3">
                        <label>Event end date</label><br>
                        <input value="{{$event->getDateTime($event->end_date)}}" required name="end_date" type="datetime-local">
                    </div>
                    <div class="mb-3">
                        <label>Number of teams/participants</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input value="{{$event->numberof_participants}}" required type="number" min="1"  name="numberof_participants" class="form-control"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <input value="{{$event->address}}" type="text" required name="address"  class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input value="{{$event->price}}" required type="number" min=0 max=9999 name="price" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Age Restriction</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label>From</label>
                                <input value="{{$event->age_from}}" required type="number" min=1 max=150 name="age_from" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>To</label>
                                <input value="{{$event->age_to}}" required type="number" min="1"  max="150"  name="age_to" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Format</label>
                        <select required name="format_id" class="form-control">
                            <option @if($event->format_id==1) selected @endif value="1">
                                Live Event
                            </option>
                            <option @if($event->format_id==2) selected @endif value="2">
                                Online Event
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>FAQ</label>
                        <textarea name="faq" class="form-control">{{ $event->faq }}</textarea>
                    </div>


                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Update Event">
        </form>
    </div>
@endsection
</body>
</html>
<script type="application/javascript">
    function checkSize(){
        var uploadField = document.getElementById("photoInput");
        if(uploadField.files[0].size > 2048000){
            alert("File is too big! "+uploadField.files[0].size/1024+" MB");
            uploadField.value = "";
        };
    }


</script>
