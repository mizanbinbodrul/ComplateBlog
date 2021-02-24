<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class favoriteController extends Controller
{
   public function add($post)
   {
        $user = Auth::user();
        $isFavorite = $user->favorit_posts()->where('post_id',$post)->count();

        if($isFavorite == 0)

        {
            $user->favorit_posts()->attach($post);
            Toastr::success('Post successfully added in your favorite list', 'Success');
            return redirect()->back();
        } else

        {
            $user->favorit_posts()->detach($post);
            Toastr::success('Post successfully removed in your favorite list', 'Success');
            return redirect()->back();
        }
   }
}
