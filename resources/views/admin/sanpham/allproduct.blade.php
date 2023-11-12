@extends('admin.indexAdmin')
@section('page_title')
    Danh sách sản phẩm
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách sản phẩm</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @if (Auth::user()->can('addProduct'))
                    <a class="btn btn-primary" href="{{ route('add.product') }}" role="button">Thêm sản phẩm</a>&nbsp;
                @endif
                <a class="btn btn-success" href="" role="button">Import</a>&nbsp;
                <a class="btn btn-danger" href="{{ route('export.product') }}" role="button">Export</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Hình</th>
                                <th>Mô tả</th>
                                <th>Thể loại</th>
                                <th>Thương hiệu</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Khuyễn mãi</th>
                                <th>Tình trạng</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sanphams as $key => $sanpham)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sanpham->name }}</td>
                                    <td>hinh</td>
                                    <td>{{ $sanpham->mota }}</td>
                                    <td>
                                        @foreach ($sanpham->theloai as $theloai)
                                            - {{ $theloai->name }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($brandsanphams as $brand)
                                            @if ($sanpham->brand_id == $brand->id)
                                                {{ $brand->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $sanpham->soluong }}</td>
                                    <td>{{ $sanpham->gia }}</td>
                                    <td>Khuyễn mãi</td>
                                    <td>{{ $sanpham->tinhtrang }}</td>
                                    <td>
                                        <div class="dropdown text-center">
                                            <button type="button" class="btn p-0 " data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"><i class="fa-solid fa-gear"
                                                        style="color: #000000;"></i></i></button>
                                            <div class="dropdown-menu">
                                                @if (Auth::user()->can('editProduct'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('edit.product', $sanpham->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i>
                                                        Edit</a>
                                                @endif
                                                @if (Auth::user()->can('deleteProduct'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('delete.product', $sanpham->id) }}"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Delete</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Hình</th>
                                <th>Mô tả</th>
                                <th>Thể loại</th>
                                <th>Thương hiệu</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Khuyễn mãi</th>
                                <th>Tình trạng</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection
