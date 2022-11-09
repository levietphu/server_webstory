@extends('backend.layout.layout')
@section('title', 'Danh sách truyện')
@section('text', 'Danh sách truyện')
@section('text1', 'Truyện')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<a class="btn btn-primary" href="{{route('truyen.create')}}" style="margin: 30px 0 30px 0;">Thêm mới</a>
				@if(session()->has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong></strong> {{ session()->get('success') }}
				</div>
				@endif
				<table class="table table-bordered nowrap dataTable no-footer dtr-inline table-hover" id="myTable" aria-describedby="datatable-buttons_info">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên</th>
							<th>Trạng thái</th>
							<th>Dạng</th>
							<th>Hiển thị</th>
							<th>Tổng số chương</th>
							<th>Tùy chọn</th>
						</tr>
					</thead>
					<tbody>
						@foreach($truyen as $value)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td class="name_story">{{$value->name}}</td>
							<td>
								{!!($value->full == 0)?'<span class="badge badge-primary">Truyện đang ra</span>':'<span class="badge badge-success">Truyện đã hoàn thành</span>'!!}
							</td>
							<td>
								{!!($value->vip == 1)?'<span class="badge badge-primary">Truyện Vip</span>':'<span class="badge badge-success">Truyện Miễn phí</span>'!!}
							</td>
							<td>
								{!!($value->status == 1)?'<span class="badge badge-primary">có</span>':'<span class="badge badge-success">Không</span>'!!}
							</td>
							<td>
								{{$value->chuong->count()}}
							</td>
							<td style="display: flex;">
								<a href="{{route('chuongtruyen.index', $value->id)}}" class="btn btn-primary mg-r" style="margin-right: 5px;" title="Chương truyện" >Chapter</a>
								<a href="{{route('truyen.edit', $value->id)}}" class="btn btn-primary" title="Sửa" style="margin-right: 5px;" title="Cập nhật">Sửa</a>
                                <form action="{{route('truyen.destroy', $value->id)}}" method="POST" role="form">
									@method('DELETE') @csrf
									<button type="submit" class="btn btn-danger" title="Xóa" onclick="return confirm('Bạn có muốn xóa truyện {{$value->name}} này không');">Xóa</button>
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
