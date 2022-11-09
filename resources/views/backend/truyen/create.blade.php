@extends('backend.layout.layout')
@section('title', 'Thêm mới Truyện')
@section('text', 'Thêm mới Truyện')
@section('text1', 'Truyện')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="{{route('truyen.store')}}" method="POST" role="form">	
					@csrf
					<div class="row">
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Tên truyện</label>
							<input type="text" class="form-control" id="name" name="name" onkeyup="ChangeToSlug()">
							@error('name')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>	
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Slug</label>
							<input type="text" class="form-control" id="slug" name="slug">
							@error('slug')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Giới thiệu</label>
							<textarea name="introduce" id="editor-ckeditor" class="form-control" rows="3" required="required"></textarea>
							@error('introduce')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="form-group col-xs-6 col-sm-6 col-md-6">
							<label for="">Khuyến mãi</label>
							<textarea name="discount" id="editor" class="form-control" rows="3" required="required"></textarea>
							
						</div>
						<div class="form-group col-xs-6 col-sm-6 col-md-4">
							<input type="hidden" name="image" id="image" class="form-control" value="">
							<a class="btn btn-primary" data-toggle="modal" href='#modal-image'>Ảnh</a>
							
							<img src="" alt="" width="100" id="img_image" style="display: block;">
							@error('image')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Thể loại</label>
							<select name="id_theloai[]" id="input" class="form-control select-2" multiple>
								<option value="">Tùy chọn</option>
								@foreach($theloai as $key => $value)
								<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							</select>
							@error('id_theloai')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Tác giả</label>
							<select name="id_tacgia" class="form-control select-2">
								<option value="">Tùy chọn</option>
								@foreach($tacgia as $key => $value)
								<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							</select>
							@error('id_tacgia')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Dịch giả</label>
							<select name="id_trans" class="form-control select-2">
								<option value="">Tùy chọn</option>
								@foreach($dichgia as $key => $value)
								<option value="{{$value->id}}">{{$value->name}}</option>
								@endforeach
							</select>
r
						</div>
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Truyện full</label>
							<select name="full" class="form-control select-2">
								<option value="">Tùy chọn</option>
								<option value="1">Truyện đã full</option>
								<option value="0">Truyện đang ra</option>
							</select>
							
						</div>		
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Truyện Vip</label>
							<select name="vip" class="form-control select-2">
								<option value="">Tùy chọn</option>
								<option value="1">Truyện vip</option>
								<option value="0">Truyện free</option>
							</select>
							
						</div>		
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Truyện Đề xuất</label>
							<select name="recommended" class="form-control select-2">
								<option value="">Tùy chọn</option>
								<option value="1">Có</option>
								<option value="0">Không</option>
							</select>
							
						</div>	
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Truyện Hot</label>
							<select name="hot" class="form-control select-2">
								<option value="">Tùy chọn</option>
								<option value="1">Có</option>
								<option value="0">Không</option>
							</select>
						</div>		
						<div class="form-group col-xs-4 col-sm-4 col-md-4">
							<label for="">Trạng thái</label>
							<select name="status" class="form-control select-2">
								<option value="">Tùy chọn</option>
								<option value="0">unpublish</option>
								<option value="1" selected>publish</option>
							</select>
							@error('status')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>				
					</div>								
					<button type="submit" class="btn btn-primary">Thêm mới</button>
				</form>				
			</div>
		</div>
	</div>
</div>
{{-- Sự kiện upload ảnh --}}
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
