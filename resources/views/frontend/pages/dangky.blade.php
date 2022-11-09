@extends('frontend.layout.layout')
@section('title','Đăng ký tài khoản')
@section('content')
<nav aria-label="breadcrumb" class="pt-5px pb-5px bg-2a2b2a">
    <ol class="container breadcrumb">
        <li class="breadcrumb-item"><a class="color-white hover-a uppercase" href="{{route('home')}}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a class="color-white hover-a uppercase" href="">
            Đăng ký tài khoản
            </a>
        </li>
    </ol>
</nav>
<div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            {{-- @if(Session::has('error'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{Session::get('error')}}</strong>
            </div>
            @endif --}}
            <div>
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-12">
                        <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                            <div class="w-100">
                                <div class="row justify-content-center">
                                	<div class="col-lg-8">
                                		<img src="{{url('public/uploads/Config')}}/{{$logo_title->value}}" alt="">
                                	</div>
                                    <div class="col-lg-4">
                                        <div>
                                            <div class="p-2 mt-5">
                                                <form class="" action="{{route('post_dangky')}}" method="post">
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
                                                        <i style="margin-right: 10px;" class="fas fa-user"></i>
                                                        <label for="username">Tên người dùng</label>
                                                        <input type="text" class="form-control" name="name" placeholder="Nhập tên người dùng">
                                                        @error('name')
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
                                                    <div class="auth-form-group-custom mb-4">
                                                        
                                                        <label for="userpassword">Nhập lại mật khẩu</label>
                                                        <input type="password" class="form-control" name="repassword">
                                                        @error('repassword')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                            

                                                    <div class="text-center">
                                                        <button class="btn btn-success" type="submit">Đăng ký</button>
                                                    </div>

                                                   
                                                </form>
                                            </div>

                                       
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        </div>

    </div>
@endsection