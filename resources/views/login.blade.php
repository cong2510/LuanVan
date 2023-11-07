<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')

</head>

<body>
    <div>
        <x-home.header :theloai="$theloai" :role="$role" title="Đăng Nhập" />
    </div>
    <div class="container">
        <!-- Outer Row -->
        <div class="text-center">
            @if (Session::has('user_not_found'))
                <div class="invalid-feedback d-block" role="alert">
                    <strong>{{ Session::get('user_not_found') }}</strong>
                </div>
            @endif
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                                    </div>
                                    <form class="user" id="login" action="{{ route('loginUser') }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Nhập email..." name="email">
                                            @error('email')
                                                <div class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Mật khẩu" name="password">
                                            @error('password')
                                                <div class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Nhớ mật
                                                    khẩu</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Đăng nhập</button>
                                        <hr>
                                        <a href="{{ route('loginGoogle') }}" class="btn btn-google btn-user btn-block"
                                            style="background-color: #ea4335;color: white">
                                            <i class="fab fa-google fa-fw"></i> Đăng nhập với Google
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Quên mật khẩu?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('signup') }}">Tạo tài khoản!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
