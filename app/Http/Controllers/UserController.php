<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use App\Models\Role;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Address;
use App\Models\Theloai;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    // public $apiUrlTP = "https://provinces.open-api.vn/api/p/";
    // public $apiUrlQ = "https://provinces.open-api.vn/api/d/";
    // public $apiUrlP = "https://provinces.open-api.vn/api/w/";

    public function BasicInforUser()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $address = Address::all();
        $brand = Brand::all();

        return view('user.basicinfo', [
            'theloai' => $theloai,
            'role' => $role,
            'address' => $address,
            'brand' => $brand,
        ]);
    }

    public function OrderHistoryUser()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $address = Address::all();
        $brand = Brand::all();


        $user = Auth::user();
        $orders = Order::with('orderdetail')->where('user_id', $user->id)->latest()->paginate(2);
        $paymentmethod = PaymentMethod::all();
        $image = DB::table('image')->get();
        $promos = PromoCode::all();

        $pending = Order::ORDER_STATUS[0];
        $onway = Order::ORDER_STATUS[1];
        $done = Order::ORDER_STATUS[2];
        $canceled = Order::ORDER_STATUS[3];

        return view('user.orderhistory', [
            'theloai' => $theloai,
            'role' => $role,
            'address' => $address,
            'orders' => $orders,
            'image' => $image,
            'paymentmethod' => $paymentmethod,
            'brand' => $brand,
            'promos' => $promos,
            'pending' => $pending,
            'canceled' => $canceled,
            'onway' => $onway,
            'done' => $done,
            'user' => $user,
        ]);
    }

    public function RateProduct(Request $request)
    {
        $request->validate(
            [
                'content' => [
                    'required',
                    'string',
                    'max:255'
                ],
                'rating' => [
                    'required',
                ]
            ],
            [
                'content.required' => "Thiếu đánh giá!",
                'content.string' => "Đánh giá cần phải là 1 chuỗi",
                'content.max' => "Đánh giá tối đa 255 ký tự",

                'rating.required' => "Thiếu đánh giá sao!",
            ]
        );
        $user = auth()->user();
        $sanphamid = $request->sanpham_id;
        $orderdetailid = $request->orderdetail_id;
        $rating = $request->rating;
        $content = $request->content;

        if (!$user->rating()->where('sanpham_id', $sanphamid)->where('orderdetail_id', $orderdetailid)->exists()) {

            DB::table('rating')->insert([
                'user_id' => $user->id,
                'sanpham_id' => $sanphamid,
                'orderdetail_id' => $orderdetailid,
                'content' => $content,
                'rating' => $rating,
            ]);

            return redirect()->back();
        }

        return redirect()->back()->with('error', 'You have already rated this product for the order detail.');
    }

    public function EditRateProduct(Request $request)
    {
        $id = $request->ratingid;
        if ($request->content) {
            $request->validate(
                [
                    'content' => [
                        'string',
                        'max:255'
                    ],
                ],
                [
                    'content.string' => "Đánh giá cần phải là 1 chuỗi",
                    'content.max' => "Đánh giá tối đa 255 ký tự",
                ]
            );

            if ($request->rating) {
                DB::table('rating')->where('id', $id)->update([
                    'content' => $request->content,
                    'rating' => $request->rating
                ]);
            } else {
                DB::table('rating')->where('id', $id)->update([
                    'content' => $request->content,
                ]);
            }
        }else{
            if ($request->rating)
            {
                DB::table('rating')->where('id', $id)->update([
                    'rating' => $request->rating
                ]);
            }
        }

        return redirect()->back();
    }

    public function DeleteRateProduct(Request $request)
    {
        $id = $request->deleteratingid;

        DB::table('rating')->where('id', $id)->delete();

        return redirect()->back();
    }

    public function FavoriteUser()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $address = Address::all();
        $brand = Brand::all();

        $user = Auth::user();
        $paymentmethod = PaymentMethod::all();
        $image = DB::table('image')->get();
        $favorites = Favorite::with('sanpham')->where('user_id', $user->id)->paginate(5);

        return view('user.favorite', [
            'theloai' => $theloai,
            'role' => $role,
            'address' => $address,
            'image' => $image,
            'paymentmethod' => $paymentmethod,
            'favorites' => $favorites,
            'brand' => $brand,
        ]);
    }

    public function EditUser(Request $request)
    {
        $form = $request->get('form');
        if ($form == "1") {
            $request->validate(
                [
                    'name' => [
                        'required',
                        'string',
                        'max:255'
                    ]
                ],
                [

                    'name.required' => "Thiếu tên đăng nhập!",
                    'name.string' => "Tên đăng nhập cần phải là 1 chuỗi",
                    'name.max' => "Tên đăng nhập tối đa 255 ký tự",
                ]
            );

            DB::table('users')
                ->where('id', '=', auth()->user()->id)
                ->update([
                        'name' => $request->get('name'),
                    ]);
        } else {
            $request->validate(
                [
                    'gender' => [
                        Rule::in(["Male", "Female", "Other"]),
                    ],
                ],
                [
                    'gender.in' => "Chọn giới tính!",
                ]
            );

            $thanhpho = $request->thanhpho;
            $quan = $request->quan;
            $phuong = $request->phuong;

            $addressAll = $request->get('address') . ", " . $thanhpho . ", " . $quan . ", " . $phuong;

            if ($thanhpho && $quan && $phuong && $request->get('address')) {
                DB::table('address')->insert([
                    'address' => $addressAll,
                    'user_id' => auth()->user()->id,
                ]);
            }

            DB::table('users')
                ->where('id', '=', auth()->user()->id)
                ->update([
                        'gender' => $request->get('gender'),
                    ]);

        }

        toastr()->success('', "Lưu thành công!", ['timeOut' => 100]);
        return redirect()->back();
    }

    public function DeleteAddress($id)
    {
        DB::table('address')->where('id', $id)->delete();

        toastr()->success('', "Xóa thành công!", ['timeOut' => 100]);
        return redirect()->back();
    }

    public function ChangePassword(Request $request)
    {
        $request->validate(
            [
                'old_password' => [
                    'required'
                ],
                'new_password' => [
                    'required',
                    'confirmed',
                    'min:8'
                ]
            ],
            [
                'old_password.required' => "Thiếu mật khẩu hiện tại!",

                'new_password.required' => "Thiếu mật khẩu mới!",
                'new_password.confirmed' => "Mật khẩu không trùng khớp với mật khẩu mới",
                'new_password.min' => "Mật khẩu phải từ 8 ký tự trở lên"
            ]
        );

        $user = Auth::user();
        $currentPassword = $request->get('old_password');
        if (!Hash::check($currentPassword, $user->password)) {
            return redirect(route('inforuser'))->with('old_password_mismatch', 'Mật khẩu không đúng!');
        }

        DB::table('users')
            ->where('id', '=', $user->id)
            ->update([
                    'password' => Hash::make($request->get('new_password'))
                ]);

        // Đăng xuất
        auth()->guest();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('', "Đổi mật khẩu thành công!", ['timeOut' => 1000]);
        return redirect(route('login'));
    }

    public function AddFavorite(Request $request)
    {

        $user = Auth::user();
        $favoriteId = DB::table('favorite')
            ->insertGetId(
            [
                'user_id' => $user->id,
            ]
        );

        DB::table('sanpham_favorite')->insert([
            'sanpham_id' => $request->sanphamid,
            'favorite_id' => $favoriteId,
        ]);

        return redirect()->back();
    }

    public function DeleteFavorite(Request $request)
    {
        $user = Auth::user();

        DB::table('favorite')->where('id', $request->favoriteid)->where('user_id', $user->id)->delete();

        DB::table('sanpham_favorite')->where('favorite_id', $request->favoriteid)->where('sanpham_id', $request->sanphamid)->delete();

        return redirect()->back();
    }

    public function ApplyPromo(Request $request)
    {
        $user = Auth::user();
        $codes = DB::table('promocode')->where('name', $request->promocode)->get();
        $codepromo = session()->get('promocode', []);
        // dd($codes);
        // dd(session('promocode'));

        $promo_user = DB::table('users_promocode')->where('user_id', $user->id)->get();
        // dd(count($promo_user));



        foreach ($promo_user as $promo_user) {
            foreach ($codes as $code) {
                if ($code->max_usage <= 0) {
                    return redirect()->back()->with('out_code', 'Mã giảm giá đã hết!');
                }
                if ($code->end_date < Carbon::now()) {
                    return redirect()->back()->with('expired_code', 'Mã giảm giá đã hết hạn!');
                }
                if ($promo_user->promocode_id == $code->id) { {
                        if ($code->max_usage_per_users == count((array) $promo_user->promocode_id)) {
                            return redirect()->back()->with('cant_apply', 'Tài khoản đã sài mã giảm giá này!');
                        }
                    }
                }
            }
        }


        if (isset($codepromo[0])) {
            return redirect()->back()->with('already_apply_code', 'Đã nhập mã giảm giá!');
        } else {
            foreach ($codes as $code) {
                $codepromo[] = [
                    'id' => $code->id,
                    'name' => $request->promocode,
                    'value' => $code->value,
                    'type' => $code->type,
                ];
                session()->put('promocode', $codepromo);
            }
            return redirect()->back();
        }
    }

    public function DeletePromo(Request $request)
    {
        session()->put('promocode', null);

        return redirect()->back();
    }

    public function CancelOrderUser(Request $request)
    {
        $order = Order::find($request->orderid);

        $order->update([
            'order_status' => Order::ORDER_STATUS[3],
        ]);


        toastr()->success("", 'Xóa đơn hàng!', ['timeOut' => 100]);
        return redirect()->back();
    }
}
