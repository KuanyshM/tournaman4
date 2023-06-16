<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventLike;
use App\Models\EventParticipation;
use App\Models\Organization;
use App\Models\ParticipationStatus;
use App\Models\Team;
use App\Models\Tracking;
use App\Models\User;
use App\Models\UserTeam;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail','search','category']);
        $this->middleware('permission:event-delete', ['only' => ['destroy','delete']]);
       // $this->middleware('permission:event-create', ['only' => ['create','update','add']]);
    }

    public function index()
    {
        $data = Event::withCount('likes')->latest()->paginate(5);
        $categories = Category::where('parent_id','=',0)->get();
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
        $organization = Organization::withCount('followers')->find($data->user->organization_id);
        $myTeams = array();
        if(auth()->check()){
            $myTeams = UserTeam::where('from_user_id','=',auth()->user()->id)
                ->where('status_id','=',2)->get();
        }
        $ipAddress = $_SERVER['REMOTE_ADDR'];


        return view('events.detail',[
            'event' => $data,
            'organization' => $organization,
            'myTeams' => $myTeams,
            'ipAddress' => $ipAddress,
        ]);
    }
    public function edit($id)
    {
        $categories = Category::all();

        $data = Event::withCount('likes')->withCount('participations')->with('user')->find($id);
        if(is_null($data)){
            $data = Event::latest()->paginate(3);
            return view('events.index',[
                'events' => $data
            ]);
        }
        $organization = Organization::withCount('followers')->find($data->user->organization_id);

        return view('events.edit',[
            'event' => $data,
            'organization' => $organization,
            'categories' => $categories
        ]);
    }

    public function add()
    {
        $data =  Category::where('parent_id','=',0)->get();
        $author = User::find(auth()->user()->id);
        $subCategories = Category::where('parent_id','!=',0)->get();

        return view('events.add', [
            'categories' => $data,
            'author' => $author,
            'subCategories' => $subCategories
        ]);
    }
    public function addVideo()
    {
        $data =  Category::where('parent_id','=',0)->get();
        $author = User::find(auth()->user()->id);
        $subCategories = Category::where('parent_id','!=',0)->get();

        return view('events.addVideo', [
            'categories' => $data,
            'author' => $author,
            'subCategories' => $subCategories
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }
        $imageSize = getimagesize(request()->photo);
        $width = $imageSize[0];
        $height = $imageSize[1];
        if(!($width/$height>=1.5 && $width/$height<=1.9)){
            return back()->withErrors("The photo has invalid image dimensions.");
        }
        $event= new Event;
        $event->title = request()->title;
        $event->body = request()->body;
        $event->category_id = request()->category_id;



        $imageName = time().'.'.request()->photo->extension();
        request()->photo->move(public_path('images'), $imageName);
        $event->photo  = $imageName;

        $event->start_date = request()->start_date;
        $event->end_date = request()->end_date;
        $event->reg_start_date = request()->reg_start_date;
        $event->reg_end_date = request()->reg_end_date;
        $event->numberof_participants = request()->numberof_participants;
        $event->price = request()->price;
        $event->address = request()->address;
        $event->age_from = request()->age_from;
        $event->age_to = request()->age_to;
        $event->format_id = request()->format_id;
        $event->faq = request()->faq;
        $event->user_id = auth()->user()->id;

        $event->venue = request()->venue;
        $event->city = request()->city;
        $event->state = request()->state;
        $event->meet_links = request()->links;
        $event->address_announce = request()->announceInput;
        $event->schedule = request()->schedule;
        $event->rules = request()->rules;
        $event->prize = request()->prize;
        $event->registration = request()->registration_info;
        $event->eventType = request()->eventType;


        $event->save();

        return redirect('/events');

    }

    public function createVideo()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'link' => 'required',
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

        $event->link = request()->link;



        $event->save();

        return redirect('/events');

    }
    public function update($id)
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }
        $event = Event::find($id);
        if(is_null($event)){
            return back()->withErrors("Not found");
        }
        $input = array();

        if(!is_null(request()->photo)){
            $imageSize = getimagesize(request()->photo);
            $width = $imageSize[0];
            $height = $imageSize[1];
            if(!($width/$height>=1.5 && $width/$height<=1.9)){
                return back()->withErrors("The photo has invalid image dimensions.");
            }
            $imageName = time().'.'.request()->photo->extension();
            request()->photo->move(public_path('images'), $imageName);
            $input['photo']  = $imageName;
        }




        $input['title'] = request()->title;
        $input['body'] = request()->body;
        $input['category_id'] = request()->category_id;
        $input['start_date'] = request()->start_date;
        $input['end_date'] = request()->end_date;
        $input['reg_start_date'] = request()->reg_start_date;
        $input['reg_end_date'] = request()->reg_end_date;
        $input['numberof_participants'] = request()->numberof_participants;
        $input['price'] = request()->price;
        $input['address'] = request()->address;
        $input['age_from'] = request()->age_from;
        $input['age_to'] = request()->age_to;
        $input['format_id'] = request()->format_id;
        $input['faq'] = request()->faq;
        $input['user_id'] = auth()->user()->id;
        $event->update($input);

         return back();

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
        $categories = Category::where('parent_id','=',0)->get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
        ]);
    }
    public function myVideos()
    {
        $data = Event::withCount('likes')->withCount('participations')->where('user_id',auth()->user()->id)->latest()->paginate(5);
        $categories = Category::where('parent_id','=',0)->get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
        ]);
    }
    public function participants($id){
        $statuses = ParticipationStatus::all();
        $event = Event::find($id);
        if($event->eventType==1){
            $data = EventParticipation::with('user')
                ->where('event_participations.event_id','=',$id)
                ->where('event_participations.user_id','!=',0)
                ->orderBy('id', 'desc')
                ->paginate(5);
        }else{
            $data = EventParticipation::with('user')
                ->where('event_participations.event_id','=',$id)
                ->where('event_participations.team_id','!=',0)
                ->orderBy('id', 'desc')
                ->paginate(5);
        }




        return view('events.participants', compact('data','statuses','event'));
    }
    public function category($id)
    {
        $data = Event::where('category_id',$id)->latest()->paginate(5);
        $categories = Category::where('parent_id','=',0)->get();
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
        $categories = Category::where('parent_id','=',0)->get();
        return view('events.index',[
            'events' => $data,
            'categories' => $categories,
        ]);
    }
    public function search(Request $request)
    {   $key = $request->key;
        $data = Event::where('title','like',"%$key%")->orWhere('body','like',"%$key%")->latest()->paginate(5);
        $categories = Category::where('parent_id','=',0)->get();
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
            if($userParticipation->status_id==1){
                $userParticipation->delete();
            }else{
                return back()->withErrors("You can not delete your participation");
            }
        }

        return redirect()->back();

    }
    public function participateTeam()
    {

        $event = Event::find(request()->event_id ?? 0 );
        $team = Team::find(request()->team_id ?? 0 );
        $userParticipation = EventParticipation::select('*')
            ->where('event_id', '=', $event->id)
            ->where('team_id', '=', $team->id)
            ->first();

        if(!$userParticipation){
            $participation = new EventParticipation();
            $participation->event_id = $event->id;
            $participation->team_id = $team->id;
            $participation->save();
        }else{
            if($userParticipation->status_id==1){
                $userParticipation->delete();
            }else{
                return back()->withErrors("You can not delete your participation");
            }
        }

        return redirect()->back();

    }
    public function ParticipationStatus()
    {
        $event = Event::where('id','=',request()->event_id)
                        ->where('user_id','=',auth()->user()->id)->first();
        $participations = request()->participations;

        if(is_null($event) || is_null($participations)){
            return back()->withErrors("Not found");
        }

        foreach ($participations as $part_id => $status){

            if($event->eventType==1){
                $participation = EventParticipation::where('event_id','=',$event->id)
                    ->where('user_id','=',$part_id)->first();
            }else{
                $participation = EventParticipation::where('event_id','=',$event->id)
                    ->where('team_id','=',$part_id)->first();
            }

            if(is_null($participation)){
                return back()->withErrors("Not found");
            }else{
                $participation->update(['status_id' => $status['status']]);
            }


        }


       return redirect()->back();

    }
}
