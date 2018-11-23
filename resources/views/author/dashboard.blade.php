@extends('layouts.backend.app')

@section('title' , 'DashBoard')

@push('css')
    <script src="{{ asset('public/assets/backend/js/pages/index.js') }}"></script>
@endpush

@section('content')
        <div class="container-fluid">
            <div class="block-header">
                <h2>Author DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">library_books</i>
                        </div>
                        <div class="content">
                            <div class="text">Pending Post</div>
                            <div class="number count-to" data-from="0" data-to="{{ $pending_post->count() }}" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">favorite_border</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Favorite</div>
                            <div class="number count-to" data-from="0" data-to="{{ Auth::user()->user_favorite_posts()->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">COMMENTS</div>
                            <div class="number count-to" data-from="0" data-to="{{ Auth::user()->comments->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">visibility</i>
                        </div>
                        <div class="content">
                            <div class="text">Total View</div>
                            <div class="number count-to" data-from="0" data-to="{{ $total_view }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>TASK INFOS</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Title</th>
                                            <th>View</th>
                                            <th>Comment</th>
                                            <th>Total Favorite</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($top_post as $key=>$post)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $post->title }}</td>
                                                <td>{{ $post->view_count }}</td>
                                                <td>{{ $post->comments_count }}</td>
                                                <td>{{ $post->favorite_to_users_count }}</td>
                                                <td>
                                                    @if ($post->status == true )
                                                        <span class="label bg-green">Public</span>
                                                    @else
                                                        <span class="label bg-green">Not Public</span>
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
        </div>
@endsection

@push('js')
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('public/assets/backend/plugins/jquery-countto/jquery.countTo.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('public/assets/backend/js/admin.js') }}"></script>
    <script src="{{ asset('public/assets/backend/js/pages/index.js') }}"></script>
@endpush