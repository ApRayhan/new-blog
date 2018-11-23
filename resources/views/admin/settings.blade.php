@extends('layouts.backend.app')

@section('title' , 'Update Profile')

@push('css')

@endpush

@section('content')
<div class="container-fluid">
   <div class="card">
    <div class="header">
        <h2>
            Update Profile
        </h2>
    </div>
    <div class="body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#profile_with_icon_title" data-toggle="tab" aria-expanded="false">
                    <i class="material-icons">face</i> PROFILE
                </a>
            </li>
            <li role="presentation" class="">
                <a href="#messages_with_icon_title" data-toggle="tab" aria-expanded="false">
                    <i class="material-icons">lock</i> Change Password
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="profile_with_icon_title">
                <b>Update Profile</b>
                <p>
                    <div class="body">
                        <form action="{{ route('admin.update.profile') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PUT')
                            <label for="name">Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <label for="name">Email</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="name" class="form-control" placeholder="Email" name="email" value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                            <label for="name">About</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea name="about" class="form-control">{{ Auth::user()->about }}</textarea>
                                </div>
                            </div>
                            <label for="name">Image</label>
                            <div class="form-group">
                                <input type="file" name="image">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                        </form>
                    </div>
                </p>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="messages_with_icon_title">
        <b>Change Password</b>
        <p>
            <div class="body">
                <form action="{{ route('admin.update.password') }}" method="post">
                    @csrf
                    @method('PUT')
                    <label for="old_password">Old Password</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="password" id="old_password" class="form-control" placeholder="Enter your Old Password" name="old_password">
                        </div>
                    </div>
                    <label for="password">New Password</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password">
                        </div>
                    </div>
                    <label for="password">Confirm Password</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password_confirmation">
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                </form>
            </div>
        </p>
    </div>
</div>
</div>
</div>           
</div>
@endsection

@push('js')

@endpush