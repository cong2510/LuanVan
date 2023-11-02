@extends('admin.indexAdmin')
@section('page_title')
    Sản phẩm
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin/</span> Sản phẩm</h4>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="card">
            <h5 class="card-header">Thông tin sản phẩm</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình sản phẩm</th>
                            <th>Loại</th>
                            <th>Thương hiệu</th>
                            <th>Giá</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($sanphams as $sanpham)
                            <tr>
                                <td>{{ $sanpham->id }}</td>
                                <td>{{ $sanpham->name }}</td>
                                <td>
                                    <img src="../images/sanpham/{{ $sanpham->image }}" alt="" height="130px"
                                        width="100px">
                                    <br>
                                    <a href="" class="btn btn-primary">Đổi
                                        hình</a>
                                </td>
                                <td>
                                    @foreach ($sanpham->theloai as $sanphamtheloai)
                                        {{ $sanphamtheloai->name }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($brands as $brand)
                                        @if ($sanpham->id_brand == $brand->id)
                                            {{ $brand->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $sanpham->gia }}</td>
                                <td>
                                    <a href="" class="btn btn-primary">Sửa</a>
                                    <a href="" class="btn btn-danger">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $sanphams->links() }}
@endsection
