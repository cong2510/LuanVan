<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('cdn')

    <x-home.header :theloai="$theloai" :role="$role" title="Trang cá nhân" />
</head>

<body>
    {{-- {{ dd($orders) }}; --}}
    <br>
    <div class="container">
        <h5>Tên: {{ auth()->user()->name }}</h5>
        <h5></h5>
        <h5></h5>
    </div>
    <div class="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Danh sách yêu
                    thích</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Thông tin tài
                    khoản</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Lịch sử mua
                    hàng</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                abc
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <x-user.basicinfo :address="$address" />
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <x-user.orderhistory :orders="$orders" :image="$image" :paymentmethod="$paymentmethod" />
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
    integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
</script>
<x-home.footer />

</html>
