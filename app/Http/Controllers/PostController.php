<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->approved()->published()->paginate(6);
        return view('postcategory', compact('posts'));
    }

    public function details($slug)
    {
        $posts = Post::where('slug', $slug)->approved()->published()->first();
        $keycount = 'blog_'. $posts->id;
        if (!Session::has($keycount)){

            $posts->increment('view_count');
            Session::put($keycount, 1);
        }
        $randomposts = Post::approved()->published()->take(3)->inRandomOrder()->get();
        return view('singlepost',compact('posts','randomposts'));

    }



    public function postByCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->approved()->published()->get();
        return view('category', compact('category', 'posts'));
    }


    public function postByTag($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        $posts = $tag->posts()->approved()->published()->get();
        return view('tag', compact('tag', 'posts'));
    }


}
