<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventLike;
use App\Models\EventParticipation;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail','search','category']);
        $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-delete', ['only' => ['destroy','delete']]);
    }

    public function index()
    {
        $data = Event::withCount('likes')->latest()->paginate(5);
        $categories = Category::get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
        ]);
    }

    public function detail($id)
    {
        $data = Event::withCount('likes')->withCount('participations')->with('user')->find($id);
        if(is_null($data)){
            $data = Event::latest()->paginate(3);
            return view('events.index',[
                'events' => $data
            ]);
        }
        return view('events.detail',[
            'event' => $data
        ]);
    }

    public function add()
    {
        $data = Category::all();
        return view('events.add', [
            'categories' => $data
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }
        $event= new Event;
        $event->title = request()->title;
        $event->body = request()->body;
        $event->category_id = request()->category_id;
        $event->user_id = auth()->user()->id;
        $event->save();

        return redirect('/events');

    }

    public function delete($id)
    {
        $event = Event::find($id);
        if(auth()->user()->id == $event->user_id){
            $event->delete();
        }

        return redirect('/events')->with('info', 'Article deleted');
    }
    public function myevents()
    {
        $data = Event::withCount('likes')->withCount('participations')->where('user_id',auth()->user()->id)->latest()->paginate(5);
        $categories = Category::get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
        ]);
    }
    public function category($id)
    {
        $data = Event::where('category_id',$id)->latest()->paginate(5);
        $categories = Category::get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
            'activeCategoryID' => $id,
        ]);

    }
    public function organizationEvents($id)
    {
        $list = DB::select("select
       e.id
                            from tournaman.events e
                        inner join tournaman.users u on e.user_id = u.id
                        where u.organization_id = $id");
        $temp = array();
        foreach ($list as $item){
            $temp[]=$item->id;
        }

        $data = Event::withCount('likes')->whereIn('id',$temp)->latest()->paginate(5);
        $categories = Category::get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
        ]);
    }
    public function search(Request $request)
    {   $key = $request->key;
        $data = Event::where('title','like',"%$key%")->orWhere('body','like',"%$key%")->latest()->paginate(5);
        $categories = Category::get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
        ]);

    }
    public function like()
    {

        $event = Event::find(request()->event_id ?? 0 );
        $user = auth()->user();
        $userLike = EventLike::select('*')
            ->where('event_id', '=', $event->id)
            ->where('user_id', '=', $user->id)
            ->first();

        if(!$userLike){
            $like = new EventLike();
            $like->event_id = $event->id;
            $like->user_id = $user->id;
            $like->save();
        }else{
            $userLike->delete();
        }

       return redirect()->back();

    }

    public function participate()
    {

        $event = Event::find(request()->event_id ?? 0 );
        $user = auth()->user();
        $userParticipation = EventParticipation::select('*')
            ->where('event_id', '=', $event->id)
            ->where('user_id', '=', $user->id)
            ->first();

        if(!$userParticipation){
            $participation = new EventParticipation();
            $participation->event_id = $event->id;
            $participation->user_id = $user->id;
            $participation->save();
        }else{
            $userParticipation->delete();
        }

        return redirect()->back();

    }
}
