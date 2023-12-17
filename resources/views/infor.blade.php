<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')
    <x-home.header :theloai="$theloai" :role="$role" :brand="$brand" title="Cài đặt tài khoản" />
</head>

<body>
    <br>
    {{-- {{ dd($orders) }}; --}}
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col-2 col-lg-auto mb-3" style="width: auto;">
                <div class="card p-3">
                    <div class="e-navlist e-navlist--active-bg">
                        <ul class="nav d-flex flex-column">
                            <li class="nav-item"><a class="nav-link text-dark px-2 active" href="{{ route('basicinforuser') }}"><i
                                        class="fa fa-fw fa-user mr-1"></i><span>Thông tin cá nhân</span></a></li>
                            <li class="nav-item"><a class="nav-link text-dark px-2" href="{{ route('orderhistoryuser') }}"><i
                                        class="fa fa-fw fa-receipt mr-1"></i><span>Lịch sử đơn hàng</span></a></li>
                            <li class="nav-item"><a class="nav-link text-dark px-2" href="{{ route('favoriteuser') }}"><i
                                        class="fa fa-fw fa-heart mr-1"></i><span>Danh sách yêu thích</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-10">
                @yield('content')
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
    integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    const host = "https://provinces.open-api.vn/api/";
    var callAPI = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data, "thanhpho"); // Truyền dữ liệu lấy từ api
            });
    }
    callAPI('https://provinces.open-api.vn/api/?depth=1');
    var callApiDistrict = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data.districts, "quan");
            });
    }
    var callApiWard = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data.wards, "phuong");
            });
    }

    var renderData = (array, select) => {
        let row = ' <option disable value="">Chọn</option>'; // tạo thẻ option ban đầu
        array.forEach(element => { //foreach từ màng thành các thẻ option với các name và value
            row += `<option value="${element.name}" id="${element.code}" >${element.name}</option>`
        });
        document.querySelector("#" + select).innerHTML = row //Tìm thẻ select rồi gán dữ liệu vào
    }

    $("#thanhpho").change(() => {
        let selectedValue = $("#thanhpho").val(); // Lấy value của thẻ option
        let selectedId = $("#thanhpho option[value='" + selectedValue + "']").attr(
            "id"); //Lấy dữ liệu từ id theo value
        callApiDistrict(host + "p/" + selectedId + "?depth=2"); // Gọi Api
    });
    $("#quan").change(() => {
        let selectedValue = $("#quan").val();
        let selectedId = $("#quan option[value='" + selectedValue + "']").attr("id");
        callApiWard(host + "d/" + selectedId + "?depth=2");
    });


    $(document).ready(function() {
        $('#orderhistory').DataTable();
    });
</script>
<x-home.footer />

</html>
