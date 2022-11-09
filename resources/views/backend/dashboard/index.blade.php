@extends('backend.layout.layout')
@section('title','Trang quản trị')
@section('content')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Số người đã truy cập</th>
                <th>Số người online</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$visitor->count()}}</td>
                {{-- <td>{{$visitor->count()}}</td> --}}
            </tr>
        </tbody>
    </table>
@endsection