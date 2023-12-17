@extends('infor')
@section('page_title')
    Thông tin tài khoản
@endsection
@section('content')
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
                            <input name="name" type="text" class="form-control border-secondary bg-navbar-dark "
                                id="name" placeholder="Tên người dùng" value="{{ auth()->user()->name }}" />
                            @error('name')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input readonly name="email" type="email"
                                class="form-control border-secondary bg-navbar-dark" id="email" placeholder="Nhập email"
                                value=" {{ auth()->user()->email }}" />
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
                    <select id="gender" name="gender" class="form-select border-secondary mb-3 bg-navbar-dark">
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
                    <ul class="list-group">
                        @foreach ($address as $diachi)
                            @if ($diachi->user_id == auth()->user()->id)
                                <li class="list-group-item d-flex justify-content-between">
                                    {{ $diachi->address }}<a href="{{ route('deleteaddress', $diachi->id) }}"
                                        style="text-decoration: none;color:red;font-size: 18px">X</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <div class="row">
                        <div class="col-3">
                            <input name="address" type="text" class="form-control border-secondary bg-navbar-dark"
                                id="address" placeholder="Nhập địa chỉ" />
                        </div>
                        <div class="col-3">
                            <select class="form-select border-secondary" name="thanhpho" id="thanhpho">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-select border-secondary" name="quan" id="quan">
                                <option value="">Chọn quận</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-select border-secondary" name="phuong" id="phuong">
                                <option value="">Chọn phường</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group pt-2">
                    <button type="submit" class="btn btn-primary">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <br>
    @if (Auth::user()->google_id == null)
        <div class="card border-secondary bg-navbar-dark info">
            <div class="card-header border-secondary bg-navbar-dark">
                <div class="card-actions float-right">
                </div>
                <h5 class="card-title mb-0">
                    Mật khẩu
                </h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('changepassworduser') }}" enctype="multipart/form-data">
                    @csrf
                    <input name="form"type="text" value="2"hidden />
                    @method('put')
                    <div class="form-group">
                        <label for="old_password">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="inputPasswordCurrent"
                            placeholder="Nhập mật khẩu hiện tại" name="old_password" />
                        @if (Session::has('old_password_mismatch'))
                            <div class="invalid-feedback d-block" role="alert">
                                <strong>{{ Session::get('old_password_mismatch') }}</strong>
                            </div>
                        @endif
                        @error('old_password')
                            <div class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group pt-2">
                        <label for="new_password">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="inputPasswordNew"
                            placeholder="Nhập mật khẩu mới" name="new_password" />
                        @error('new_password')
                            <div class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group pt-2">
                        <label for="password_confirmation">Nhập lại mật khẩu mới</label>
                        <input type="password" class="form-control" id="inputPasswordNew2"
                            placeholder="Nhập mật khẩu mới" name="new_password_confirmation" />
                        {{-- Convention, <name>_confirmation --}}
                        @error('new_password_confirmation')
                            <div class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group pt-3">
                        <button type="submit" class="btn btn-primary">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="card border-secondary bg-navbar-dark info">
            <div class="card-header border-secondary bg-navbar-dark">
                <div class="card-actions float-right">
                </div>
                <h5 class="card-title mb-0">
                    Mật khẩu
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="old_password">Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="inputPasswordCurrent"
                        placeholder="Nhập mật khẩu hiện tại" name="old_password" disabled/>
                </div>
                <div class="form-group pt-2">
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="inputPasswordNew" placeholder="Nhập mật khẩu mới"
                        name="new_password" disabled />
                </div>
                <div class="form-group pt-2">
                    <label for="password_confirmation">Nhập lại mật khẩu mới</label>
                    <input type="password" class="form-control" id="inputPasswordNew2" placeholder="Nhập mật khẩu mới"
                        name="new_password_confirmation" disabled />
                </div>
                <div class="form-group pt-3">
                    <button type="submit" class="btn btn-primary" disabled>
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection
