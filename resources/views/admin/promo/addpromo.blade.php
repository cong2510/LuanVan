@extends('admin.indexAdmin')
@section('page_title')
    Thêm mã khuyễn mãi
@endsection
@section('content')
    <style>
        .error {
            color: red;
            font-size: 16px;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('all.promo') }}"
                    style="text-decoration: none;" class="text-gray-700">Danh sách mã</a>/</span>Thêm mã</h4>
        <div class="text-center">
            @if ($errors->any())
                <div class="text-danger h6 text-lg-start fw-bold">
                    Sai nhập liệu...
                </div>
                <ul class="list-group list-unstyled" style="width: 350px">
                    @foreach ($errors->all() as $item)
                        <li class="alert alert-danger">{{ $item }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Thêm mã mới</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form id="addPromo" action="{{ route('store.promo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Code</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Mã..." />
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Loại mã</label>
                            <div class="col-sm-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="radio1"
                                        value="1" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Mã giảm tiền
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="radio2"
                                        value="2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Mã giảm %
                                    </label>
                                </div>
                            </div>
                            @error('type')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Giảm</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="value" name="value"
                                    placeholder="Giảm..." min="1" />
                            </div>
                            @if (Session::has('value_incorrect'))
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ Session::get('value_incorrect') }}</strong>
                                </div>
                                <br>
                            @endif
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Số lần sử dụng</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="max_usage" name="max_usage"
                                    placeholder="Số lần..." min="1"/>
                            </div>
                            @error('max_usage')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Số lần mỗi tài khoản</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="max_usage_per_users"
                                    name="max_usage_per_users" placeholder="Số lần mỗi tài khoản..." min="1" max="5" />
                            </div>
                            @error('max_usage_per_users')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Ngày hết hạn</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    placeholder="Mã..." min="<?php echo date('Y-m-d'); ?>" />
                            </div>
                            @error('end_date')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Thêm mã</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#addPromo').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    type: {
                        required: true,
                    },
                    value: {
                        required: true,
                    },
                    max_usage: {
                        required: true,
                    },
                    max_usage_per_users: {
                        required: true,
                    },
                    end_date: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Thiếu mã!',
                    },
                    type: {
                        required: 'Thiếu loại mã!',
                    },
                    value: {
                        required: 'Thiếu số tiền giảm!',
                    },
                    max_usage: {
                        required: 'Thiếu số lần sử dụng!',
                    },
                    max_usage_per_users: {
                        required: 'Thiếu số lần mỗi tài khoản!',
                    },
                    end_date: {
                        required: 'Thiếu ngày hết hạn!',
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });

            $('#name').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#radio1').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#radio2').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#value').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#max_usage').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#max_usage_per_users').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#end_date').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
        });
    </script>
@endsection
