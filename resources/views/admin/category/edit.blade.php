@extends('layouts.backend.app')

@section('title' , 'Create category')

@push('css')
    
@endpush

@section('content')
    <div class="container-fluid">
                <!-- Vertical Layout -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <i class="material-icons">add</i> <span>Edit Category</span>
                                </h2>
                            </div>
                            <div class="body">
                                <form action="{{ route('admin.category.update', $category->id ) }}" method="post" enctype="multipart/form-data">
                                	@csrf
                                    @method('PUT')
                                    <label for="email_address">Category Name</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="email_address" class="form-control" placeholder="Enter Category Name" name="name" value="{{  $category->name }}">
                                        </div>
                                    </div>
                                    <label for="image">Thumbnail</label>
                                    <input type="file" name="image">
                                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Vertical Layout -->
            </div>
@endsection

@push('js')
    
@endpush