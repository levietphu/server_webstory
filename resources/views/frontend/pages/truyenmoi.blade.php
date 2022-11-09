@extends('frontend.layout.layout')
@section('title','Truyện mới')
@section('content')
<nav aria-label="breadcrumb" class="pt-5px pb-5px bg-2a2b2a">
    <ol class="container breadcrumb">
        <li class="breadcrumb-item"><a class="color-white hover-a uppercase" href="{{route('home')}}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="color-white hover-a uppercase" href="{{route('danhsach','truyen-moi')}}">Truyện mới cập nhật</a></li>
    </ol>
</nav>
<section class="container mt-40 pb-40">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-9" id="truyenmoi">
            <div class="row">
                <div class="col-12 col-md-9 col-lg-9">
                    <h3><a class="color-black hover-a" href="{{route('danhsach','truyen-moi')}}">Truyện mới cập nhật</a></h3>
                </div>
                @foreach($truyenmoi as $value)
                <div class="col-12 col-md-12">
                    <div class="card box-shadow pt-10 pb-10 pl-10 pr-10 back-tran">
                        <div class="row">
                            <div class="col-3 col-md-2 col-lg-1">
                                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 90px; width:60px; display: block;" src="{{url('public/uploads')}}/{{$value->image}}" data-holder-rendered="true">
                            </div>
                            <div class="col-9 col-md-10 col-lg-11">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="color-black hover-a" href="{{route('view',$value->slug)}}">
                                            <h5 class="card-text">{{$value->name}}</h5>
                                        </a>
                                        <p class="pt-10">
                                            <a href="{{route('tacgia',$value->tacgia->slug)}}" class="color-black hover-a">{{$value->tacgia->name}}</a>
                                            @if($value->status==0)
                                            <span class="label-title label-full uppercase">Full</span>
                                            @else
                                            <span class="label-title label-new uppercase">New</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        @foreach($value->truyen as $theloai)
                                        <a href="{{route('theloai',$theloai->slug)}}" class="btn btn-sm btn-success hover-a mgb-5">{{$theloai->name}}</a>
                                        @endforeach
                                    </div>
                                    <div class="col-md-4">
                                        <a class="color-black hover-a" href="{{route('chuongtruyen',[
                                        $value->slug,$value->chuong()->orderby('created_at','desc')->first()->slug])}}">
                                            <p class="card-text">{{$value->chuong()->orderby('created_at','desc')->first()->chapter_number}}: {{$value->chuong()->orderby('created_at','desc')->first()->name_chapter}}</p>
                                        </a>
                                        <small class="text-muted">{{$value->chuong()->orderby('created_at','desc')->first()->created_at->diffForHumans($now)}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($truyenmoi->lastPage()>1)
                <ul class="flex pl-10 pt-20">
                    @for($i=1;$i<=$truyenmoi->lastPage();$i++)
                    @if ($from < $i && $i <= $to)
                    <li class="mr-5px"><a class="btn btn-sm btn-outline-secondary {{$truyenmoi->currentPage()==$i?'active':''}}" href="{{$truyenmoi->url($i)}}#truyenmoi">{{$i}}</a></li>
                    @endif
                    @endfor
                    <li class="ml-20 mr-5px {{$truyenmoi->currentPage()==$truyenmoi->lastPage()||$truyenmoi->currentPage()==$truyenmoi->lastPage()-1||$truyenmoi->currentPage()==$truyenmoi->lastPage()-2?'display-none':''}}"><a class="btn btn-sm btn-outline-secondary uppercase" href="{{$truyenmoi->url($truyenmoi->lastPage())}}#truyenmoi">{{$truyenmoi->lastPage()}}</a></li>
                    <li class="ml-20 mr-5px"><a class="btn btn-sm btn-outline-secondary uppercase {{$truyenmoi->currentPage()<=1?'disabled':''}}" href="{{$truyenmoi->previousPageUrl()}}#truyenmoi"><i class="fas fa-chevron-left font-size-10"></i></a></li>
                    <li class="mr-5px"><a class="btn btn-sm btn-outline-secondary uppercase {{$truyenmoi->currentPage()>=$truyenmoi->lastPage()?'disabled':''}}" href="{{$truyenmoi->nextPageUrl()}}#truyenmoi"><i class="fas fa-chevron-right font-size-10"></i></a></li>
                </ul>
                @endif
            </div>
        </div>
        <div class="col-lg-3 d-none d-md-none d-lg-block">
            <h4 class="uppercase">Truyện đang hot</h4>
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
                                <a href="{{route('view',$value->slug)}}" class="hover-a color-black"><p class="card-text">{{$value->name}}</p></a>
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
                                <a href="{{route('view',$value->slug)}}" class="hover-a color-black"><p class="card-text">{{$value->name}}</p></a>
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
                                <a href="{{route('view',$value->slug)}}" class="hover-a color-black"><p class="card-text">{{$value->name}}</p></a>
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
@endsection