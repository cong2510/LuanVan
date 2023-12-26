@extends('admin.indexAdmin')
@section('page_title')
    Danh sách thương hiệu
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách thương hiệu</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @if (Auth::user()->can('addBrand'))
                    <a class="btn btn-primary" href="{{ route('add.brand') }}" role="button">Thêm thương hiệu</a>&nbsp;
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Brand name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $key => $brand)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->can('editBrand'))
                                            <a class="btn btn-info" href="{{ route('edit.brand', $brand->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Sửa</a>
                                        @endif
                                        @if (Auth::user()->can('deleteBrand'))
                                            <a class="btn btn-danger" href="{{ route('delete.brand', $brand->id) }}"><i
                                                    class="bx bx-trash me-1"></i>
                                                Xóa</a>
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
            $('#myTable').DataTable();
        });
    </script>
@endsection
