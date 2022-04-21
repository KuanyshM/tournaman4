
    @extends("layouts.app")

    @section("content")
        <div class="container">

            @if (session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
                <div class="card mb-2">
                    <div class="card-body  row">
                        <ul class="nav nav-tabs ">
                            <li class="nav-item">
                                <a class="nav-link @php if(!isset($activeCategoryID)){echo " active ";} @endphp" aria-current="page" href="{{url("events/")}}">All</a>
                            </li>
                            @foreach($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link @php if(isset($activeCategoryID) && $activeCategoryID == $category->id){echo " active ";} @endphp" href="{{url("events/category/$category->id")}}">{{$category->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <br>

            {{ $events->links() }}

                <div class="row">
                    @foreach($events as $event)
                        <div class="col-md-3 pb-5">
                            <div class="card" style="width: 18rem;">
                                <img height="180" width="286" class="card-img-top" src="{{url("images/$event->photo")}}"   >
                                <img onclick="like({{$event->id}})"  class="position-absolute"
                                     @php
                                     $url = "like.png";
                                     foreach ($event->likes as $like){
                                            if(auth()->user() && $like->user_id  == auth()->user()->id??0){
                                                $url = "liked.png";
                                            }
                                        }
                                     @endphp
                                     src="{{url($url)}}"
                                     height="50px" width="50px" style="margin-left:230px;margin-top: 100px; ">
                                <p class="card-text mb-0 mt-1" style="margin-left: 180px;">
                                    likes {{ $event->likes_count }}
                                </p>


                                <div class="card-body pt-0">
                                    <a href="{{url("/events/category/$event->category_id")}}">
                                        <button class="btn-sm btn-success border-0 pt-0 pb-0 ps-1 pe-1" >{{$event->category->name}}</button>

                                    </a>

                                    <h5 class="card-title"> {{ substr($event->title,0,15) }}</h5>
                                    <h6 class="card-subtitle text-warning"> {{ $event->created_at }}</h6>
                                    <p class="card-text">
                                        {{ substr($event->body,0,50)  }}...
                                    </p>
                                    <a  href="{{ url("/events/detail/$event->id") }}">View Detail &laquo;</a>
                                    <p class="card-text pt-2 fw-bold">
                                        {{$event->user->organization->name}}
                                    </p>

                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">

                                        <form id="likeForm{{$event->id}}" action="{{ url('/events/event-like') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="event_id"
                                                   value="{{ $event->id }}">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
    @endsection
    <script type="text/javascript">
        function like(id){
            var form = document.getElementById('likeForm'+id);

            form.submit();
        }

    </script>
