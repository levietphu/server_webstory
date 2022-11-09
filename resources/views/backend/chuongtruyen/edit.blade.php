@extends('backend.layout.layout')
@section('title', 'Cập nhật chương truyện')
@section('text', 'Cập nhật chương truyện')
@section('text1', 'Chương truyện')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="{{route('chuongtruyen.update',[$id_truyen,$edit->id])}}" method="POST" role="form">	
					@csrf
					<div class="row">
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Tên chương</label>
							<input type="text" class="form-control" name="name_chapter" value="{{$edit->name_chapter}}">
							@error('name_chapter')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Số xu</label>
							<input type="number" max="100" min="0" class="form-control" name="coin" value="{{$edit->coin}}" >
						</div>
						<div class="form-group col-xs-12 col-sm-12 col-md-6">
							<label for="">Số chương</label>
							<input type="text" class="form-control" id="name" name="chapter_number" value="{{$edit->chapter_number}}" onkeyup="ChangeToSlug()" placeholder="Ví dụ: chương 1">
							@error('chapter_number')
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
						<div class="form-group col-xs-12 col-sm-12 col-md-12">
							<label for="">Nội dung chương</label>
							<textarea name="content" id="editor-ckeditor" class="form-control" rows="3" required="required">{{$edit->content}}</textarea>
							@error('content')
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
@endsection
