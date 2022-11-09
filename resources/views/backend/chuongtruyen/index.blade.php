@extends('backend.layout.layout')
@section('title', 'Chương truyện')
@section('text', 'Danh sách Chương truyện: '.'('.$name.')' )
@section('text1', 'Chương truyện')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<a class="btn btn-primary" href="{{route('chuongtruyen.create',$id_truyen)}}" style="margin: 30px 0 30px 0;">Thêm mới</a>
				@if(session()->has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong></strong> {{ session()->get('success') }}
				</div>
				@endif
				<table class="table table-bordered" id="myTable">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên chương</th>
							<th>số chương</th>
							<th>Số xu</th>
							<th>Tùy chọn</th>
						</tr>
					</thead>
					<tbody>
						@foreach($chuongtruyen as $value)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$value->name_chapter}}</td>
							<td>
								{{$value->chapter_number}}
							</td>
							<td>
								{{$value->coin}} xu
							</td>
							<td style="display: flex;">
								<a href="{{route('chuongtruyen.edit', [$value->id_truyen,$value->id])}}" class="btn btn-primary" title="Cập nhật" style="margin-right: 5px;">Sửa</a>
                                <form action="{{route('chuongtruyen.destroy', $value->id)}}" method="POST" role="form">
									@method('DELETE') @csrf
									<button type="submit" class="btn btn-danger" title="Xóa" onclick="return confirm('Bạn có muốn xóa chương {{$value->chapter_number}}:{{$value->name_chapter}} này không');">Xóa</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
@endsection
