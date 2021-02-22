<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use App\Notifications\NewAuthorPost;
use App\Notifications\AuthorPostApprove;
use Illuminate\Support\Facades\Storage;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tag      = Tag::all();
        return view('author.post.create', compact('categories','tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'image'      => 'required',
            'categories' => 'required',
            'tags'       => 'required',
            'body'       => 'required',
        ]);
        $image = $request->file('image');
        $slug  = str_slug($request->title);
        if (isset($image)) {
            // MAKE UNIQUE NAME FOR IMAGE
            $imagename = time() . '.' . $request->image->extension();

            // CHECK CATEGORY DERECTORY IS EXISTS

            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            // RESIZE IMAGE FOR CATEGORY AND UPLOAD
            $postImage = Image::make($image)->resize(1600, 1066)->save();
            Storage::disk('public')->put('post/' . $imagename, $postImage);
        } else {
            $imagename = 'default.png';
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imagename;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();
        $
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
        $users = User::where('role_id', 1)->get();
        Notification::send($users, new NewAuthorPost($post));

        Toastr::success('Post Successfully Saved', 'Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('author.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tag = Tag::all();
        $categories = Category::all();
        return view('author.post.edit', compact('post', 'categories', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title'     => 'required',
            'image'      => 'image',
            'categories' => 'required',
            'tags'       => 'required',
            'body'       => 'required',
        ]);
        $image = $request->file('image');
        $slug  = str_slug($request->title);
        if (isset($image)) {
            // MAKE UNIQUE NAME FOR IMAGE
            $imagename = time() . '.' . $request->image->extension();

            // CHECK CATEGORY DERECTORY IS EXISTS

            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }

            if (Storage::disk('public')->exists('post/' . $post->image)) {
                Storage::disk('public')->delete('post/' . $post->image);
            }

            // RESIZE IMAGE FOR CATEGORY AND UPLOAD
            $postImage = Image::make($image)->resize(1600, 1066)->save();
            Storage::disk('public')->put('post/' . $imagename, $postImage);
        } else {
            $imagename = $post->image;
        }
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imagename;
        $post->body = $request->body;
        if (isset($request->status)) {
            $post->status = true;
        } else {
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post Successfully Updated', 'Success');
        return redirect()->route('author.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Storage::disk('public')->exists('post/' . $post->image)) {
            Storage::disk('public')->delete('post/' . $post->image);
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Post Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
