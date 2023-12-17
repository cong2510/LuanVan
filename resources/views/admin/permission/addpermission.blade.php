@extends('admin.indexAdmin')
@section('page_title')
    Thêm quyền
@endsection
@section('content')
    <style>
        .error {
            color: red;
            font-size: 16px;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('all.permission') }}"
                    style="text-decoration: none;" class="text-gray-700">Danh sách quyền</a>/</span>Thêm quyền</h4>
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
                    <h5 class="mb-0">Thêm quyền mới</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form id="addPermission" action="{{ route('store.permission') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tên quyên</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Tên quyền" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Chọn nhóm quyên</label>
                            <div class="col-sm-3">
                                <select name='group_name' class="form-select" id='group_name'>
                                    <option disabled="" selected="">Chọn nhóm</option>
                                    <option value="product">Sản phẩm</option>
                                    <option value="order">Đơn hàng</option>
                                    <option value="category">Loại hàng</option>
                                    <option value="brand">Thương hiệu</option>
                                    <option value="role&permission">Role & Permission</option>
                                    <option value="user">User</option>
                                    <option value="promo">Mã khuyến mãi</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Thêm quyền</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#addPermission').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    group_name: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Thiếu tên quyền!',
                    },
                    group_name: {
                        required: 'Thiếu nhóm quyền!',
                    },
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });

            $('#name').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
            $('#group_name').on('blur', function() {
                $(this).valid(); // Trigger validation on blur event
            });
        });
    </script>
@endsection
