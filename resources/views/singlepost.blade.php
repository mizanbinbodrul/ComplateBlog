@extends('layouts.frontend.app')

@push('css')

<link href="{{ asset('assets/frontend/css/singlepost/styles.css') }}" rel="stylesheet">

<link href="{{ asset('assets/frontend/css/singlepost/responsive.css') }}" rel="stylesheet">

@endpush

@section('title')
{{$posts->titile}}
@endsection


<!-- THIS IS CONTENT AREA SECTION -->
@section('content')
<div class="header-bg" style="

        height: 80%;
        width: 100%;
        background-image: url({{ Storage::disk('public')->url('post/'.$posts->image) }});
        background-size: cover;
">

	</div><!-- slider -->

	<section class="post-area section">
		<div class="container">

			<div class="row">

				<div class="col-lg-8 col-md-12 no-right-padding">

					<div class="main-post">

						<div class="blog-post-inner">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$posts->user->image)}}" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>{{$posts->user->name}}</b></a>
									<h6 class="date">{{$posts->created_at->diffForHumans()}}</h6>
								</div>

							</div><!-- post-info -->

							<h3 class="title"><a href="#"><b>{{$posts->title}}</b></a></h3>

							<div class="para">
                                {!! html_entity_decode($posts->body) !!}
                            </div>



							<ul class="tags">
								@foreach ($posts->tags as $tag)
                                    <li><a href="#">{{$tag->name}}</a></li>
                                @endforeach
							</ul>
						</div><!-- blog-post-inner -->

						<div class="post-icons-area">
							<ul class="post-icons">
								<li>
                                    @guest
                                    <a href="javascript:void(0);" onclick="toastr.info('To add favorite List.You need to login first.','Info',{
                                        closeButton: true,
                                        progressBar:true,

                                        })"><i class="ion-heart"></i>{{$posts->favorit_to_user->count()}}</a>
                                    @else
                                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{$posts->id}}').submit();" class="{{

                                            !Auth::user()->favorite_posts->where('pivot.post_id',$posts->id)->count() == 0 ? 'favorit_posts' : ''}}">
                                        <i class="ion-heart"></i>
                                        {{$posts->favorit_to_user->count()}}</a>

                                        <form id="favorite-form-{{$posts->id}}" method="POST" action="{{route('post.favorite',$posts->id)}}" style="display: none">
                                            @csrf


                                        </form>
                                    @endguest

                                </li>
							</ul>

							<ul class="icons">
								<li>SHARE : </li>
								<li><a href="#"><i class="ion-social-facebook"></i></a></li>
								<li><a href="#"><i class="ion-social-twitter"></i></a></li>
								<li><a href="#"><i class="ion-social-pinterest"></i></a></li>
							</ul>
						</div>

						<div class="post-footer post-info">

							<div class="left-area">
								<a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
							</div>

							<div class="middle-area">
								<a class="name" href="#"><b>Katy Liu</b></a>
								<h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
							</div>

						</div><!-- post-info -->


					</div><!-- main-post -->
				</div><!-- col-lg-8 col-md-12 -->

				<div class="col-lg-4 col-md-12 no-left-padding">

					<div class="single-post info-area">

						<div class="sidebar-area about-area">
							<h4 class="title"><b>{{$posts->user->name}}</b></h4>
							<p>{{$posts->user->about}}</p>
						</div>


						<div class="tag-area">

							<h4 class="title"><b>CATEGORY CLOUD</b></h4>
							<ul>
                                @foreach ($posts->categories as $category)
                                    <li><a href="#">{{$category->name}}</a></li>
                                @endforeach

							</ul>

						</div><!-- subscribe-area -->

					</div><!-- info-area -->

				</div><!-- col-lg-4 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section><!-- post-area -->


	<section class="recomended-area section">
		<div class="container">
			<div class="row">

                @foreach ($randomposts as $randompost)
                    <div class="col-lg-4 col-md-6">
					<div class="card h-100">
						<div class="single-post post-style-1">

							<div class="blog-image"><img src="{{Storage::disk('public')->url('post/'.$randompost->image)}}" alt="Blog Image"></div>

							<a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$randompost->user->image)}}" alt="Profile Image"></a>

							<div class="blog-info">

								<h4 class="title"><a href="#"><b>{{$randompost->title}}</b></a></h4>

								<ul class="post-footer">
									<li>
                                    @guest
                                    <a href="javascript:void(0);" onclick="toastr.info('To add favorite List.You need to login first.','Info',{
                                        closeButton: true,
                                        progressBar:true,

                                        })"><i class="ion-heart"></i>{{$randompost->favorit_to_user->count()}}</a>
                                    @else
                                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{$randompost->id}}').submit();" class="{{

                                            !Auth::user()->favorite_posts->where('pivot.post_id',$randompost->id)->count() == 0 ? 'favorit_posts' : ''}}">
                                        <i class="ion-heart"></i>
                                        {{$randompost->favorit_to_user->count()}}</a>

                                        <form id="favorite-form-{{$randompost->id}}" method="POST" action="{{route('post.favorite',$randompost->id)}}" style="display: none">
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

		</div><!-- container -->
	</section>

	<section class="comment-section">
		<div class="container">
			<h4><b>POST COMMENT</b></h4>
			<div class="row">

				<div class="col-lg-8 col-md-12">
					<div class="comment-form">
						<form method="post">
							<div class="row">

								<div class="col-sm-6">
									<input type="text" aria-required="true" name="contact-form-name" class="form-control"
										placeholder="Enter your name" aria-invalid="true" required >
								</div><!-- col-sm-6 -->
								<div class="col-sm-6">
									<input type="email" aria-required="true" name="contact-form-email" class="form-control"
										placeholder="Enter your email" aria-invalid="true" required>
								</div><!-- col-sm-6 -->

								<div class="col-sm-12">
									<textarea name="contact-form-message" rows="2" class="text-area-messge form-control"
										placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
								</div><!-- col-sm-12 -->
								<div class="col-sm-12">
									<button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
								</div><!-- col-sm-12 -->

							</div><!-- row -->
						</form>
					</div><!-- comment-form -->

					<h4><b>COMMENTS(12)</b></h4>

					<div class="commnets-area">

						<div class="comment">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>Katy Liu</b></a>
									<h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
								</div>

								<div class="right-area">
									<h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
								</div>

							</div><!-- post-info -->

							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
								ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
								Ut enim ad minim veniam</p>

						</div>

						<div class="comment">
							<h5 class="reply-for">Reply for <a href="#"><b>Katy Lui</b></a></h5>

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>Katy Liu</b></a>
									<h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
								</div>

								<div class="right-area">
									<h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
								</div>

							</div><!-- post-info -->

							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
								ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
								Ut enim ad minim veniam</p>

						</div>

					</div><!-- commnets-area -->

					<div class="commnets-area ">

						<div class="comment">

							<div class="post-info">

								<div class="left-area">
									<a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
								</div>

								<div class="middle-area">
									<a class="name" href="#"><b>Katy Liu</b></a>
									<h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
								</div>

								<div class="right-area">
									<h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
								</div>

							</div><!-- post-info -->

							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
								ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
								Ut enim ad minim veniam</p>

						</div>

					</div><!-- commnets-area -->

					<a class="more-comment-btn" href="#"><b>VIEW MORE COMMENTS</a>

				</div><!-- col-lg-8 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section>

@endsection

<!-- THIS IS JS AREA SECTION -->
@push('js')

@endpush
