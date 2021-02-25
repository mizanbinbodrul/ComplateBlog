<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post;


class CommnentController extends Controller
{
    public function store(Request $request,$post)
    {
        $this->validate($request, [
            'comment' => 'required',

        ]);

        $comment = New Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post;
        $comment->comment = $request->comment;
        $comment->save();
        Toastr::success('Comment successfully published', 'Success');
        return redirect()->back();
     }
}
