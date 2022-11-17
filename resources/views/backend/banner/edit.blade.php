@extends('backend.layout.layout')
@section('title', 'Sửa Banner')
@section('text', 'Sửa Banner')
@section('text1', 'Banner')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="{{route('banner.update',$edit->id)}}" method="POST" role="form">	
				@method('PUT')	@csrf
					<div class="row">
						<div class="form-group col-xs-4 col-sm-4 col-md-6">
							<label for="">Truyện</label>
							<select name="id_truyen" class="form-control select-2" id="story">
								<option value="">Tùy chọn</option>
								@foreach($truyen as $key => $value)
								<option value="{{$value->id}}" {{$value->id === $edit->id_truyen?"selected":""}}>{{$value->name}}</option>
								@endforeach
							</select>
							@error('id_tacgia')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Tên tác giả</label>
							<input type="text" class="form-control" id="name" name="name" onkeyup="ChangeToSlug()" value="{{$edit->name}}">
							@error('name')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>	
						
						<div class="form-group col-xs-6 col-sm-6 col-md-6">
							<input type="hidden" name="image" id="image" class="form-control" value="{{$edit->image}}">
							<a class="btn btn-primary" data-toggle="modal" href='#modal-image'>Ảnh</a>
							
							<img src="{{url('public/uploads')}}/{{$edit->image}}" alt="" width="100" id="img_image" style="display: block;">
							@error('image')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
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
											<iframe src="{{url('filemanager')}}/dialog.php?type=1&editor=ckeditor&field_id=image&output=embed" style="width: 90%;height: 360px;"></iframe>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
											<button type="button" class="btn btn-primary">Lưu lại</button>
										</div>
									</div>
								</div>
							</div>
@endsection
