@extends('admin.indexAdmin')
@section('page_title')
    Danh sách role
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách role có quyền</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                @if (Auth::user()->can('addUserRole'))
                    {{-- <a class="btn btn-primary" href="{{ route('add.roles.user') }}" role="button">Thêm role cho user</a>&nbsp; --}}
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $roleuser)
                                            <span class="badge bg-danger">{{ $roleuser->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if (Auth::user()->can('editUserRole'))
                                            <a href="{{ route('admin.edit.user', $user->id) }}" class="btn btn-info">
                                                    Sửa
                                            </a>
                                        @endif
                                        {{-- <a class="dropdown-item"
                                                    href="{{ route('admin.delete.roles', $role->id) }}"><i
                                                        class="bx bx-trash me-1"></i>
                                                    Delete</a> --}}
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
