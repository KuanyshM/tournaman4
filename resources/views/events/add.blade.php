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

        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-body">

                    <h5 class="card-title">About the tournament</h5>
                    <div class="mb-3">
                        <label>Title</label>
                        <input required type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label> Description</label>
                        <textarea required name="body" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select required name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Upload photo (2MB)</label><br>
                        <input onchange="checkSize()" required name="photo" type="file" class="form-control-file" >
                    </div>
<hr>
                    <h5 class="card-title">Quick details</h5>
                    <div class="form-control mb-3">
                        <label>Registration start date</label><br>
                        <input required name="reg_start_date" type="datetime-local">
                    </div>
                    <div class="form-control mb-3">
                        <label>Registration end date</label><br>
                        <input required name="reg_end_date" type="datetime-local">
                    </div>
                    <div class="form-control mb-3">
                        <label>Event Start date</label><br>
                        <input required name="start_date" type="datetime-local">
                    </div>
                    <div class="form-control mb-3">
                        <label>Event end date</label><br>
                        <input required name="end_date" type="datetime-local">
                    </div>
                    <div class="mb-3">
                        <label>Number of teams/participants</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input required type="number" min="1"  name="numberof_participants" class="form-control"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" required name="address"  class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Age Restriction</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label>From</label>
                                <input required type="number" min=1 max=150 name="age_from" class="form-control"></div>
                            <div class="col-md-4">
                                <label>To</label>
                                <input required type="number" min="1"  max="150"  name="age_to" class="form-control"></div>
                            </div>
                    </div>
                    <div class="mb-3">
                        <label>Format</label>
                        <select required name="format_id" class="form-control">
                            <option value="1">
                                Live Event
                            </option>
                            <option value="2">
                                Online Event
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>FAQ</label>
                        <textarea name="faq" class="form-control"></textarea>
                    </div>


                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Add Event">
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
