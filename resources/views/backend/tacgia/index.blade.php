@extends('backend.layout.layout')
@section('title', 'Tác giả')
@section('text', 'Danh sách tác giả')
@section('text1', 'Tác giả')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<a class="btn btn-primary" href="{{route('tacgia.create')}}" style="margin: 30px 0 30px 0;">Thêm mới</a>
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
							<th>Tùy chọn</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tacgia as $value)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$value->name}}</td>
							<td>
								{!!($value->status == 1)?'<span class="badge badge-success">Hiện</span>':'<span class="badge badge-danger">Ẩn</span>'!!}
							</td>
							<td style="display: flex;">
								<a href="{{route('tacgia.edit', $value->id)}}" class="btn btn-primary" title="Cập nhật" style="margin-right: 5px;">Sửa</a>
                                <form action="{{route('tacgia.destroy', $value->id)}}" method="POST" role="form">
									@method('DELETE') @csrf
									<button type="submit" class="btn btn-danger" title="Xóa" onclick="return confirm('Bạn có muốn xóa tác giả {{$value->name}} này không');">Xóa</button>
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
