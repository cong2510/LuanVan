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
                @if (Auth::user()->can('addRole'))
                    <a class="btn btn-primary" href="{{ route('add.roles') }}" role="button">Thêm role</a>&nbsp;
                @endif
                &nbsp;
                @if (Auth::user()->can('addPermissionToRole'))
                    <a class="btn btn-primary" href="{{ route('add.roles.permission') }}" role="button">Phân quyền cho
                        role</a>&nbsp;
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Role</th>
                                <th>Permission</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $roleper)
                                            <span class="badge bg-danger">{{ $roleper->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Sửa
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @if (Auth::user()->can('editRole'))
                                                        <a href="{{ route('edit.roles', $role->id) }}"
                                                            class="dropdown-item">
                                                            Sửa
                                                        </a>
                                                    @endif
                                                </li>
                                                <li>
                                                    @if (Auth::user()->can('editRolePermission'))
                                                        <a href="{{ route('admin.edit.roles', $role->id) }}"
                                                            class="dropdown-item">
                                                            Sửa quyền
                                                        </a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
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
