@extends('backend.layout.layout')
@section('title', 'Thêm mới quảng cáo')
@section('content')
<div class="card-body">
	<form action="{{route('ads.store')}}" method="POST" role="form">
		@csrf
		<legend>Thêm mới quảng cáo</legend>
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
			<div class="form-group col-md-6">
				<label for="">value</label>
				<input type="text" class="form-control" name="value">
				
			</div>
			<div class="radio col-md-6">
				<label style="display: block;">Trạng thái</label>
				<label>
					<input type="radio" name="status"value="1" checked>
					Hiện
				</label>
				<label>
					<input type="radio" name="status" value="0">
					Ẩn
				</label>
			</div>
		</div>
		



		<button type="submit" class="btn btn-primary">Thêm mới</button>
	</form>
</div>
@endsection
