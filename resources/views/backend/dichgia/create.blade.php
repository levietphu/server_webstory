@extends('backend.layout.layout')
@section('title', 'Thêm mới Dịch giả')
@section('text', 'Thêm mới Dịch giả')
@section('text1', 'Dịch giả')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="{{route('dichgia.store')}}" method="POST" role="form">	
					@csrf
					<div class="row">
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Tên Dịch giả</label>
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

						</div>						
					</div>								
					<button type="submit" class="btn btn-primary">Thêm mới</button>
				</form>				
			</div>
		</div>
	</div>
</div>
@endsection
