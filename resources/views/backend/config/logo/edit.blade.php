@extends('backend.layout.layout')
@section('title', 'Cập nhật logo')
@section('text', 'Cập nhật logo')
@section('text1', 'Logo')
@section('content')
<div class="row fix-row">
	<div class="col-12">
		<div class="card" >
			<div class="card-body">
				<form action="{{route('logo.update', $logo->id)}}" method="POST" role="form">
					@method('PUT')
					@csrf
					<div class="row">
						<div class="form-group col-md-6">
							<label for="">Tên</label>
							<input type="text" class="form-control" id="name" value="{{$logo->name}}" name="name" onkeyup="ChangeToSlug()">
							@error('name')
							<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-md-6">
							<label for="">Slug</label>
							<input type="text" class="form-control" id="slug" placeholder="" name="slug" value="{{$logo->slug}}">
							@error('slug')
							<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<input type="hidden" class="form-control" id="image" name="value" value="{{$logo->value}}">
							<a class="btn btn-primary" data-toggle="modal" href='#modal-image'>Logo</a>
							<img src="{{url('public/uploads/Config')}}/{{$logo->value}}" alt="" id="img_image" style="max-width: 150px; display: block; margin-bottom: 20px;">
							@error('value')
							<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="radio col-md-6">
							<label style="display: block;">Trạng thái</label>
							<label>
								<input type="radio" name="status"value="1" {!!($logo->status==1?'checked':'')!!}>
								Hiện
							</label>
							<label>
								<input type="radio" name="status" value="0" {!!($logo->status==0?'checked':'')!!}>
								Ẩn
							</label>
						</div>
					</div>



					<button type="submit" class="btn btn-primary">Cập nhật</button>
				</form>
			</div>
		</div>
	</div>
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
