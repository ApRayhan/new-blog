@extends('layouts.backend.app')

@section('title' , 'Tag')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
    
    <!-- Exportable Table -->
     <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div class="card">
                 <div class="header">
                     <h2>
                         All Comments
                     </h2>
                 </div>
                 <div class="body">
                     <div class="table-responsive">
                         <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                             <thead>
                                 <tr>
                                     <th>Comment info</th>
                                     <th>Post info</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>Comment info</th>
                                     <th>Post info</th>
                                     <th>Action</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                @foreach ($commenst as $comment)
                                <tr>
                                 <td>
                                    <div class="media-left">
                                        <img class="media-object" src="{{ Storage::disk('public')->url('profileimg/'. $comment->user->image ) }}" width="64" height="64">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            {{ $comment->user->name }}
                                            <small>
                                                {{ $comment->created_at->diffForHumans() }}
                                            </small>
                                        </h4>

                                        <p>{{ $comment->comments }}</p>
                                        <a href="">Reply</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="media-left">
                                        <img class="media-object" src="{{ Storage::disk('public')->url('post/'. $comment->post->image ) }}" width="64" height="64">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            {{ $comment->post->user->name }}
                                            <small>
                                                {{ $comment->post->created_at->diffForHumans() }}
                                            </small>
                                        </h4>

                                        <p>{{ str_limit($comment->post->title, 25) }}</p>
                                        <a href="">Read</a>
                                    </div>
                                </td>
                                <td>
                                    <button onclick="deleteComment({{ $comment->id }})" type="button" class="btn btn-primary btn-sm"><i class="material-icons">delete_sweep</i></button>
                                    <form action="{{ route('admin.comment.delete', $comment->id ) }}" method="post" id="delete-form-{{ $comment->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td> 
                            </tr>

                            @endforeach
                                
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- #END# Exportable Table -->
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('public/assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        function deleteComment(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
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