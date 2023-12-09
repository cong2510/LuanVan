<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Role;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Order;
use App\Models\Address;
use App\Models\Sanpham;
use App\Models\Theloai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function Cart()
    {
        $sanphams = Sanpham::query()->with('theloai')->get();
        $theloai = Theloai::all();
        $role = Role::all();
        $image = Image::all();
        $brand = Brand::all();
        $sanpham_theloai = DB::table('sanpham_theloai')->get();

        return view('cart', [
            'sanphams' => $sanphams,
            'theloai' => $theloai,
            'role' => $role,
            'image' => $image,
            'brand' => $brand,
            'sanpham_theloai' => $sanpham_theloai,
        ]);
    }

    public function AddToCart(Request $request)
    {
        // dd($request);
        $id = $request->get('id');
        $sanpham = Sanpham::findOrFail($id);
        $hinh = DB::table('image')->where('sanpham_id', $id)->first();

        $soluong = $request->soluong;



        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['soluong'] + $soluong > $sanpham->soluong) {
                toastr()->warning('', 'Đã đạt tối đa sản phẩm!');
                return redirect()->back();
            }
        }

        if (isset($cart[$id])) {
            if (isset($soluong)) {
                $cart[$id]['soluong'] = $cart[$id]['soluong'] + $soluong;
            } else {
                $cart[$id]['soluong'] = $cart[$id]['soluong'] + 1;
            }
        } else {
            if ($soluong != null) {
                $cart[$id] = [
                    'id' => $sanpham->id,
                    'name' => $sanpham->name,
                    'gia' => $sanpham->gia,
                    'image' => $hinh,
                    'soluong' => $soluong,
                    'brand_id' => $sanpham->brand_id,
                ];
            } else {
                $cart[$id] = [
                    'id' => $sanpham->id,
                    'name' => $sanpham->name,
                    'gia' => $sanpham->gia,
                    'image' => $hinh,
                    'soluong' => 1,
                    'brand_id' => $sanpham->brand_id,
                ];
            }
        }

        session()->put('cart', $cart);
        toastr()->success('', 'Thêm vào giỏ hàng thành công');
        return redirect()->back();
    }

    public function RemoveItem(Request $request)
    {
        // If has the id, remove it
        $cart = session()->get('cart');
        if ($request->id) {
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            toastr()->success('', 'Xóa sản phẩm thành công');
            return redirect()->back();
        }
        // If the request has 'clear_all', remove the entire cart
        if ($request->has('clear_all')) {
            session()->put('cart', null);

            toastr()->success('', 'Xóa giỏ hàng thành công');
            return redirect()->back();
        }
        return redirect()->back()->with('unknow_error', "Something went wrong");
    }

    public function UpdateItem(Request $request)
    {
        $sanpham = Sanpham::findOrFail($request->id);
        $id = $request->id;
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            if ($request->down == "true") {
                if ($cart[$id]['soluong'] == 1) {
                    return redirect()->back();
                } else {
                    $cart[$id]['soluong'] = $cart[$id]['soluong'] - 1;
                    session()->put('cart', $cart);
                    return redirect()->back();
                }
            } elseif ($request->up == "false") {
                if ($cart[$id]['soluong'] == $sanpham->soluong) {
                    return redirect()->back();
                } else {
                    $cart[$id]['soluong'] = $cart[$id]['soluong'] + 1;
                    session()->put('cart', $cart);
                    return redirect()->back();
                }
            }
        } else {
            toastr()->warning('', 'Loi');
            return redirect()->back();
        }
    }

    public function Checkout()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $address = Address::all();
        $brand = Brand::all();

        return view('paycheck', [
            'theloai' => $theloai,
            'role' => $role,
            'address' => $address,
            'brand' => $brand,
        ]);
    }

    public function CheckoutMethod(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:100'
                ],
                'phone' => [
                    'required',
                    'string',
                    'digits:10',
                ],
                'address' => [
                    'required',
                ],
                'method' => [
                    'required',
                ],
            ],
            [
                'name.required' => "Thiếu họ và tên!",
                'name.string' => "Họ và tên cần phải là 1 chuỗi",
                'name.max' => "Họ và tên tối đa 100 ký tự",

                'phone.required' => "Thiếu số điện thoại!",
                'phone.numeric' => "Số điện thoại cần phải là 1 dãy số",
                'phone.digits' => "Số điện thoại phải là 10 số",

                'address.required' => "Thiếu địa chỉ!",

                'method.required' => "Thiếu phương thức thanh toán!",
            ]
        );

        $method = $request->method;

        if ($method == "2") {

            if ($request->address == "showInput") {
                $request->validate(
                    [
                        'anotherAddress' => [
                            'required',
                        ],
                    ],
                    [
                        'anotherAddress.required' => "Thiếu địa chỉ!",
                    ]
                );

                $user = Auth::user();
                $thanhpho = $request->thanhpho;
                $quan = $request->quan;
                $phuong = $request->phuong;

                if ($request->saveAddress) {
                    $addressAll = $request->get('anotherAddress') . ", " . $thanhpho . ", " . $quan . ", " . $phuong;
                    DB::table('address')->insert([
                        'address' => $addressAll,
                        'user_id' => $user->id,
                    ]);
                } else {
                    $addressAll = $request->get('anotherAddress') . ", " . $thanhpho . ", " . $quan . ", " . $phuong;
                }

            } else {
                $addressAll = $request->address;
            }

            $diachi[] = $addressAll;
            $phone[] = $request->phone;

            $items = array_combine($diachi, $phone);

            $vnp_Url = env('VNPAY_URL');
            $vnp_Returnurl = "http://localhost:8000/user/checkout/success-vnpay";
            $vnp_TmnCode = env('VNPAY_TERMINAL_CODE'); //Mã website tại VNPAY
            $vnp_HashSecret = env('VNPAY_SECRET_CODE'); //Chuỗi bí mật

            $vnp_TxnRef = Str::upper(Str::random(8)); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = json_encode($items);
            $vnp_OrderType = 'Thanh toan hoa don';
            $vnp_Amount = $request->get('total') * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            // }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }


        } else {

            $user = Auth::user();
            $orderIdRef = Str::upper(Str::random(8));

            $codes = session()->get('promocode');
            $promocodes = array();

            if ($codes != null) {
                foreach ($codes as $code) {
                    $promocodes[] = [
                        'id' => $code['id'],
                        'name' => $code['name'],
                        'value' => $code['value'],
                        'type' => $code['type'],
                    ];
                }
            }

            // dd($promocodes);

            if ($request->address == "showInput") {
                $request->validate(
                    [
                        'anotherAddress' => [
                            'required',
                        ],
                    ],
                    [
                        'anotherAddress.required' => "Thiếu địa chỉ!",
                    ]
                );

                $thanhpho = $request->thanhpho;
                $quan = $request->quan;
                $phuong = $request->phuong;

                $addressAll = $request->get('anotherAddress') . ", " . $thanhpho . ", " . $quan . ", " . $phuong;

                if ($thanhpho && $quan && $phuong && $request->get('anotherAddress')) {
                    if ($codes != null) {
                        $orderId = DB::table('order')
                            ->insertGetId(
                                [
                                    'user_id' => $user->id,
                                    'name' => $request->name,
                                    'email' => $user->email,
                                    'diachi' => $addressAll,
                                    'phone' => $request->phone,
                                    'totalprice' => $request->total,
                                    'order_status' => "Pending",
                                    'order_id_ref' => $orderIdRef,
                                    'promocode_id' => $promocodes[0]['id'],
                                ]
                            );
                    } else {
                        $orderId = DB::table('order')
                            ->insertGetId(
                                [
                                    'user_id' => $user->id,
                                    'name' => $request->name,
                                    'email' => $user->email,
                                    'diachi' => $addressAll,
                                    'phone' => $request->phone,
                                    'totalprice' => $request->total,
                                    'order_status' => "Pending",
                                    'order_id_ref' => $orderIdRef,
                                    'promocode_id' => 0,
                                ]
                            );
                    }

                    if ($request->saveAddress) {
                        DB::table('address')->insert([
                            'address' => $addressAll,
                            'user_id' => $user->id,
                        ]);
                    }
                } else {
                    return redirect()->back();
                }
            } else {
                if ($codes != null) {
                    $orderId = DB::table('order')
                        ->insertGetId(
                            [
                                'user_id' => $user->id,
                                'name' => $request->name,
                                'email' => $user->email,
                                'diachi' => $request->address,
                                'phone' => $request->phone,
                                'totalprice' => $request->total,
                                'order_status' => "Pending",
                                'order_id_ref' => $orderIdRef,
                                'promocode_id' => $promocodes[0]['id'],
                            ]
                        );
                } else {
                    $orderId = DB::table('order')
                        ->insertGetId(
                            [
                                'user_id' => $user->id,
                                'name' => $request->name,
                                'email' => $user->email,
                                'diachi' => $request->address,
                                'phone' => $request->phone,
                                'totalprice' => $request->total,
                                'order_status' => "Pending",
                                'order_id_ref' => $orderIdRef,
                                'promocode_id' => 0,
                            ]
                        );
                }
            }

            DB::table('paymentmethods')->insert([
                'order_id' => $orderId,
                'name' => "COD",
            ]);

            $cart = session()->get('cart');

            foreach ($cart as $key => $value) {
                $sanpham = Sanpham::find($key);
                DB::table('order_detail')
                    ->insert(
                        [
                            'sanpham_id' => $key,
                            'order_id' => $orderId,
                            'name' => $sanpham->name,
                            'gia' => $sanpham->gia,
                            'soluong' => $cart[$key]['soluong'],
                        ]
                    );
            }

            if ($codes != null) {
                DB::table('users_promocode')->insert([
                    'user_id' => $user->id,
                    'promocode_id' => $promocodes[0]['id'],
                ]);

                $max_usage = DB::table('promocode')->select('max_usage')->where('id', $promocodes[0]['id'])->first();
                // dd($max_usage->max_usage);

                DB::table('promocode')->where('id', $promocodes[0]['id'])->update([
                    'max_usage' => $max_usage->max_usage - 1,
                ]);

            }

            $tong = $request->total;
            Mail::to($user->email)->send(new OrderMail($user, $orderIdRef, $tong, $cart));

            session()->put('cart', null);
            session()->put('promocode', null);

            return redirect()->route('cart')->with('order_success', 'Đặt hàng thành công!');
        }

    }

    public function CheckoutSuccessVNPAY(Request $request)
    {
        // dd($request);
        $user = Auth::user();

        $orderInfo = json_decode($request->vnp_OrderInfo, true);
        $orderTotal = ($request->vnp_Amount) / 100;
        $orderIdRef = $request->vnp_TxnRef;

        $codes = session()->get('promocode');
        $promocodes = array();

        if ($codes != null) {
            foreach ($codes as $code) {
                $promocodes[] = [
                    'id' => $code['id'],
                    'name' => $code['name'],
                    'value' => $code['value'],
                    'type' => $code['type'],
                ];
            }

            foreach ($orderInfo as $diachi => $phone) {
                $orderId = DB::table('order')
                    ->insertGetId(
                        [
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'diachi' => $diachi,
                            'phone' => $phone,
                            'totalprice' => $orderTotal,
                            'order_status' => "Pending",
                            'order_id_ref' => $orderIdRef,
                            'promocode_id' => $promocodes[0]['id'],
                        ]
                    );
            }

            DB::table('users_promocode')->insert([
                'user_id' => $user->id,
                'promocode_id' => $promocodes[0]['id'],
            ]);

            $max_usage = DB::table('promocode')->select('max_usage')->where('id', $promocodes[0]['id'])->first();
            // dd($max_usage->max_usage);

            DB::table('promocode')->where('id', $promocodes[0]['id'])->update([
                'max_usage' => $max_usage->max_usage - 1,
            ]);

        } else {
            foreach ($orderInfo as $diachi => $phone) {
                $orderId = DB::table('order')
                    ->insertGetId(
                        [
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'diachi' => $diachi,
                            'phone' => $phone,
                            'totalprice' => $orderTotal,
                            'order_status' => "Pending",
                            'order_id_ref' => $orderIdRef,
                            'promocode_id' => 0,
                        ]
                    );
            }
        }


        DB::table('paymentmethods')->insert([
            'order_id' => $orderId,
            'name' => "VNPAY",
        ]);

        $cart = session()->get('cart');

        foreach ($cart as $key => $value) {
            $sanpham = Sanpham::find($key);
            DB::table('order_detail')
                ->insert(
                    [
                        'sanpham_id' => $key,
                        'order_id' => $orderId,
                        'name' => $sanpham->name,
                        'gia' => $sanpham->gia,
                        'soluong' => $cart[$key]['soluong'],
                    ]
                );
        }

        $tong = $request->total;
        Mail::to($user->email)->send(new OrderMail($user, $orderIdRef, $tong, $cart));


        session()->put('cart', null);

        return redirect()->route('cart')->with('order_success', 'Đặt hàng thành công!');
    }
}
