
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

            @foreach($events as $event)
                <div class="card mb-3">
                    <div class="card-body mb-2">
                        <h5 class="card-title">
                            {{ $event->title }}
                        </h5>
                        <div class="card-subtitle mb-2 text-muted small">
                            {{ $event->created_at->diffForHumans() }}
                        </div>
                        <p class="card-text">
                            {{ $event->body }}
                        </p>
                        <p class="card-link" >
                            <a  href="{{ url("/events/detail/$event->id") }}">View Detail &laquo;</a>
                        </p>
                        <form action="{{ url('/events/event-like') }}" method="post">
                            @csrf
                            <input type="hidden" name="event_id"
                                   value="{{ $event->id }}">
                            <p class="card-img-bottom">
                                <button  type="submit" class="btn btn-block btn-primary float-right"><i class="fa fa-thumbs-up">Like {{ $event->likes_count }}</i> </button>

                            </p>

                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection
