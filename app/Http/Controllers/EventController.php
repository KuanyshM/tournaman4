<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Category;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index()
    {
        $data = Event::latest()->paginate(15);
        return view('events.index',[
            'events' => $data
        ]);
    }

    public function detail($id)
    {
        $data = Event::find($id);

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
        $event->save();

        return redirect('/events');

    }

    public function delete($id)
    {
        $event = Event::find($id);
        $event->delete();

        return redirect('/events')->with('info', 'Article deleted');
    }
}
