
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
                        <div class="col-1 dropdown">
                            <div class="nav-item dropdown">
                                <div  class="dropdown-toggle"  role="button" data-bs-toggle="dropdown" >
                                    Category
                                </div>

                                <div class="dropdown-menu" >
                                    @foreach($categories as $category)
                                        <div class="dropdown-item"><a href="{{url("events/category/$category->id")}}">{{$category->name}}</a></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            {{ $events->links() }}

                <div class="row">
                    @foreach($events as $event)
                        <div class="col-md-3 pb-5">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{url('1.png')}}"  >
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
                                    <button class="btn-sm btn-success border-0 pt-0 pb-0 ps-1 pe-1" >{{$event->category->name}}</button>

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
