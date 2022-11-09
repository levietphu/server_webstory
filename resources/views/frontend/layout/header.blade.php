<nav class="navbar navbar-expand-lg navbar-dark bg-dark pb-20 sticky">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{-- {{url('public/uploads/Config')}}/{{$logo_home->value}} --}}" alt="" width="100" height="70"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-list"></i>
                    Danh sách 
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{route('danhsach','truyen-full')}}">Truyện đã hoàn thành</a></li>
                        <li><a class="dropdown-item" href="{{route('danhsach','truyen-moi')}}">Truyện mới cập nhật</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-list"></i>
                    Thể loại
                    </a>
                    <ul class="dropdown-menu columns" aria-labelledby="navbarDropdown">
                        @foreach($theloai as $value)
                        <li><a class="dropdown-item" href="{{route('theloai',$value->slug)}}">{{$value->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-list"></i>
                    Phân loại theo chương
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{route('phanloai','duoi-100-chuong')}}">Dưới 100 chương</a></li>
                        <li><a class="dropdown-item" href="{{route('phanloai','100-500-chuong')}}">100-500 chương</a></li>
                        <li><a class="dropdown-item" href="{{route('phanloai','500-1000-chuong')}}">500-1000 chương</a></li>
                        <li><a class="dropdown-item" href="{{route('phanloai','tren-1000-chuong')}}">Trên 1000 chương</a></li>
                    </ul>
                </li>
                @if(!Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{route('dangky')}}">
                    Đăng Ký
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{route('dangnhap')}}">
                    Đăng Nhập
                    </a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{route('dangxuat')}}">
                    Đăng xuất
                    </a>
                </li>
                @endif
                @yield('setting')
            </ul>
        </div>
    </div>
</nav>