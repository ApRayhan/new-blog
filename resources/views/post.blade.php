@extends('layouts.frontend.app')

@section('title' , 'post')

@push('css')
 	<!-- Stylesheets -->
	<link href="{{ asset('public/assets/frontend/css/single-post-1/css/styles.css') }}" rel="stylesheet">
	<link href="{{ asset('public/assets/frontend/css/single-post-1/css/responsive.css') }}" rel="stylesheet">
	<style>
	    .favorite_post {
	        color: blue;
	    }
	</style>
@endpush

@section('content')
<section class="post-area section">
	<div class="container">

		<div class="row">

			<div class="col-lg-8 col-md-12 no-right-padding">

				<div class="main-post">

					<div class="blog-post-inner">
						<div class="post-info">
							<div class="left-area">
								<a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('profileimg/'. $post->user->image) }}" alt="Profile Image"></a>
							</div>
							<div class="middle-area">
								<a class="name" href="#"><b>{{ $post->user->name }}</b></a>
								<h6 class="date">{{ $post->created_at->toFormattedDateString() }}</h6>
							</div>

						</div><!-- post-info -->

						
						<h3 class="title"><b>{{ $post->title }}</b></h3>

						<p class="para">{!! html_entity_decode($post->body) !!}</p>
						<ul class="tags">
							@foreach ($post->tags as $tag)
								<li><a href="{{ route('tags.post', $tag->slug) }}">{{ $tag->name }}</a></li>
							@endforeach
							
						</ul>
					</div><!-- blog-post-inner -->

					<div class="post-icons-area">
						<ul class="post-icons">
							<li>
								@guest
								<a href="javascript:void(0)" onclick="toastr.info('To Add A Favorite Post You Need To Login First', 'info', {
									closeButton: true,
									progressBar: true, 
								})"><i class="ion-heart"></i> {{ $post->favorite_to_users->count() }} </a>
								@else
								<a href="javascript:void(0);" onclick="document.getElementById('add-favorite-{{ $post->id }}').submit(); " class="{{ !Auth::user()->user_favorite_posts->where('pivot.post_id', $post->id)->count() == 0 ? 'favorite_post' : '' }}"><i class="ion-heart"></i> {{ $post->favorite_to_users->count() }} </a>

								<form action="{{ route('add.favorite', $post->id) }} " method="post" id="add-favorite-{{ $post->id }}">
									@csrf
								</form>
								@endguest
							</li>
							<li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
							<li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
						</ul>

						<ul class="icons">
							<li>SHARE : </li>
							<li><a href="#"><i class="ion-social-facebook"></i></a></li>
							<li><a href="#"><i class="ion-social-twitter"></i></a></li>
							<li><a href="#"><i class="ion-social-pinterest"></i></a></li>
						</ul>
					</div>


				</div><!-- main-post -->
			</div><!-- col-lg-8 col-md-12 -->

			<div class="col-lg-4 col-md-12 no-left-padding">

				<div class="single-post info-area">

					<div class="sidebar-area about-area">
						<h4 class="title"><b>ABOUT {{ $post->user->name }}</b></h4><br>
						<small>{{ $post->user->about }}</small>
						
					</div>

					<div class="tag-area">

						<h4 class="title"><b>Category</b></h4>
						<ul>
							@foreach ($post->categorys as $category)
								<li><a href="{{ route('category.post', $category->slug) }}">{{ $category->name }}</a></li>
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

							<div class="blog-image"><img src="{{ Storage::disk('public')->url('post/'. $randompost->image) }}" alt="Blog Image"></div>

							<a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('profileimg/'. $randompost->user->image) }}" alt="Profile Image"></a>

							<div class="blog-info">

								<h4 class="title"><a href="#"><b>{{ $randompost->title }}</b></a></h4>

								<ul class="post-footer">
									<li>
										@guest
										<a href="javascript:void(0)" onclick="toastr.info('To Add A Favorite Post You Need To Login First', 'info', {
											closeButton: true,
											progressBar: true, 
										})"><i class="ion-heart"></i> {{ $post->favorite_to_users->count() }} </a>
										@else
										<a href="javascript:void(0);" onclick="document.getElementById('add-favorite-{{ $randompost->id }}').submit(); " class="{{ !Auth::user()->user_favorite_posts->where('pivot.post_id', $randompost->id)->count() == 0 ? 'favorite_post' : '' }}"><i class="ion-heart"></i> {{ $randompost->favorite_to_users->count() }} </a>

										<form action="{{ route('add.favorite', $post->id) }} " method="post" id="add-favorite-{{ $post->id }}">
											@csrf
										</form>
										@endguest
									</li>
									<li><a href="#"><i class="ion-chatbubble"></i>{{ $randompost->comments->count() }}</a></li>
									<li><a href="#"><i class="ion-eye"></i>{{ $randompost->view_count }}</a></li>
								</ul>

							</div><!-- blog-info -->
						</div><!-- single-post -->
					</div><!-- card -->
				</div><!-- col-md-6 col-sm-12 -->
			@endforeach



		</div><!-- row -->

	</div><!-- container -->
</section>

<section class="comment-section">
	<div class="container">
		<h4><b>POST COMMENT</b></h4>
		<div class="row">

			<div class="col-lg-8 col-md-12">
				@guest
					<p>Want To Add A Comment You Need To Login First</p>
				@else
				<div class="comment-form">
					<form method="post" action="{{ route('add.comment', $post->id) }}">
						@csrf
						<div class="row">

							<div class="col-sm-12">
								<textarea name="comment" rows="2" class="text-area-messge form-control"
								placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
							</div><!-- col-sm-12 -->
							<div class="col-sm-12">
								<button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
							</div><!-- col-sm-12 -->

						</div><!-- row -->
					</form>
				</div><!-- comment-form -->
				@endguest

				<h4><b>COMMENTS({{ $post->comments->count() }})</b></h4>

				@foreach ($post->comments as $comment)
					<div class="commnets-area ">

					<div class="comment">

						<div class="post-info">

							<div class="left-area">
								<a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('profileimg/'. $comment->user->image) }}" alt="Profile Image"></a>
							</div>

							<div class="middle-area">
								<a class="name" href="#"><b>{{ $comment->user->name }}</b></a>
								<h6 class="date">on {{ $comment->created_at->diffForHumans() }}</h6>
							</div>

							<div class="right-area">
								<h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
							</div>

						</div><!-- post-info -->

						<p>{{ $comment->comments }}</p>

					</div>

				</div><!-- commnets-area -->
				@endforeach

				<a class="more-comment-btn" href="#"><b>VIEW MORE COMMENTS</a>

				</div><!-- col-lg-8 col-md-12 -->

			</div><!-- row -->

		</div><!-- container -->
	</section>

	
@endsection

@push('js')
    
@endpush