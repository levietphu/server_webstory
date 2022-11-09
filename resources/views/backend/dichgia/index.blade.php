@extends('backend.layout.layout')
@section('title', 'Dịch giả')
@section('text', 'Danh sách Dịch giả')
@section('text1', 'Dịch giả')
@section('content')
<div class="row fix-row mt-20">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<a class="btn btn-primary" href="{{route('dichgia.create')}}" style="margin: 30px 0 30px 0;">Thêm mới</a>
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
							<th>Slug</th>
							<th>Tùy chọn</th>
						</tr>
					</thead>
					<tbody>
						@foreach($dichgia as $value)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$value->name}}</td>
							<td>
								{{$value->slug}}
							</td>
							<td style="display: flex;">
								<a href="{{route('dichgia.edit', $value->id)}}" class="btn btn-primary" title="Cập nhật" style="margin-right: 5px;">Sửa</a>
                                <form action="{{route('dichgia.destroy', $value->id)}}" method="POST" role="form">
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
