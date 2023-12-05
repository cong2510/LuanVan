@extends('admin.indexAdmin')
@section('page_title')
    Danh sách mã khuyến mãi
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách mã khuyến mãi</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a class="btn btn-primary" href="{{ route('add.promo') }}" role="button">Thêm mã khuyến mãi</a>&nbsp;
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="promoTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Code</th>
                                <th>Loại</th>
                                <th>Giảm</th>
                                <th>Số lượng sử dụng</th>
                                <th>Mỗi tài khoản</th>
                                <th>Ngày hết hạn</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($promos as $key => $promo)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $promo->name }}</td>
                                    <td>{{ $promo->type }}</td>
                                    <td>{{ $promo->value }}</td>
                                    <td>{{ $promo->max_usage }}</td>
                                    <td>{{ $promo->max_usage_per_users }}</td>
                                    <td>{{ $promo->end_date }}</td>
                                    <td>{{ $promo->promo_status }}</td>
                                    <td>
                                        <div class="dropdown text-center">
                                            <button type="button" class="btn p-0 " data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"><i class="fa-solid fa-gear"
                                                        style="color: #000000;"></i></i></button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('edit.promo', $promo->id) }}"><i
                                                        class="bx bx-edit-alt me-1"></i>
                                                    Edit</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('delete.promo', $promo->id) }}"><i
                                                        class="bx bx-trash me-1"></i>
                                                    Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Code</th>
                                <th>Loại</th>
                                <th>Giảm</th>
                                <th>Số lượng sử dụng</th>
                                <th>Mỗi tài khoản</th>
                                <th>Ngày hết hạn</th>
                                <th>Trạng thái</th>
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
            $('#promoTable').DataTable();
        });
    </script>
@endsection
