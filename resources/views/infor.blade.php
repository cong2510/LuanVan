<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')

    <x-home.header :theloai="$theloai" :role="$role" title="Trang cá nhân" />
</head>

<body>
    <br>
    <div class="container">
        <h5>Tên: {{ auth()->user()->name }}</h5>
        <h5></h5>
        <h5></h5>
    </div>
    <div class="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Danh sách yêu
                    thích</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Thông tin tài
                    khoản</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Lịch sử mua
                    hàng</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                abc
            </div>
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="card border-secondary">
                    <div class="card-header border-secondary">
                        <div class="card-actions float-right">
                        </div>
                        <h5 class="card-title mb-0">Thông tin cơ bản</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('edituser') }}" enctype="multipart/form-data">
                            @csrf
                            <input name="form"type="text" value="1" hidden />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Tên người dùng</label>
                                        <input name="name" type="text"
                                            class="form-control border-secondary bg-navbar-dark " id="name"
                                            placeholder="Tên người dùng" value="{{ auth()->user()->name }}" />
                                        @error('name')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input readonly name="email" type="email"
                                            class="form-control border-secondary bg-navbar-dark" id="email"
                                            placeholder="Nhập email" value=" {{ auth()->user()->email }}" />
                                        @error('email')
                                            <div class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <br>


                <div class="card border-secondary bg-navbar-dark info">
                    <div class="card-header border-secondary bg-navbar-dark">
                        <div class="card-actions float-right">
                        </div>
                        <h5 class="card-title mb-0">
                            Thông tin khác
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('edituser') }}" enctype="multipart/form-data">
                            @csrf
                            <input name="form"type="text" value="2"hidden />
                            <div class="form-group pt-2">
                                <label for="gender">Giới tính</label>
                                <select id="gender" name="gender"
                                    class="form-select border-secondary mb-3 bg-navbar-dark">
                                    <option value="Male" {{ auth()->user()->gender == 'Male' ? 'selected' : '' }}>Nam
                                    </option>
                                    <option value="Female" {{ auth()->user()->gender == 'Female' ? 'selected' : '' }}>
                                        Nữ</option>
                                    <option value="Other" {{ auth()->user()->gender == 'Other' ? 'selected' : '' }}>
                                        Khác</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group pt-2">
                                <label for="address">Địa chỉ</label>
                                <input value="{{ auth()->user()->address }}" name="address" type="text"
                                    class="form-control border-secondary bg-navbar-dark" id="address"
                                    placeholder="Nhập địa chỉ" />
                            </div>
                            <div class="form-group pt-2">
                                <button type="submit" class="btn btn-primary">
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
        </div>
    </div>
</body>
<x-home.footer />

</html>
