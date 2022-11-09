@extends('backend.layout.layout')
@section('title', 'Danh sách Logo')
@section('text', 'Logo')
@section('text1', 'Cấu hình')
@section('content')
<div class="row fix-row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('logo.create')}}" class="btn btn-success" style="margin: 30px 0 30px 0;">Thêm mới</a>
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
                            <th>Ảnh</th>
                            <th>Trạng thái</th>
                            <th>Tùy chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logo as $value)
                        <tr>
                            <td>{{$loop->index +1}}</td>
                            <td>{{$value->name}}</td>
                            <td>
                                <img src="{{url('public/uploads/Config')}}/{{$value->value}}" style="max-width: 100px;" class="img-responsive" alt="Image">
                            </td>
                            <td>
                                {!!($value->status == 1)?'<span class="badge badge-success">Hiện</span>':'<span class="badge badge-danger">Ẩn</span>'!!}
                            </td>
                            <td style="display: flex;">
                                <a href="{{route('logo.edit', $value->id)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cập nhật"><i class="fadeIn animated bx bx-edit"></i></a>
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