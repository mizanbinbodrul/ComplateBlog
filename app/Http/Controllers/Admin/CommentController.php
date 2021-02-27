<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::latest()->get();
        return view('admin.comment', compact('comments'));
    }

    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        Toastr::success('Comment Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
