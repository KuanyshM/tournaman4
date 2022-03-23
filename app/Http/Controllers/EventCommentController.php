<?php

namespace App\Http\Controllers;

use App\Models\EventComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $comment = new EventComment();
        $comment->content = request()->content;
        $comment->event_id = request()->event_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return back();
    }

    public function delete($id)
    {
        $comment = EventComment::find($id);
        if(Gate::allows('comment-delete', $comment) ) {
            $comment->delete();
            return back();
        } else {
            return back()->with('error', 'Unauthorize');
        }
    }
}
