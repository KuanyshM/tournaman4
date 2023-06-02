
    @extends("layouts.app")

    @section("content")
        <div class="container">
            <div style="margin-bottom: 3%">
                <div class="row">
1
                </div>
            </div>

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

            {{ $events->links() }}

                <div class="row">
                    @foreach($events as $event)
                            <div class="m-3 col-md-3 card" style="width: 18rem;">
                                <img style="margin-top: 5%;" onclick="window.location='{{ url("/events/detail/$event->id") }}';" height="180" width="286" class="card-img-top" src="https://i.ytimg.com/vi/{{$event->link}}/hqdefault.jpg"   >




                                <div onclick="window.location='{{ url("/events/detail/$event->id") }}';" class="card-body p-1">
                                    <a href="{{url("/events/category/$event->category_id")}}">
                                        <button class="btn-sm btn-success border-0 pt-0 pb-0 ps-1 pe-1 mb-2 mt-2" >{{$event->category->name}}</button>

                                    </a>

                                    <h5 class="card-title"> {{ $event->title }}</h5>




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
