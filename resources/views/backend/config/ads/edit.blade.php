@extends('backend.layout.layout')
@section('title', 'Cập nhật quảng cáo')
@section('text', 'Cập nhật quảng cáo')
@section('text1', 'Quảng cáo')
@section('content')
<div class="row fix-row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="{{route('ads.update', $ads->id)}}" method="POST" role="form">
					@method('PUT')
					@csrf
					<div class="row">
						<div class="form-group col-md-6">
							<label for="">Tên</label>
							<input type="text" class="form-control" id="name" value="{{$ads->name}}" name="name" onkeyup="ChangeToSlug()">
							@error('name')
							<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-md-6">
							<label for="">Slug</label>
							<input type="text" class="form-control" id="slug" placeholder="" name="slug" value="{{$ads->slug}}">
							@error('slug')
							<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
				<label for="">value</label>
					<input type="text" class="form-control" name="value" value="{{$ads->value}}">
					
				</div>
						<div class="radio col-md-6">
							<label style="display: block;">Trạng thái</label>
							<label>
								<input type="radio" name="status"value="1" {!!($ads->status==1?'checked':'')!!}>
								Hiện
							</label>
							<label>
								<input type="radio" name="status" value="0" {!!($ads->status==0?'checked':'')!!}>
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
@endsection
