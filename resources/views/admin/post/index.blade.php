@extends('layouts.backend.app')

@section('title' , 'All Posts')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
	<a href="{{ route('admin.post.create') }}" class="btn btn-primary waves-effect"><i class="material-icons">add</i><span>Add New Post</span></a><br><br>
    <!-- Exportable Table -->
     <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div class="card">
                 <div class="header">
                     <h2>
                         All Post <span class="badge">{{ $posts->count() }}</span>
                     </h2>
                 </div>
                 <div class="body">
                     <div class="table-responsive">
                         <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Title</th>
                                     <th>Author</th>
                                     <th><i class="material-icons">visibility</i></th>
                                     <th>Status</th>
                                     <th>is_Approved</th>
                                     <th>Post Created</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>ID</th>
                                     <th>Title</th>
                                     <th>Author</th>
                                     <th><i class="material-icons">visibility</i></th>
                                     <th>Status</th>
                                     <th>is_Approved</th>
                                     <th>Post Created</th>
                                     <th>Action</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 @foreach ($posts as $key=>$post)
                                 	<tr>
                                     <td>{{ $key + 1 }}</td>
                                     <td>{{ str_limit($post->title, '15') }}</td>
                                     <td>{{ $post->user->name }}</td>
                                     <td>{{ $post->view_count }}</td>
                                     <td>
                                         @if ($post->status == 0)
                                             <div class="badge bg-red">Not publish</div>
                                         @else
                                            <div class="badge bg-blue">publish</div>
                                         @endif
                                     </td>
                                     <td>
                                         @if ($post->is_approved == 0)
                                             <div class="badge bg-red">Not Approved</div>
                                         @else
                                            <div class="badge bg-blue">Approved</div>
                                         @endif
                                     </td>
                                     <td>{{ $post->created_at->toFormattedDateString() }}</td>
                                     <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.post.show', $post->id) }}"><i class="material-icons">visibility</i></a>
                                         <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-primary btn-sm"><i class="material-icons">create</i></a>
                                         <button onclick="deletePost({{ $post->id }})" type="button" class="btn btn-danger btn-sm"><i class="material-icons">delete_sweep</i></button>
                                         <form action="{{ route('admin.post.destroy', $post->id ) }}" method="post" id="delete-form-{{ $post->id }}">
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
        function deletePost(id) {
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