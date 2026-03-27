
@extends('theme.master')
@section('title' , 'My Blogs')
@section('content')
    @include('theme.partials.hero', ['title_page'=> 'My Blogs'])

    <!-- ================ contact section start ================= -->
    <section class="section-margin--small section-margin">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if (session('blogdeletestatus'))
                        <div class="alert alert-success">
                            {{ session('blogdeletestatus') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                           <tr>
                             <th scope="col" style="width: 5%">#</th>
                             <th scope="col">Title</th>
                             <th scope="col" style="width:15%">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                        @if(count($blogs)>0)
                        @foreach($blogs as $key => $blog)
                        <tr>
                              <th scope="row">{{1+$key++}}</th>
                            <td>
                                <a href="{{route('blogs.show' , $blog)}}" target="_blank">{{$blog->name}}</a>
                            </td>
                               <td>
                                   <a href="{{route('blogs.edit' , $blog)}}" class="btn btn-sm btn-primary mr-2">Edit</a>

                                   <form id="delete_form_{{$blog->id}}" action="{{route('blogs.destroy' , $blog)}}" method="Post" class="d-inline">
                                       @csrf
                                       @method('DELETE')
                                   <button type="submit"
                                           onclick="return confirm('Do you sure delete this blog?')"
                                           class="btn btn-sm btn-danger mr-2">
                                       Delete
                                   </button>
                                   </form>
                               </td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                    @if(count($blogs)>0)
                        {{$blogs->links("pagination::bootstrap-4")}}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- ================ contact section end ================= -->
@endsection
