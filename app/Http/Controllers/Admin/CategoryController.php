<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[

            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,bmp,png,jpg,gif',
        ]);

        // GET FORM IMAGE
        $image = $request->file('image');
        $slug = str_slug($request->name);
        if (isset($image))
        {
            // MAKE UNIQUE NAME FOR IMAGE
            $imagename = time() . '.' . $request->image->extension();

            // CHECK CATEGORY DERECTORY IS EXISTS

            if(!Storage::disk('public')->exists('category'))
            {
                Storage::disk('public')->makeDirectory('category');
            }

            // RESIZE IMAGE FOR CATEGORY AND UPLOAD
            $category = Image::make($image)->resize(1600,479)->save();
            Storage::disk('public')->put('category/'.$imagename, $category);


            // CHECK SLIDER DERECTORY IS EXISTS

            if (!Storage::disk('public')->exists('category/slider')) {
                Storage::disk('public')->makeDirectory('category/slider');
            }

            // RESIZE IMAGE FOR CATEGORY AND UPLOAD
            $slider = Image::make($image)->resize(500, 333)->save();
            Storage::disk('public')->put('category/slider/' . $imagename, $slider);
        }else{
            $imagename = 'default.png';
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category Successfully Saved', 'Success');
        return redirect()->route('admin.category.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpeg,bmp,png,jpg,gif',
        ]);

        // GET FORM IMAGE
        $image = $request->file('image');
        $category = Category::find($id);
        $slug = str_slug($request->name);
        if (isset($image)) {
            // MAKE UNIQUE NAME FOR IMAGE
            $imagename = time() . '.' . $request->image->extension();

            // CHECK CATEGORY DERECTORY IS EXISTS

            if (!Storage::disk('public')->exists('category')) {
                Storage::disk('public')->makeDirectory('category');
            }
            // DELETE OLD IMAGE FORM CATEGORY

            if(Storage::disk('public')->exists('category/'.$category->image))
            {
                Storage::disk('public')->delete('category/'.$category->image);
            }

            // RESIZE IMAGE FOR CATEGORY AND UPLOAD
            $categoryimage = Image::make($image)->resize(1600, 479)->save();
            Storage::disk('public')->put('category/' . $imagename, $categoryimage);


            // CHECK SLIDER DERECTORY IS EXISTS

            if (!Storage::disk('public')->exists('category/slider/')) {
                Storage::disk('public')->makeDirectory('category/slider/');
            }

            // DELETE OLD IMAGE FORM SLIDER

            if (Storage::disk('public')->exists('category/slider/' . $category->image)) {
                Storage::disk('public')->delete('category/slider/' . $category->image);
            }


            // RESIZE IMAGE FOR CATEGORY AND UPLOAD
            $slider = Image::make($image)->resize(500, 333)->save();
            Storage::disk('public')->put('category/slider/' . $imagename, $slider);
        } else {
            $imagename = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category Successfully updated', 'Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (Storage::disk('public')->exists('category/' . $category->image)) {
            Storage::disk('public')->delete('category/' . $category->image);
        }


        if (Storage::disk('public')->exists('category/slider/' . $category->image)) {
            Storage::disk('public')->delete('category/slider/' . $category->image);
        }


        $category->delete();
        Toastr::success('Category Successfully Deleted', 'Success');
        return redirect()->back();

    }
}
