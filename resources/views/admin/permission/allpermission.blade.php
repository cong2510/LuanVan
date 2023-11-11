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
                <a class="btn btn-success" href="{{ route('import.permission') }}" role="button">Import</a>&nbsp;
                <a class="btn btn-danger" href="{{ route('export.permission') }}" role="button">Export</a>
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
                                    <td>
                                        <div class="dropdown text-center">
                                            <button type="button" class="btn p-0 " data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"><i class="fa-solid fa-gear"
                                                        style="color: #000000;"></i></i></button>
                                            <div class="dropdown-menu">
                                                @if (Auth::user()->can('editPermission'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('edit.permission', $per->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i>
                                                        Edit</a>
                                                @endif
                                                {{-- @if (Auth::user()->can('deletePermission'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('delete.permission', $per->id) }}"><i
                                                            class="bx bx-trash me-1"></i>
                                                        Delete</a>
                                                @endif --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Permission name</th>
                                <th>Group name</th>
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
