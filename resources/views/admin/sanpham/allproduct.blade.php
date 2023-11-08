@extends('admin.indexAdmin')
@section('page_title')
    Sản phẩm
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách sản phẩm</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-primary" href="" role="button">Thêm sản phẩm</a>&nbsp;
                <a class="btn btn-success" href="" role="button">Import</a>&nbsp;
                <a class="btn btn-danger" href="" role="button">Export</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình sản phẩm</th>
                                <th>Loại</th>
                                <th>Thương hiệu</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sanphams as $sanpham)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
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
                                    <td>{{ $sanpham->soluong }}</td>
                                    <td>
                                        <div class="dropdown text-center">
                                            <button type="button" class="btn p-0 " data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"><i class="fa-solid fa-gear"
                                                        style="color: #000000;"></i></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href=""><i class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                <a class="dropdown-item" href=""><i class="bx bx-trash me-1"></i>
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Mã sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình sản phẩm</th>
                                <th>Loại</th>
                                <th>Thương hiệu</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
