@extends('admin.indexAdmin')
@section('page_title')
    Sửa mã
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('all.promo') }}"
                    style="text-decoration: none;" class="text-gray-700">Danh sách mã</a>/</span>Sửa mã</h4>
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
                    <h5 class="mb-0">Chỉnh sửa mã</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('update.promo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $promo->id }}">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Code</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Mã..."
                                    value="{{ $promo->name }}" />
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Loại mã</label>
                            @if ($promo->type == "Cash")
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
                            @else
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="radio1"
                                            value="1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Mã giảm tiền
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="radio2"
                                            value="2" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Mã giảm %
                                        </label>
                                    </div>
                                </div>
                            @endif
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
                                    placeholder="Giảm..." min="1" value="{{ $promo->value }}" />
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
                                    placeholder="Số lần..." min="1" value="{{ $promo->max_usage }}" />
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
                                    name="max_usage_per_users" placeholder="Số lần mỗi tài khoản..." min="1"
                                    max="5" value="{{ $promo->max_usage_per_users }}" />
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
                                    placeholder="Mã..." min="<?php echo date('Y-m-d'); ?>" value="{{ $promo->end_date }}" />
                            </div>
                            @error('end_date')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Sửa mã</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
