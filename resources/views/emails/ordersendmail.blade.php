@component('mail::message')
    <p> Hello {{ $user->name }}</p>
    <p>Mã hóa đơn : {{ $orderIdRef }}</p>


    @foreach ($cart as $key => $detail)
    {{ $cart[$key]['name'] }}   Số lượng:{{ $cart[$key]['soluong'] }}   {{ number_format($cart[$key]['gia'], 0, ',', '.') }}đ
    @endforeach

    Tổng:{{ number_format($tong, 0, ',', '.') }}đ
@endcomponent
