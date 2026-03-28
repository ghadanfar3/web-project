@extends('theme.master')

@section('title', $user->name)

@section('content')

    @include('theme.partials.hero', ['title_page' => 'Blogs by ' . $user->name])

    <section class="blog-post-area section-margin mt-4">
        <div class="container">
            <div class="row">

                <div class="col-lg-8">

                    <h2 class="mb-4">Blogs by {{$user->name}} </h2>

                    @forelse($blogs as $blog)

                        <div class="single-recent-blog-post">
                            <div class="thumb">
                                <img class="w-100 img-fluid" src="{{asset("storage/blogs/$blog->image")}}" alt="">

                                <ul class="thumb-info">
                                    <li>
                                        <a href="#">
                                            <i class="ti-user"></i> {{$user->name}}
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="ti-notepad"></i> {{$blog->created_at->format('D M Y')}}
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="ti-themify-favicon"></i> ({{$blog->comments_count}}) Comments
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="details mt-20">
                                <a href="{{route('blogs.show' , $blog)}}">
                                    <h3>{{$blog->name}}</h3>
                                </a>

                                <p>{{$blog->description}}</p>

                                <a class="button" href="{{route('blogs.show' , $blog)}}">
                                    Read More <i class="ti-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    @empty
                        <p>هاد المستخدم ما عنده بلوغات 😅</p>
                    @endforelse

                    <div class="mt-4">
                        {{$blogs->links("pagination::bootstrap-4")}}
                    </div>

                </div>

                {{-- Sidebar --}}
                @include('theme.partials.sidebar')

            </div>
        </div>
    </section>

@endsection
