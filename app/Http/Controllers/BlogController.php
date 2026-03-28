<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            $categories = Category::get();
            return view('theme.blogs.create', compact('categories'));
        }
        return redirect('login') ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
       $data = $request->validated();
       //image uploading
        //1- get image
        $image = $request->image ;
        //2-change it's current name
        $newImageName = time().'-'.$image->getClientOriginalName();
        //3-move image to my project
        $image->storeAs('blogs', $newImageName, 'public' );
        //4- save new name to database record
        $data['image']= $newImageName ;
        $data['user_id']= Auth::user()->id;
        //create new blog record
        Blog::create($data);

        return back()->with('blogcreatestatus' , 'your blog created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('theme.single-blog' , compact('blog')) ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if($blog->user_id == Auth::user()->id){
        $categories = Category::get();
        return view('theme.blogs.edit' , compact('categories' , 'blog'));

        }
        abort(403) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        if($blog->user_id == Auth::user()->id) {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                //0-delete old image
                Storage::delete("public/blogs/$blog->image");
                //image uploading
                //1- get image
                $image = $request->image;
                //2-change it's current name
                $newImageName = time() . '-' . $image->getClientOriginalName();
                //3-move image to my project
                $image->storeAs('blogs', $newImageName, 'public');
                //4- save new name to database record
                $data['image'] = $newImageName;
            }
            $data['user_id'] = Auth::user()->id;
            //create new blog record
            $blog->update($data);

            return back()->with('blogupdatestatus', 'your blog updateed successfully');
        }
        abort(403) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //0-delete old image
        if ($blog->user_id == Auth::user()->id) {
            if($blog->image){
            Storage::delete("public/blogs/$blog->image");
            }
            $blog->delete();
            return back()->with('blogdeletestatus', 'your blog has been deleted successfully');
        }
        abort(403) ;
    }
    public function myBlogs(Blog $blog)
    {
        if (Auth::check()) {
            $blogs = Blog::where('user_id', Auth::user()->id)->paginate(4);
            return view('theme.blogs.my-blogs', compact('blogs'));
        }
        return redirect('login') ;
    }
}
