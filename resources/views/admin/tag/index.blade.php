@extends('layouts.backend.app')

@section('title' , 'Tag')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush

@section('content')
	<a href="{{ route('admin.tag.create') }}" class="btn btn-primary waves-effect"><i class="material-icons">add</i><span>Add New Tag</span></a><br><br>
    <!-- Exportable Table -->
     <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div class="card">
                 <div class="header">
                     <h2>
                         All Tags
                     </h2>
                 </div>
                 <div class="body">
                     <div class="table-responsive">
                         <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Name</th>
                                     <th>Slug</th>
                                     <th>Crate Time</th>
                                     <th>Update Time</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>ID</th>
                                     <th>Name</th>
                                     <th>Slug</th>
                                     <th>Crate Time</th>
                                     <th>Update Time</th>
                                     <th>Action</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 @foreach ($tags as $key=>$tag)
                                 	<tr>
                                     <td>{{ $key + 1 }}</td>
                                     <td>{{ $tag->name }}</td>
                                     <td>{{ $tag->slug }}</td>
                                     <td>{{ $tag->created_at->toFormattedDateString() }}</td>
                                     <td>{{ $tag->updated_at->toFormattedDateString() }}</td>
                                     <td>
                                         <a href="{{ route('admin.tag.edit', $tag->id) }}" class="btn btn-primary btn-sm"><i class="material-icons">create</i></a>
                                         <button onclick="deleteTag({{ $tag->id }})" type="button" class="btn btn-primary btn-sm"><i class="material-icons">delete_sweep</i></button>
                                         <form action="{{ route('admin.tag.destroy', $tag->id ) }}" method="post" id="delete-form-{{ $tag->id }}">
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
        function deleteTag(id) {
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