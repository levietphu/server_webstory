@extends('frontend.layout.layout')
@section('title',isset($_GET['page'])?'Truyện '.$truyen->name.' - '.'Trang '.$_GET['page']:$truyen->name)
@section('content')
<nav aria-label="breadcrumb" class="pt-5px pb-5px bg-2a2b2a">
    <ol class="container breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" class="color-white hover-a uppercase">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('view',$truyen->slug)}}" class="uppercase color-white hover-a">{{$truyen->name}}</a></li>
    </ol>
</nav>
<section class="container mt-40">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-9">
            <div class="row">
                <div class="col-1 d-md-none"></div>
                <div class="col-11 col-md-4 col-lg-3">
                    <h4 class="border-bottom uppercase d-md-none d-block">{{$truyen->name}}</h4>
                    <img src="{{url('public/uploads')}}/{{$truyen->image}}" alt="">
                    <br>
                    <br>
                    <span><b class="mr-5px">Tác giả:</b><a style="font-size: 14px" class="color-black hover-a" href="{{route('tacgia',$truyen->tacgia->slug)}}">{{$truyen->tacgia->name}}</a></span>
                    <br>
                    <span><b class="mr-5px">Thể loại:</b>
                    @foreach($truyen->truyen as $key => $cate)
                    <a style="font-size: 14px" class="color-black hover-a" href="{{route('theloai',$cate->slug)}}">{{$cate->name}}</a>{{$key+1==$truyen->truyen->count()?'.':','}}
                    @endforeach
                    </span>
                    <br>
                    @if($truyen->nguon)
                    <span><b class="mr-5px">Nguồn:</b><a style="font-size: 14px">{{$truyen->nguon}}</a></span>
                    <br>
                    @endif
                    <span><b>Tình trạng:</b>
                    @if($truyen->status ==0)
                    <a style="font-size: 14px;">Đã hoàn thành</a>
                    @else
                    <a style="font-size: 14px;">Đang ra</a>
                    @endif
                    </span>
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="ml-30 desc">
                        <h4 class="border-bottom text-center uppercase d-none d-md-block">{{$truyen->name}}</h4>
                        <div class="rate text-center">
                            {{-- @include('frontend.pages.review') --}}
                        </div>
                        <p>Giới thiệu truyện:</p>
                        <br>
                        <span>{!!$truyen->introduce!!}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 d-none d-md-none d-lg-block">
            @if($tacgia_truyen->count()>=1)
            <div class="card back-tran">
                <div class="card-body">
                    <h4 class="border-bottom">Truyện cùng tác giả</h4>
                    @foreach($tacgia_truyen as $value)
                    <p class="border-bottom"><a class="color-black hover-a" href="{{route('view',$value->slug)}}">{{$value->name}}</a></p>
                    @endforeach
                </div>
            </div>
            @endif
            <h4 class="border-bottom pt-20 uppercase">Truyện hot</h4>
            <ul class="nav nav-tabs pb-80 row" role="tablist">
                <li class="nav-item col-md-4"> 
                    <a class="nav-link active show uppercase" href="#tabs-link-1" role="tab" data-toggle="tab" aria-selected="true">
                    Ngày
                    </a>
                </li>
                <li class="nav-item col-md-4"> 
                    <a class="nav-link uppercase" href="#tabs-link-2" role="tab" data-toggle="tab" aria-selected="false">
                    Tháng
                    </a>
                </li>
                <li class="nav-item col-md-4"> 
                    <a class="nav-link uppercase" style="padding-left: 24px;" href="#tabs-link-3" role="tab" data-toggle="tab" aria-selected="false">
                    All
                    </a>
                </li>
            </ul>
            <div class="tab-content pt-20">
                <div role="tabpanel" class="tab-pane fade active show" id="tabs-link-1">
                    @foreach($truyenhot_sort_today as $key => $value)
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card box-shadow back-tran">
                            <div class="card-body">
                                <a href="{{route('view',$value->slug)}}" class="hover-a color-black">
                                    <p class="card-text">{{$value->name}}</p>
                                </a>
                                @foreach($value->truyen as $theloai)
                                <a href="{{route('theloai',$theloai->slug)}}" class="btn btn-success btn-sm mt-10 hover-a">{{$theloai->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tabs-link-2">
                    @foreach($truyenhot_sort_thisMonth as $value)
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card box-shadow back-tran">
                            <div class="card-body">
                                <a href="{{route('view',$value->slug)}}" class="hover-a color-black">
                                    <p class="card-text">{{$value->name}}</p>
                                </a>
                                @foreach($value->truyen as $theloai)
                                <a href="{{route('theloai',$theloai->slug)}}" class="btn btn-success btn-sm mt-10 hover-a">{{$theloai->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tabs-link-3">
                    @foreach($truyenhot_sort_all as $value)
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="card box-shadow back-tran">
                            <div class="card-body">
                                <a href="{{route('view',$value->slug)}}" class="hover-a color-black">
                                    <p class="card-text">{{$value->name}}</p>
                                </a>
                                @foreach($value->truyen as $theloai)
                                <a href="{{route('theloai',$theloai->slug)}}" class="btn btn-success btn-sm mt-10 hover-a">{{$theloai->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container mt-40 pb-40">
    <div class="row">
        <div class="col-12 col-md-7 col-lg-7">
            <div class="card back-tran">
                <h3 class="pt-10 pb-10 pl-10 list-comment border-radius-6"><b>Danh sách chương</b></h3>
                <input class="text-indent ml-10 mr-10 pt-10 pb-10" type="text" placeholder="tìm kiếm chương...." style="border: none;" id="search_page_chapter" name="search_chapter">
                <div class="container">
                    <div class="row" id="chapter_number">
                        @include('frontend.pages.pagination-search-chapter')
                    </div>
                </div>
                <input type="hidden" value="1" id="hidden_page">
                
            </div>
        </div>
        {{-- <div class="col-12 col-md-5 col-lg-5">
            <div class="card back-tran">
                <h3 class="pt-10 pb-10 pl-10 list-comment border-radius-6">Bình luận</h3>
                @if(Auth::check())
                <form action="" method="POST" role="form" class="ml-10 mr-10 mb-10">
                    @csrf
                        <textarea id_truyen="{{$truyen->id}}" id="comment" name="content" class="form-control border-radius-10" rows="3" placeholder="Hãy để lại bình luận của bạn..."></textarea>
                </form>
                @else
                <a class="btn btn-success mt-10 mb-10 ml-10 mr-10" data-toggle="modal" href='#modal-id'>Vui lòng đăng nhập để bình luận</a>
                @endif
                <div id="includecomment">
                    @include('frontend.pages.comment')
                </div>

            </div>
        </div> --}}
    </div>
</section>

<div class="modal fade" id="modal-id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Đăng nhập</h4>
            </div>
            <div class="modal-body">
                <form class="" action="{{route('post_dangnhap_view')}}" method="post">
                                                    @csrf
                                                    <div class="auth-form-group-custom mb-4">
                                                        <i style="margin-right: 10px;" class="fas fa-email"></i>
                                                        <label for="useremail">Email</label>
                                                        <input type="email" class="form-control" id="useremail" placeholder="Nhập email" name="email">
                                                        @error('email')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="auth-form-group-custom mb-4">
                                                        <label for="userpassword">Mật khẩu</label>
                                                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">
                                                        @error('password')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="text-center">
                                                        <button class="btn btn-success" type="submit">Đăng nhập</button>
                                                    </div>

                                                   
                                                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection