<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Video</title>
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


        <form id="videoForm" action="{{ url('/events/createVideo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card mb-3 tab-content">
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Название</label>
                                <input placeholder="Be clear and descriptive"  type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Описание</label>
                                <input placeholder="Be clear and descriptive"  type="text" name="body" id="body" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Ссылка на видео</label>
                                <input onchange="getYouTubeVideoId()" placeholder="Be clear and descriptive"  type="text" name="linkTemp" id="linkTemp" class="form-control">
                                <input type="hidden" id="link" name ="link">
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Жанр</label>
                                        <select onchange="setCategories('parentCategory','subCategory',{{$subCategories}})" id="parentCategory"  name="category_id" class="form-control">
                                            <option selected disabled value="0">
                                                Выбрать
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category['id'] }}">
                                                    {{ $category['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Категорий</label>
                                        <select id="subCategory"  name="sub_category_id" class="form-control">
                                            <option selected disabled value="0">
                                                Выбрать
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Preview</label>
                                <img id="videoImage" src="">
                            </div>
                        </div>
                    </div>

                </div>
{{--
                <div class="tab-pane fade" id="publish" role="tabpanel" aria-labelledby="contact-tab">publish</div>
--}}
            </div>


        </form>
            <input onclick="videoValidation()"  class="btn btn-primary" value="Add Event">

    </div>
@endsection
</body>
</html>

