
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
                                <div  class="card-header-pills ps-3">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <h6><img width="12" src='{{url("star-fill.svg")}}'>
                                                {{$event->participations->count()}}
                                                /
                                                {{$event->numberof_participants}}

                                            </h6>
                                        </div>
                                        <div class=" col-md-7">
                                            @if($event->canParticipate())
                                                <p class="m-0 small p-0">Registration open</p>
                                            @else
                                                <p class="m-0 small p-0">Registration close</p>
                                            @endif
                                        </div>
                                    </div>




                                </div>
                                <img onclick="window.location='{{ url("/events/detail/$event->id") }}';" height="180" width="286" class="card-img-top" src="{{url("images/$event->photo")}}"   >
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
                                     height="50px" width="50px" style="margin-left:230px;margin-top: 130px; ">
                                <p class="card-text mb-0 mt-1" style="margin-left: 180px;">
                                    likes {{ $event->likes_count }}
                                </p>


                                <div onclick="window.location='{{ url("/events/detail/$event->id") }}';" class="card-body p-1">
                                    <a href="{{url("/events/category/$event->category_id")}}">
                                        <button class="btn-sm btn-success border-0 pt-0 pb-0 ps-1 pe-1" >{{$event->category->name}}</button>

                                    </a>

                                    <h5 class="card-title"> {{ substr($event->title,0,15) }}</h5>
                                    <h6 class="card-subtitle text-warning"> {{ $event->start_date }}</h6>
                                    <p class="card-text">
                                        {{ substr($event->address,0,50)  }}...
                                    </p>
                                    @if($event->price==0)
                                        <p class="card-text">
                                            Free
                                        </p>
                                    @else
                                        <p class="card-text">
                                            Starts at: ${{$event->price}}
                                        </p>
                                    @endif

                                    <p class="card-text pt-2 fw-bold">
                                        {{$event->user->organization->name}}
                                    </p>
                                    <p  class="pt-0 small text-secondary">
                                        followers {{$event->user->organization->getFollowersCount()}}
                                    </p>
                                    <form id="likeForm{{$event->id}}" action="{{ url('/events/event-like') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="event_id"
                                               value="{{ $event->id }}">
                                    </form>
                                </div>
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
