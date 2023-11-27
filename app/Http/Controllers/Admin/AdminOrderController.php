<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminOrderController extends Controller
{
    public function AllOrder()
    {
        $orders = Order::query()->with('orderdetail')->get();
        $paymentmethod = PaymentMethod::all();
        $image = DB::table('image')->get();
        $sanpham = Sanpham::all();

        return view('admin.order.allorder', [
            'orders' => $orders,
            'paymentmethod' => $paymentmethod,
            'image' => $image,
            'sanpham' => $sanpham,
        ]);
    }

    public function UpdateOrderPending(Request $request)
    {
        $details = $request->orderdetails;

        $order = Order::find($request->orderid);

        $order->update([
            'order_status' => Order::ORDER_STATUS[1],
        ]);

        foreach($details as $key => $item) {
            $detail = Sanpham::find($item['sanphamid']);

            $sanphamsoluong = $detail->soluong - $item['soluong'];

            $detail->update([
                'soluong' => $sanphamsoluong,
            ]);
        }

        return back();
    }

    public function UpdateOrderOnWay(Request $request)
    {
        $order = Order::find($request->orderid);

        $order->update([
            'order_status' => Order::ORDER_STATUS[2],
        ]);

        return back();
    }
}
