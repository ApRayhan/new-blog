@extends('layouts.backend.app')

@section('title' , 'DashBoard')

@push('css')
<script src="{{ asset('public/assets/backend/js/pages/index.js') }}"></script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">assignment</i>
                </div>
                <div class="content">
                    <div class="text">Tatal post</div>
                    <div class="number count-to" data-from="0" data-to="{{ $post->count() }}" data-speed="15" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">speaker_notes_off</i>
                </div>
                <div class="content">
                    <div class="text">Pending post</div>
                    <div class="number count-to" data-from="0" data-to="{{ $panding_posts->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">forum</i>
                </div>
                <div class="content">
                    <div class="text">Comments</div>
                    <div class="number count-to" data-from="0" data-to="{{ $comments->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">person_add</i>
                </div>
                <div class="content">
                    <div class="text">Total Author</div>
                    <div class="number count-to" data-from="0" data-to="{{ $user->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->

    <div class="row clearfix">
        <!-- Browser Usage -->
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">view_list</i>
                        </div>
                        <div class="content">
                            <div class="text">Category</div>
                            <div class="number count-to" data-from="0" data-to="{{ $category->count() }}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">label</i>
                        </div>
                        <div class="content">
                            <div class="text">Tags</div>
                            <div class="number count-to" data-from="0" data-to="{{ $tag->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">record_voice_over</i>
                        </div>
                        <div class="content">
                            <div class="text">Todey User</div>
                            <div class="number count-to" data-from="0" data-to="{{ $today_register }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Browser Usage -->
        <!-- Task Info -->
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
            <div class="card">
                <div class="header">
                    <h2>Top 4 Post</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-hover dashboard-task-infos">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Title</th>
                                    <th>View</th>
                                    <th>Favorite</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_post as $key=>$post)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ str_limit($post->title, 20) }}</td>
                                        <td>{{ $post->view_count }}</td>
                                        <td>{{ $post->favorite_to_users()->count() }}</td>
                                        <td>
                                            @if ($post->status == true)
                                                <span class="label bg-blue">Publish</span>
                                            @else
                                                <span class="label bg-red">Not Publish</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Task Info -->
    </div>
    <div class="card">
        <div class="header">
            <h2>Top 5 Users</h2>
        </div>
        <div class="body">
            <div class="table-responsive">
                <table class="table table-hover dashboard-task-infos">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Post</th>
                            <th>Comment</th>
                            <th>Favorite</th>
                            <th>Register time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($top_user as $key=>$user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->posts_count }}</td>
                            <td>{{ $user->comments_count }}</td>
                            <td>{{ $user->user_favorite_posts_count }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('public/assets/backend/plugins/jquery-countto/jquery.countTo.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('public/assets/backend/js/admin.js') }}"></script>
    <script src="{{ asset('public/assets/backend/js/pages/index.js') }}"></script>
@endpush