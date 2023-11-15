<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('cdn')
    <style>
        .error {
            color: red;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div>
        <x-home.header :theloai="$theloai" :role="$role" title="Đăng ký" />
    </div>
    <div class="container col-8 pt-3">
        <div class="text-center">
            @if (Session::has('signup_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong class="h4">{{ Session::get('signup_success') }}</strong>
                    <hr class="py-0 text-success" />
                    <p>
                        Hãy kiểm tra email bạn vừa đăng ký để xác thực tài khoản
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Tạo tài khoản!</h1>
                            </div>
                            <div class="text-center">
                                @if (Session::has('user_already_exist'))
                                    <div class="invalid-feedback d-block" role="alert">
                                        <strong>{{ Session::get('user_already_exist') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <form class="user" id="signup" action="{{ route('createUser') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input name="name" type="text" class="form-control form-control-user"
                                        id="name" placeholder="Họ và tên">
                                    @error('name')
                                        <div class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input name="email" type="email" class="form-control form-control-user"
                                        id="email" placeholder="Địa chỉ Email">
                                    @error('email')
                                        <div class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password" class="form-control form-control-user"
                                            id="password" placeholder="Mật khẩu">
                                        @error('password')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="password_confirmation" type="password"
                                            class="form-control form-control-user" id="password_confirmation"
                                            placeholder="Nhập lại mật khẩu">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Đăng Ký</button>
                                <hr>
                                <a href="{{ route('loginGoogle') }}" class="btn btn-google btn-user btn-block"
                                    style="background-color: #ea4335;color: white">
                                    <i class="fab fa-google fa-fw"></i> Đăng ký với Google
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('forgotPassword') }}">Quên mật khẩu?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Đã có tài khoản? Đăng nhập!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
        $(document).ready(function() {
            $('#signup').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Thiếu họ và tên!',
                    },
                    email: {
                        required: 'Thiếu email!',
                        email: 'Hãy nhập dúng email!',
                    },
                    password: {
                        required: 'Thiếu mật khẩu!',
                    },
                    password_confirmation: {
                        required: 'Thiếu nhập lại mật khẩu!',
                    },

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });

            $('#name').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#email').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#password').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#password_confirmation').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
        });
    </script>

</html>
