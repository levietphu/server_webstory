@extends('backend.layout.layout')
@section('title', 'Sửa dịch giả')
@section('text', 'Sửa dịch giả')
@section('text1', 'dịch giả')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="{{route('dichgia.update',$edit->id)}}" method="POST" role="form">	
					@csrf
					<div class="row">
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Tên dịch giả</label>
							<input type="text" class="form-control" id="name" name="name" onkeyup="ChangeToSlug()" value="{{$edit->name}}">
							@error('name')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>	
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Slug</label>
							<input type="text" class="form-control" id="slug" name="slug" value="{{$edit->slug}}">
							@error('slug')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						</div>						
					</div>								
					<button type="submit" class="btn btn-primary">Cập nhật</button>
				</form>				
			</div>
		</div>
	</div>
</div>
@endsection
