@extends('layouts.frontend.app')

@push('css')

<link href="{{ asset('assets/frontend/css/category/styles.css') }}" rel="stylesheet">

<link href="{{ asset('assets/frontend/css/category/responsive.css') }}" rel="stylesheet">

@endpush

@section('title')



<!-- THIS IS CONTENT AREA SECTION -->
@section('content')
<div class="slider display-table center-text">
		<h1 class="title display-table-cell"><b>ALL POST</b></h1>
	</div><!-- slider -->

	<section class="blog-area section">
		<div class="container">

			<div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

							<div class="blog-image"><img src="{{Storage::disk('public')->url('post/'.$post->image)}}" alt="Blog Image"></div>

							<a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$post->user->image)}}" alt="Profile Image"></a>

							<div class="blog-info">

								<h4 class="title"><a href="#"><b>{{$post->title}}</b></a></h4>

								<ul class="post-footer">
								<li>
                                    @guest
                                    <a href="javascript:void(0);" onclick="toastr.info('To add favorite List.You need to login first.','Info',{
                                        closeButton: true,
                                        progressBar:true,

                                        })"><i class="ion-heart"></i>{{$post->favorit_to_user->count()}}</a>
                                    @else
                                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{$post->id}}').submit();" class="{{

                                            !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favorit_posts' : ''}}">
                                        <i class="ion-heart"></i>
                                        {{$post->favorit_to_user->count()}}</a>

                                        <form id="favorite-form-{{$post->id}}" method="POST" action="{{route('post.favorite',$post->id)}}" style="display: none">
                                            @csrf


                                        </form>
                                    @endguest

                                </li>
								</ul>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
				</div>
                @endforeach


			</div><!-- row -->

			{{ $posts->links() }}

		</div><!-- container -->
	</section><!-- section -->

@endsection

<!-- THIS IS JS AREA SECTION -->
@push('js')

@endpush
