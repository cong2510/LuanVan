@extends('admin.indexAdmin')
@section('page_title')
    Thêm sản phẩm
@endsection
@section('content')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .error {
            color: red;
            font-size: 16px;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('all.product') }}"
                    style="text-decoration: none;" class="text-gray-700">Danh sách sản phẩm</a>/</span>Thêm sản phẩm</h4>
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
                    <h5 class="mb-0">Thêm sản phẩm mới</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form id="addProduct" action="{{ route('store.product') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tên sản phẩm</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Tên sản phẩm" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Mô tả</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="mota" id="mota" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Chọn loại</label>
                            <div class="col-sm-10">
                                @foreach ($loais as $loai)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $loai->id }}"
                                            id="flexCheckDefault{{ $loai->id }}" name="loai[]">
                                        <label class="form-check-label" for="flexCheckDefault{{ $loai->id }}">
                                            {{ $loai->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Chọn thương hiệu</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="brand" name="brand"
                                    aria-label="Default select example">
                                    <option disabled="" selected="">Chọn thương hiệu</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Số lượng</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="soluong" name="soluong"
                                    placeholder="Sô lượng" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Giá</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="gia" name="gia"
                                    placeholder="Giá" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Hình sản phẩm<br>(jpeg,png,jpg)</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" id="hinh" name="hinh[]"
                                    placeholder="Chọn hình" multiple />
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#addProduct').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    mota: {
                        required: true,
                    },
                    'loai[]': {
                        required: true,
                    },
                    brand: {
                        required: true,
                    },
                    soluong: {
                        required: true,
                        min: 0
                    },
                    gia: {
                        required: true,
                        min: 0
                    },
                    hinh: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Thiếu tên sản phẩm!',
                    },
                    mota: {
                        required: 'Thiếu mô tả!',
                    },
                    'loai[]': {
                        required: 'Thiếu thể loại',
                    },
                    brand: {
                        required: 'Thiếu thương hiệu!',
                    },
                    soluong: {
                        required: 'Thiếu số lượng!',
                        min: 'Số lượng âm!',
                    },
                    gia: {
                        required: 'Thiếu giá tiền!',
                        min: 'Số tiền âm!',
                    },
                    hinh: {
                        required: 'Thiếu hình!',
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });

            $('#name').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#mota').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#brand').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#soluong').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#gia').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('input[name="loai[]"]').on('blur', function() {
                $(this).valid();
            });
            $('input[name="hinh[]"]').on('blur', function() {
                $(this).valid();
            });
        });
    </script>
@endsection
