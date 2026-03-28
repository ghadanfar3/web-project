@php
    use App\Models\Category ;
    use App\Models\Blog ;
       $categories = Category::get() ;
       $recentBlogs = Blog::latest()->take(3)->get() ;
@endphp
<div class="col-lg-4 sidebar-widgets">
    <div class="widget-wrap">
        <div class="single-sidebar-widget newsletter-widget">
            <h4 class="single-sidebar-widget__title">Newsletter</h4>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        <form action="{{route('subscriber.store')}}" method="Post">
            @csrf
            <div class="form-group mt-30">
                <div class="col-autos">
                    <input type="text" name="email" class="form-control" value="{{old('email')}}" id="inlineFormInputGroup" placeholder="Enter email" onfocus="this.placeholder = ''"
                           onblur="this.placeholder = 'Enter email'">
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="bbtns d-block mt-20 w-100">Subcribe</button>
        </form>
        </div>
        @if(count($categories)>0)
        <div class="single-sidebar-widget post-category-widget">

            <h4 class="single-sidebar-widget__title">Catgory</h4>
            @foreach($categories as $category)
            <ul class="cat-list mt-20">
                <li>
                    <a href="{{route('category' , $category->id)}}" class="d-flex justify-content-between">
                        <p>{{$category->name}}</p>
                        <p>({{count($category->blogs)}})</p>
                    </a>
                </li>
            </ul>
            @endforeach
        </div>
        @endif
        @if(count($recentBlogs)>0)
        <div class="single-sidebar-widget popular-post-widget">
            <h4 class="single-sidebar-widget__title">Recent Blogs</h4>
            <div class="popular-post-list">
                @foreach($recentBlogs as $blog)
                <div class="single-post-list">
                    <div class="thumb">
                    <div class="details mt-20">
                        <a href="{{route('blogs.show' , $blog)}}">
                            <h6>{{$blog->name}}</h6>
                        </a>
                    </div>
                        <img class="card-img rounded-0" src="{{asset("storage/blogs/$blog->image")}}" alt="">
                        <ul class="thumb-info">
                            <li><a href="{{route('user.blogs' , $blog->user)}}">{{$blog->user->name}}</a></li>
                            <li><a href="#">{{$blog->created_at->format('D M')}}</a></li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
