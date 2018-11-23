@extends('layouts.frontend.app')

@section('title' , 'Welcome')

@push('css')
<link href="{{ asset('public/assets/frontend/css/homepage/styles.css') }}" rel="stylesheet">

<link href="{{ asset('public/assets/frontend/css/homepage/responsive.css') }}" rel="stylesheet">
<style>
    .favorite_post {
        color: blue;
    }
</style>
@endpush

@section('content')
<section class="blog-area section">
    <div class="container">

        <div class="row">

            @foreach ($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="single-post post-style-1">

                            <div class="blog-image"><img src="{{ Storage::disk('public')->url('post/'. $post->image) }}" alt="Blog Image"></div>

                            <a class="avatar" href="#"><img src="images/icons8-team-355979.jpg" alt="Profile Image"></a>

                            <div class="blog-info">

                                <h4 class="title"><a href="{{ route('post.show', $post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                                <ul class="post-footer">
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

                            </div><!-- blog-info -->
                        </div><!-- single-post -->
                    </div><!-- card -->
                </div><!-- col-lg-4 col-md-6 -->
            @endforeach

        </div><!-- row -->

    </div><!-- container -->
</section><!-- section -->
@endsection

@push('js')

@endpush