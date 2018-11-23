@extends('layouts.backend.app')

@section('title' , 'Create Post')

@push('css')
<!-- Bootstrap Select Css -->
<link href="{{ asset('public/assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout -->
    @if ($post->is_approved == true)
    <button class="btn btn-primary pull-right" type="button" disabled>
        <i class="material-icons">done</i>
        <span> Approved</span>
    </button>
    @else
    <button class="btn btn-danger pull-right" type="button" onclick="approvePost({{ $post->id }})">
        <i class="material-icons">close</i>
        <span>Not Approved</span>
    </button>
    @endif
    <form method="post" action="{{ route('admin.approve.post', $post->id) }}" style="display: none;" id="approve-form">
        @csrf
        @method('PUT')
    </form>
    <br><br>
    <div class="row clearfix">

        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{ $post->title }} <small>Created By {{ $post->user->name }} on {{ $post->created_at->toFormattedDateString() }}</small>
                    </h2>
                </div>
                <div class="body">
                    {!! $post->body !!} 
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-blue">
                    <h2 class="">
                        Categorys
                    </h2>
                </div>
                <div class="body">
                    @foreach ($post->categorys as $category)
                    <span class="label bg-blue">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="header bg-green">
                    <h2 class="">
                        Tags
                    </h2>
                </div>
                <div class="body">
                    @foreach ($post->tags as $tag)
                    <span class="label bg-green">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="header bg-pink">
                    <h2 class="">
                        Thumbnail
                    </h2>
                </div>
                <div class="body">
                    <img class="img-responsive thumbnail" src="{{ Storage::disk('public')->url('post/'. $post->image) }}">
                </div>
            </div>
        </div>

    </div>
</div>
<!-- #END# Vertical Layout -->

</div>
@endsection

@push('js')
<!-- Select Plugin Js -->
<script src="{{ asset('public/assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<!-- TinyMCE -->
<script src="{{ asset('public/assets/backend/plugins/tinymce/tinymce.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
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
     function approvePost(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't Approved The Post :) ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approved it !',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('approve-form').submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
    @endpush