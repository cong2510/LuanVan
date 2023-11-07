@extends('admin.indexAdmin')
@section('page_title')
    Sửa quyền
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin/</span> Sửa quyền</h4>
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
                    <h5 class="mb-0">Chỉnh sửa quyền</h5>
                    {{-- <small class="text-muted float-end">Default label</small> --}}
                </div>
                <div class="card-body">
                    <form action="{{ route('update.permission') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $permission->id }}">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Tên quyên</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Tên quyền" value="{{ $permission->name }}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Chọn nhóm quyên</label>
                            <div class="col-sm-3">
                                <select name='group_name' class="form-select" id='exampleFormControlSelect1'>
                                    <option disabled="" selected="">Chọn nhóm</option>
                                    <option value="product" {{ $permission->group_name == 'product' ? 'selected' : '' }}>Sản
                                        phẩm</option>
                                    <option value="order" {{ $permission->group_name == 'order' ? 'selected' : '' }}>Đơn
                                        hàng</option>
                                    <option value="category" {{ $permission->group_name == 'category' ? 'selected' : '' }}>
                                        Loại hàng</option>
                                    <option value="brand" {{ $permission->group_name == 'brand' ? 'selected' : '' }}>Thương
                                        hiệu</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Sửa quyền</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
