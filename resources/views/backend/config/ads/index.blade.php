@extends('backend.layout.layout')
@section('title', 'Danh sách quảng cáo')
@section('text', 'Quảng cáo')
@section('text1', 'Cấu hình')
@section('content')
<div class="row fix-row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<a href="{{route('ads.create')}}" class="btn btn-success" style="margin: 30px 0 30px 0;">Thêm mới</a>
				@if(session()->has('success'))
				<div class="alert alert-success">
					{{ session()->get('success') }}
				</div>
				@endif
				<table class="table table-bordered nowrap dataTable no-footer dtr-inline table-hover" id="table_id" aria-describedby="datatable-buttons_info">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên</th>
							<th>Giá trị</th>
							<th>Trạng thái</th>
							<th>Tùy chọn</th>
						</tr>
					</thead>
					<tbody>
						@foreach($ads as $value)
						<tr>
							<td>{{$loop->index +1}}</td>
							<td>{{$value->name}}</td>
							<td>
								{{$value->value}}
							</td>
							<td>
								{!!($value->status == 1)?'<span class="badge badge-success">Hiện</span>':'<span class="badge badge-danger">Ẩn</span>'!!}
							</td>
							<td>
								<a href="{{route('ads.edit', $value->id)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cập nhật">Cập nhật</a>
								<a href="{{route('ads.hidden', $value->id)}}" class="btn btn-success" onclick="return confirm('Bạn có muốn {!!$value->status==1?'Ẩn':'Hiện'!!} quảng cáo {{$value->name}} này không');">{!!$value->status==1?'Ẩn':'Hiện'!!}</a>
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
