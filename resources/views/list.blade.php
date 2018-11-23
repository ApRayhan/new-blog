<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
	<link rel="stylesheet" href="{{ asset('public/list/bootstrap.min.css') }}">
	
</head>
<body>
	<br>
	<div class="container">
		<div class="col-lg-offset-3 col-lg-6">
			<div class="panel panel-default" id="page">
				<div class="panel-heading title">
					Add Post <a href="#" class="pull-right" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i></a></div>
				<div class="panel-body">
					<ul class="list-group">
						@foreach ($lists as $list)
							<li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{ $list->title }}
							<input type="hidden" id="itemId" value="{{ $list->id }}">
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="title">Modal title</h4>
		      </div>
		      <div class="modal-body">
				<input type="hidden" id="id">
		        <input id="input" type="text" name="title" class="form-control">
		        @csrf
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete" style="display: none">Delete</button>
		        <button type="button" class="btn btn-primary" id="editBtn" style="display: none">Edit Item</button>
		        <button type="button" class="btn btn-primary" id="addBtn" data-dismiss="modal">Add Item</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	<script src="{{ asset('public/list/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('public/list/bootstrap.min.js') }}"></script>
	<script>
			$(document).ready(function(){
				$(document).on('click', '.ourItem', function(event) {
					$(this).click(function(event){
						$('#title').text('Edit Post');
						var text = $(this).text();
						var id = $(this).find('#itemId').val();
						$('#input').val(text);
						$('#delete').show('400');
						$('#editBtn').show('400');
						$('#addBtn').hide();
						$('#id').val(id);
						console.log(text);
					})
				})
				$(document).on('click', '.title', function(event) {
					$('#title').text('Add New Post');
					$('#input').val('');
					$('#delete').hide('400');
					$('#editBtn').hide('400');
					$('#addBtn').show('400');
				})
				$(document).on('click', '#addBtn', function(event) {
					var text = $('#input').val();
					$.post('list', {'title': text, '_token': $('input[name=_token]').val()}, function(data) {
						$('#page').load(location.href + ' #page');
						console.log(data);
					});
				});
				$('#delete').click(function(event) {
					var id= $('#id').val();
					$.post('delete', {'id' : id,'_token': $('input[name=_token]').val()}, function(data) {
						$('#page').load(location.href + ' #page');
						console.log(data);
					});
				});
				
			});
	</script>
</body>
</html>