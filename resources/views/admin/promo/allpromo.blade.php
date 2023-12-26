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
                @if (Auth::user()->can('addPromo'))
                    <a class="btn btn-primary" href="{{ route('add.promo') }}" role="button">Thêm mã khuyến mãi</a>&nbsp;
                @endif
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
                                    <td>{{ date('d-m-Y', strtotime($promo->end_date)) }}</td>
                                    <td>{{ $promo->promo_status }}</td>
                                    <td>
                                        @if (Auth::user()->can('editPromo'))
                                            <a href="{{ route('edit.promo', $promo->id) }}">
                                                <button class="btn btn-info">
                                                    Sửa</button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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
