@extends('backend.layout.layout')
@section('title', 'Thêm mới Logo')
@section('content')
<div class="card-body">
	<form action="{{route('logo.store')}}" method="POST" role="form">
		@csrf
		<legend>Thêm mới Logo</legend>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="">Tên</label>
				<input type="text" class="form-control" id="name" placeholder="Nhập vào tên seri game" name="name" onkeyup="ChangeToSlug()">
				@error('name')
				    <div class="alert alert-danger">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group col-md-6">
				<label for="">Slug</label>
				<input type="text" class="form-control" id="slug" placeholder="" name="slug">
				@error('slug')
				    <div class="alert alert-danger">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="form-group col-xs-6 col-sm-6 col-md-6">
							<input type="hidden" name="value" id="image" class="form-control" value="">
							<a class="btn btn-primary" data-toggle="modal" href='#modal-image'>Ảnh</a>
							
							<img src="" alt="" width="100" id="img_image" style="display: block;">
							@error('value')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
			<div class="form-group">
				<div class="radio">
					<label>
						<input type="radio" name="status" class="form-control" value="1" checked="checked">
						Hiện
					</label>
					<label>
						<input type="radio" name="status" class="form-control" value="0">
						Ẩn
					</label>
				</div>
			</div>
		</div>



		<button type="submit" class="btn btn-primary">Thêm mới</button>
	</form>
</div>
<div class="modal fade" id="modal-image">
								<div class="modal-dialog" style="max-width: 70%;max-height: 400px;">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										</div>
										<div class="modal-body">
											<iframe src="{{url('filemanager')}}/dialog.php?type=1&editor=ckeditor&field_id=image" style="width: 90%;height: 360px;"></iframe>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
											<button type="button" class="btn btn-primary">Lưu lại</button>
										</div>
									</div>
								</div>
							</div>
@endsection
