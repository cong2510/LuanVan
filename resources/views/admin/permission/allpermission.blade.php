@extends('admin.indexAdmin')
@section('page_title')
    Danh sách quyền
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách quyền</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @if (Auth::user()->can('addPermission'))
                    <a class="btn btn-primary" href="{{ route('add.permission') }}" role="button">Thêm quyền</a>&nbsp;
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Permission name</th>
                                <th>Group name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $key => $per)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $per->name }}</td>
                                    <td>{{ $per->group_name }}</td>
                                    <td class="text-center">
                                        @if (Auth::user()->can('editPermission'))
                                            <a class="btn btn-info" href="{{ route('edit.permission', $per->id) }}">
                                                Sửa</a>
                                        @endif
                                        {{-- @if (Auth::user()->can('deletePermission'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('delete.permission', $per->id) }}"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Delete</a>
                                                @endif --}}
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
