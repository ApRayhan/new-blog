@extends('layouts.backend.app')

@section('title' , 'Edit Post')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('public/assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <form action="{{ route('author.post.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <!-- Vertical Layout -->
                <div class="row clearfix">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <i class="material-icons">add</i> <span>Post Title & Thumbnail</span>
                                </h2>
                            </div>
                            <div class="body">
                                    <label for="email_address">Title</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="email_address" class="form-control" placeholder="Enter Post Title" name="title" value="{{ $post->title }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Thumbnail</label>
                                        <input type="file" name="image">
                                    </div>
                                    <input id="publish" class="filled-in" type="checkbox" name="status" value="1" {{ $post->status == true ? 'checked' : '' }}>
                                    <label for="publish">Publish</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <span>Category & Tags</span>
                                </h2>
                            </div>
                            <div class="body">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="category">Select Category</label>
                                        <select id="category" class="form-control show-tick" data-live-search="true" name="categorys[]" multiple>
                                            @foreach ($categorys as $category)
                                                <option value="{{ $category->id }}"
                                                @foreach ($post->categorys as $postcategory)
                                                    {{ $postcategory->id == $category->id ? 'selected' : '' }}
                                                @endforeach
                                        >{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="tag">Select Tags</label>
                                        <select id="category" class="form-control show-tick" data-live-search="true" name="tags[]" multiple>
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                @foreach ($post->tags as $posttags)
                                                    {{ $posttags->id == $tag->id ? 'selected' : '' }}
                                                @endforeach>{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect">Submit</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <i class="material-icons">add</i> <span>Post Body</span>
                                </h2>
                            </div>
                            <div class="body">
                                <textarea id="tinymce" name="body">{{ $post->body }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Vertical Layout -->
        </form>
    </div>
@endsection

@push('js')
  <!-- Select Plugin Js -->
    <script src="{{ asset('public/assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- TinyMCE -->
    <script src="{{ asset('public/assets/backend/plugins/tinymce/tinymce.js') }}"></script>
    <script>
        $(function () {
            
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('public/assets/backend/plugins/tinymce') }}';
})
    </script>
@endpush