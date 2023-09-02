{{-- @extends('frontend.layout.layout')
@section('title','Webtruyenchu đọc truyện online đầy đủ cập nhật mới nhất 2021')
@section('content')
<div class="container mt-40">
    <!-- Start Banner -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($banner as $key => $value)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$key}}" class="{{$key+1==1?'active':''}}" aria-current="true" aria-label="Slide {{$key+=1}}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($banner as $key => $value)
            <div class="carousel-item {{$key+1==1?'active':''}}">
                <img src="{{url('public/uploads')}}/{{$value->image}}" class="d-block w-100" alt="...">
            </div>
            @endforeach
            
        </div>
    </div>
    <!-- End Banner -->
    <!-- Start Tìm kiếm -->
        @csrf
    <form action="{{route('search')}}" method="get" class="d-flex mt-20">
        <input class="form-control me-2" type="search" placeholder="Tìm kiếm ...." aria-label="Search" name="tukhoa" id="search">
    </form>
    <div id="post_search">
    </div>
    <script>
        $('body').on('keyup', '#search', function(event) {
                event.preventDefault();
                var _token = $("input[name='_token']").val();
                var tukhoa=$(this).val();
                if(tukhoa.length>=3){
                    $.ajax({
                    url: '{{route('post_search')}}',
                    type: 'post',
                    data: {_token:_token,tukhoa:tukhoa},
                    success: function (data) {
                                $('#post_search').show('slow')
                                $('#post_search').html(data)
                            }
                        });
                }else{
                    $('#post_search').show('slow')
                    $('#post_search').html('Tìm kiếm với 3 từ khóa trở lên')
                }
        });  
        $('body').click(function (e) {
                $('#post_search').hide('slow')
        });  
        $('body').on('click','#search', function(event) {
            var tukhoa=$(this).val();
           if(tukhoa.length>=3){
            var _token = $("input[name='_token']").val();
                
                $.ajax({
                    url: '{{route('post_search')}}',
                    type: 'post',
                    data: {_token:_token,tukhoa:tukhoa},
                    success: function (data) {
                                $('#post_search').show('slow')
                                $('#post_search').html(data)
                            }
                        });
            }
        });
    </script>
    <!-- End Tìm kiếm -->
</div>
<!-- Truyện đề cử -->
<div class="container mt-40 pb-40">
    <h2>Truyện đề cử</h2>
    <div class="owl-carousel owl-theme">
        @foreach($truyenhot as $value)
        <div class="item">
            <div class="info_truyen">
                <span class="badge badge-danger loaitruyen uppercase">hot</span>
            </div>
            <img src="./public/uploads/{{$value->image}}" alt="" class="pb-10">
            @if($value->status==0)
            <span class="label-title label-full uppercase">Full</span>
            @else
            <span class="label-title label-new uppercase">New</span>
            @endif
            <h5 class="pt-10"><a href="./{{$value->slug}}" class="color-black hover-a">
                {{$value->name}}
                </a>
            </h5>
            <div class="flex">
                <a href="./{{$value->slug}}" class="btn btn-danger btn-sm hover-a">Đọc truyện</a>
                <a class="btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i> {{$value->view_count}}</a>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Truyện mới cập nhật -->
    <div class="row mt-40">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <h3><a class="color-black hover-a" href="{{route('danhsach','truyen-moi')}}">Truyện mới cập nhật</a></h3>
                </div>
                @foreach($truyenmoi as $value)
                <div class="col-12 col-md-12 col-lg-12">
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
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            @if(Session::has('reading'))
            <h3><a class="color-black hover-a">Truyện đang đọc</a></h3>
            @foreach(Session::get('reading') as $key => $value)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="card box-shadow back-tran">
                    <a class="pt-10 pb-10 pl-10 hover-chapter border-bottom color-black" href="{{route('chuongtruyen',[$key,$value])}}" title="{{\App\Models\Truyen::where('slug',$key)->first()->name}}">
                        <div class="chapter-panel-item">
                            <div class="chapter-panel-name">
                                <span class="has-text-weight-bold pr-2">{{\App\Models\Truyen::where('slug',$key)->first()->name}}</span>
                                <span class="has-text-weight-bold pr-2">Đọc tiếp: {{\App\Models\Chuongtruyen::where('slug',$value)->first()->chapter_number}}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            @endif
            <h3><a class="color-black hover-a" href="{{route('danhsach','truyen-full')}}">Truyện đã full</a></h3>
            @foreach($truyenfull as $value)
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card box-shadow back-tran">
                    <a class="pt-10 pb-10 pl-10 hover-chapter border-bottom color-black" href="{{route('view',$value->slug)}}" title="{{$value->name}}">
                        <div class="chapter-panel-item">
                            <div class="chapter-panel-name"><span class="has-text-weight-bold pr-2">{{$value->name}}</span></div>
                            <div class="pt-10">
                                @foreach($value->truyen as $theloai)
                                <span auto-update="true">
                                <button class="btn btn-success btn-sm mgb-5">{{$theloai->name}}</button>
                                </span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection --}}
<div>
    <p>{{$aa}}</p>
    <p>https://tienvuc.azurewebsites.net/api/home</p>
    <p>https://tienvuc.azurewebsites.net/api/layout</p>
    <p>https://tienvuc.azurewebsites.net/api/cate?slug="..."</p>
    <p>https://tienvuc.azurewebsites.net/api/list?slug="..."</p>
    <p>https://tienvuc.azurewebsites.net/api/translator?slug="..."</p>
    <p>https://tienvuc.azurewebsites.net/api/search?keyword="..."</p>
    <p>https://tienvuc.azurewebsites.net/api/search_chapter?keyword="..."&id_story="..."</p>
    <p>https://tienvuc.azurewebsites.net/api/register?name="..."&email="..."&password</p>
    <p>https://tienvuc.azurewebsites.net/api/login?email="..."&password</p>
    <p>https://tienvuc.azurewebsites.net/api/login?email="..."&password</p>
    <p>https://tienvuc.azurewebsites.net/api/get_story?slug=".."&keyword="..."&orderby="asc"&id_user&page=".."&page="1"</p>
</div>