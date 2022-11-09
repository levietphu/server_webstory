@extends('frontend.layout.layout')
@section('title',$truyen->name.' - '.$chuongtruyen->chapter_number.': '.$chuongtruyen->name_chapter)
@section('setting')
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i>
        Tùy chỉnh
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
      <li class="ml-20 mt-10">
        Màu nền
        <select name="" id="switch-color">
            <option value="light">Sáng</option>
            <option value="dark">Tối</option>
        </select>
    </li>
    <li class="ml-20 mt-10">
        Cỡ chữ
        <select name="" id="switch-font-size">
            <option value="18px">Ban đầu</option>
            <option value="24px">24</option>
            <option value="26px">26</option>
            <option value="28px">28</option>
            <option value="30px">30</option>
        </select>
    </li>
    <li class="ml-20 mt-10">
        Chiều cao dòng
        <select name="" id="switch-line-height">
            <option value="120%">Ban đầu</option>
            <option value="140%">140%</option>
            <option value="160%">160%</option>
            <option value="180%">180%</option>
            <option value="200%">200%</option>
        </select>
    </li>
</ul>
</li>
@endsection
@section('content')
<nav aria-label="breadcrumb" class="pt-5px pb-5px bg-2a2b2a">
    <ol class="container breadcrumb">
        <li class="breadcrumb-item"><a class="color-white hover-a" href="{{route('home')}}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="color-white hover-a" href="{{route('view',$truyen->slug)}}">{{$truyen->name}}</a></li>
        <li class="breadcrumb-item"><a class="color-white hover-a" href="{{route('chuongtruyen',[$truyen->slug,$chuongtruyen->slug])}}">{{$chuongtruyen->chapter_number}}</a></li>
    </ol>
</nav>
<div class="container-fluid pb-40 pt-20 switch-color">
    <div class="text-align-center">
        <h2 class="pb-10"><a class="hover-a switch-color-white color-black" href="{{route('view',$truyen->slug)}}">{{$truyen->name}}</a></h2>
        <h3 class="mb-30"><a class="hover-a switch-color-white color-black" href="">{{$chuongtruyen->chapter_number}}: {{$chuongtruyen->name_chapter}}</a></h3>
        <a href="{{route('chuongtruyen',[$truyen->slug,$slug_prev])}}" class="btn btn-sm btn-outline-secondary {{$id_min==$chuongtruyen->id?'disabled':''}}">Chương trước</a>
        <button class="btn btn-outline-secondary btn-sm list"><i class="fas fa-list"></i></button>
        <select class="btn btn-outline-secondary btn-sm display_list" name="chapter_number" style="display: none;">
            @foreach($all_chuongtruyen as $value)
            <option value="{{route('chuongtruyen',[$truyen->slug,$value->slug])}}" {{$value->slug==$chuongtruyen->slug?'selected':''}}>{{$value->chapter_number}}</option>
            @endforeach
        </select>
        <a href="{{route('chuongtruyen',[$truyen->slug,$slug_next])}}" class="btn btn-sm btn-outline-secondary {{$id_max==$chuongtruyen->id?'disabled':''}}">Chương sau</a>
    </div>
    <div class="mt-20">
        <div class="mt-20 mr-20 ml-20 font-size-change line-height-change font-size-18">
            {!!$chuongtruyen->content!!}
        </div>
    </div>
    <div class="text-align-center mt-20">
        <a href="{{route('chuongtruyen',[$truyen->slug,$slug_prev])}}" class="btn btn-sm btn-outline-secondary {{$id_min==$chuongtruyen->id?'disabled':''}}">Chương trước</a>
        <a href="{{route('chuongtruyen',[$truyen->slug,$slug_next])}}" class="btn btn-sm btn-outline-secondary {{$id_max==$chuongtruyen->id?'disabled':''}}">Chương sau</a>
    </div>
</div>
@endsection