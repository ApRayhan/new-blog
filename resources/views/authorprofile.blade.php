@extends('layouts.frontend.app')

@section('title' , 'Welcome')

@push('css')
    <link href="{{ asset('public/assets/frontend/css/blog-sidebar/css/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('public/assets/frontend/css/blog-sidebar/css/responsive.css') }}" rel="stylesheet">
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

            <div class="col-lg-8 col-md-12">
                <div class="row">
                    @foreach ($posts as $post)
                    <div class="col-lg-6 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ Storage::disk('public')->url('post/'. $post->image) }}" alt="Blog Image"></div>

                                <a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('profileimg/'. $post->user->image) }}" alt="Profile Image"></a>

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

            </div><!-- col-lg-8 col-md-12 -->

            <div class="col-lg-4 col-md-12 ">

                <div class="single-post info-area ">

                    <div class="about-area">
                        <h4 class="title"><b>ABOUT {{ $user->name }}</b></h4>
                        <p> {{ $user->created_at->diffForHumans() }}</p>
                    </div>

                </div><!-- info-area -->

            </div><!-- col-lg-4 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section><!-- section -->


<footer>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="footer-section">

                    <a class="logo" href="#"><img src="images/logo.png" alt="Logo Image"></a>
                    <p class="copyright">Bona @ 2017. All rights reserved.</p>
                    <p class="copyright">Designed by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
                    <ul class="icons">
                        <li><a href="#"><i class="ion-social-facebook-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-twitter-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-vimeo-outline"></i></a></li>
                        <li><a href="#"><i class="ion-social-pinterest-outline"></i></a></li>
                    </ul>

                </div><!-- footer-section -->
            </div><!-- col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section><!-- section -->
@endsection

@push('js')

@endpush