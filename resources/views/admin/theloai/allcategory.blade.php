@extends('admin.indexAdmin')
@section('page_title')
    Danh sách thể loại
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách thể loại</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @if (Auth::user()->can('addCategory'))
                    <a class="btn btn-primary" href="{{ route('add.category') }}" role="button">Thêm thể loại</a>&nbsp;
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Category name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loais as $key => $loai)
                                <tr>
                                    <td>{{ $loai->id }}</td>
                                    <td>{{ $loai->name }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->can('editCategory'))
                                            <a class="btn btn-info" href="{{ route('edit.category', $loai->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Sửa</a>
                                        @endif
                                        @if (Auth::user()->can('deleteCategory'))
                                            <a class="btn btn-danger" href="{{ route('delete.category', $loai->id) }}"><i
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
