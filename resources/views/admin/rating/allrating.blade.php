@extends('admin.indexAdmin')
@section('page_title')
    Danh sách đánh giá
@endsection
@section('content')
    <style>
        textarea[readonly] {
            background-color: #f8f8f8;
            /* Add a background color to indicate readonly state */
            cursor: not-allowed;
            /* Change the cursor to indicate non-clickable */
            border: none;
            /* Remove the border */
        }
    </style>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách đánh giá</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ratingTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Nội dung</th>
                                <th>Rate</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ratings as $key => $rating)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <textarea name="" id="" cols="90" rows="4" disabled class="no-resize" style="border: 0">{{ $rating->content }}
                                        </textarea>
                                    </td>
                                    <td>{{ $rating->rating }}</td>
                                    <td>
                                        <form action="{{ route('delete.rating') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="ratingid" value="{{ $rating->id }}">
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
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
            $('#ratingTable').DataTable();
        });
    </script>
@endsection
