@extends('frontend.layout.layout')
@section('title','Tác giả: '.$name_tacgia)
@section('content')
<nav aria-label="breadcrumb" class="pt-5px pb-5px bg-2a2b2a">
            <ol class="container breadcrumb">
                <li class="breadcrumb-item"><a class="color-white hover-a uppercase" href="{{route('home')}}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a class="color-white hover-a uppercase" href="{{route('danhsach','truyen-full')}}">
                    {{$name_tacgia}}
                </a></li>
            </ol>
        </nav>
        <section class="container mt-40 pb-40">
            <div class="row row-no-gutters">
        <div class="col-12 col-md-12 col-lg-9">
            <h4 class="uppercase">Tác giả 
                {{$name_tacgia}}
            </h4>
            <div class="row">
                @foreach($truyen as $value)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="truyenfull">
                    <div class="card box-shadow pt-10 pb-10 pl-10 back-tran">
                        <div class="row">
                            <div class="col-3 col-md-2 col-lg-1">
                                <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 90px; width:60px; display: block;" src="{{url('public/uploads')}}/{{$value->image}}" data-holder-rendered="true">
                            </div>
                            <div class="col-5 col-md-4 col-lg-4">
                                <a class="color-black hover-a" href="{{route('view',$value->slug)}}">
                                    <h5 class="card-text">{{$value->name}}</h5>
                                </a>
                                <p class="mt-10">
                                    <a href="{{route('tacgia',$value->tacgia->slug)}}" class="color-black hover-a">{{$value->tacgia->name}}</a>
                                    @if($value->status==0)
                                    <span class="label-title label-full uppercase">Full</span>
                                    @else
                                    <span class="label-title label-new uppercase">New</span>
                                    @endif
                                </p>

                            </div>
                            <div class="col-md-3 col-lg-3 card-body d-none d-md-block d-lg-block">
                                @foreach($value->truyen as $cate)
                                <a href="{{route('theloai',$cate->slug)}}" class="btn btn-sm btn-success hover-a mgb-5">{{$cate->name}}</a>
                                @endforeach
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <a class="color-black hover-a" href="{{route('chuongtruyen',[$value->slug,$value->chuong()->orderby('created_at','desc')->first()->slug])}}">
                                    <p class="card-text">{{$value->chuong()->orderby('created_at','desc')->first()->chapter_number}}: {{$value->chuong()->orderby('created_at','desc')->first()->name_chapter}}</p>
                                </a>
                                <small class="text-muted">{{$value->chuong()->orderby('created_at','desc')->first()->created_at->diffForHumans($now)}}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($truyen->lastPage()>1)
                <ul class="flex pl-10 pt-20">
                    @for($i=1;$i<=$truyen->lastPage();$i++)
                    @if ($from < $i && $i <= $to)
                    <li class="mr-5px"><a class="btn btn-sm btn-outline-secondary {{$truyen->currentPage()==$i?'active':''}}" href="{{$truyen->url($i)}}#truyenfull">{{$i}}</a></li>
                    @endif
                    @endfor
                    <li class="ml-20 mr-5px"><a class="btn btn-sm btn-outline-secondary uppercase {{$truyen->currentPage()<=1?'disabled':''}}" href="{{$truyen->previousPageUrl()}}#truyenfull"><i class="fas fa-chevron-left font-size-10"></i></a></li>
                    <li class="mr-5px"><a class="btn btn-sm btn-outline-secondary uppercase {{$truyen->currentPage()>=$truyen->lastPage()?'disabled':''}}" href="{{$truyen->nextPageUrl()}}#truyenfull"><i class="fas fa-chevron-right font-size-10"></i></a></li>
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