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
            <h2 class="pb-3 card-title">Create Tournament</h2>
            <div onclick="valiAlertClose()" style="display: none" id="valiAlert" class="alert alert-warning" role="alert">
            </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Basick info</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="prize-tab" data-bs-toggle="tab" data-bs-target="#prize" type="button" role="tab" aria-controls="prize" aria-selected="false">Prize</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="registration-tab" data-bs-toggle="tab" data-bs-target="#registration" type="button" role="tab" aria-controls="registration" aria-selected="false">Registration</button>
                </li>
{{--                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="publish-tab" data-bs-toggle="tab" data-bs-target="#publish" type="button" role="tab" aria-controls="publish" aria-selected="false">Publish</button>
                </li>--}}
            </ul>

        <form id="trnmForm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card mb-3 tab-content">
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Tournament Title</label>
                                <input placeholder="Be clear and descriptive"  type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Orgnizer</label>
                                @if($author->organization)
                                    <p>
                                        <button id="organization" onclick="redirect('/organizations/'+{{$author->organization->id}})" type="button" class="mt-2 btn btn-outline-secondary">{{$author->organization->name}}</button>
                                    </p>
                                @else
                                    <p>
                                        <a href="{{url('organizations/create')}}">You need add organization</a>
                                    </p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Faction</label>
                                        <select onchange="setCategories('parentCategory','subCategory',{{$subCategories}})" id="parentCategory"  name="category_id" class="form-control">
                                            <option selected disabled value="0">
                                                Select
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category['id'] }}">
                                                    {{ $category['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Category</label>
                                        <select id="subCategory"  name="sub_category_id" class="form-control">
                                            <option selected disabled value="0">
                                                Select
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Scope</label>
                                        <select  id="scope"  name="scope" class="form-control">
                                            <option value="1">Local</option>
                                            <option value="2">State</option>
                                            <option value="3">Natioanal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-control mb-3">
                                <label>Event Start date</label><br>
                                <input  id="start_date" name="start_date" type="datetime-local">
                            </div>
                            <div class="form-control mb-3">
                                <label>Event end date</label><br>
                                <input id="end_date"  name="end_date" type="datetime-local">
                            </div>
                            <div class="form-control mb-3">
                                <label>Location</label><br>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="home" aria-selected="true">Venue</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#online" type="button" role="tab" aria-controls="profile" aria-selected="false">Online Tournament</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#announce" type="button" role="tab" aria-controls="contact" aria-selected="false">To be announced</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-9">
                                                    <label>Venue name</label>
                                                    <input type="text"  name="venue" id="venue"  class="form-control">
                                                </div>
                                            </div>
                                            <label class="mb-4 mt-4">Street Address</label>
                                            <div class="mb-4 col-md-6">
                                                <input placeholder="Address" type="text" id="addressName"   name="address"  class="form-control">
                                            </div>
                                            <div class=" mb-4 col-md-6">
                                                <input id="cityName" placeholder="City" type="text" id="city" onkeyup="searchCity()"  name="city"  class="form-control">
                                                <div class="dropdown">
                                                    <div id="myDropdown" class="dropdown-content">
                                                        <p onclick="selectCity()">City name <div class="small">Country </div></p>
                                                        <p onclick="selectCity()">City name</p>
                                                        <p>Name</p>
                                                        <p>Mame</p>
                                                        <p>44</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="online" role="tabpanel" aria-labelledby="online-tab">
                                        <div class="mb-3">
                                            <div class="form-group">
                                                <label class="mb-3" for="exampleFormControlTextarea1">Add Zoom Links (or other services)</label>
                                                <textarea name="links" id="links" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="announce" role="tabpanel" aria-labelledby="announce-tab">
                                        <div class="mb-3">
                                            <input id="announceInput" placeholder="Some text" type="text" name="announceInput" name="announce"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card mb-3 tab-content">
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Main Tournament Image</label>
                                <p class="small">This is the first image participants will see at the top of your listing. Use a high quality image: 2160x1080px (2:1 ratio).</p>

                                <input onchange="checkSize()" id="photo"  name="photo" type="file" class="form-control-file" >
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label> About the tournament</label>
                                <p class="small">
                                    Add short description explaining about your tournament. Why are you organizing this tournament and a little history.
                                </p>
                                <textarea  name="body" id="body" class="form-control"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label>Schedule</label>
                                <p class="small">
                                    Let your participants know what the schedule of the tournament is going to be.
                                </p>
                                <textarea id="schedule"  name="schedule" class="form-control"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label>Rules</label>
                                <p class="small">
                                    Add your rules about the tournament and let participants know how the tournament is run.
                                </p>
                                <textarea id="rules" name="rules" class="form-control"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label>FAQs</label>
                                <p class="small">
                                    Help your participants answer their most frequent asked questions (if they have).                                </p>
                                <textarea id="faq" name="faq" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="prize" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="card mb-3 tab-content">
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Prize</label>
                                <p class="small">
                                    Explain about your scholarships and privileges and how it is distributed to winners of the tournament.
                                </p>
                                <textarea id="prizeText"  name="prize" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="registration" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="form-control mb-3">
                        <label>Registration start date</label><br>
                        <input id="reg_start_date"  name="reg_start_date" type="datetime-local">
                    </div>
                    <div class="form-control mb-3">
                        <label>Registration end date</label><br>
                        <input id="reg_end_date"  name="reg_end_date" type="datetime-local">
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input  type="number" min=0 max=9999 name="price" id="price" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Age Restriction</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label>From</label>
                                <input  type="number" min=1 max=150 name="age_from" id="age_from" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>To</label>
                                <input  type="number" min="1"  max="150"  name="age_to" id="age_to" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Number of teams/participants</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input required type="number" min="1"  name="numberof_participants" class="form-control"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Participant type</label>
                        <select id="subCategory"  name="eventType" class="form-control">
                            <option  value="1">
                                User
                            </option>
                            <option  value="1">
                                Team
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label> Registration info</label>
                        <p class="small">
                        </p>
                        <textarea id="registration_info"  name="registration_info" class="form-control"></textarea>
                    </div>
                </div>
{{--
                <div class="tab-pane fade" id="publish" role="tabpanel" aria-labelledby="contact-tab">publish</div>
--}}
            </div>


        </form>
            <input onclick="tournamentValidation()"  class="btn btn-primary" value="Add Event">

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
