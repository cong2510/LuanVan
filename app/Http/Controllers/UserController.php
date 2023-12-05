<?php

namespace App\Http\Controllers;

use App\Models\Role;
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


    public function InforUser()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $address = Address::all();

        // $responseTP = Http::get($this->apiUrlTP);
        // $thanhpho = $responseTP->json();
        // $responseQ = Http::get($this->apiUrlQ);
        // $quan = $responseQ->json();
        // $responseP = Http::get($this->apiUrlP);
        // $phuong = $responseP->json();
        $user = Auth::user();
        $orders = Order::with('orderdetail')->where('user_id', $user->id)->get();
        $paymentmethod = PaymentMethod::all();
        $image = DB::table('image')->get();
        $favorites = Favorite::with('sanpham')->where('user_id', $user->id)->get();


        return view('infor', [
            'theloai' => $theloai,
            'role' => $role,
            'address' => $address,
            'orders' => $orders,
            'image' => $image,
            'paymentmethod' => $paymentmethod,
            'favorites' => $favorites
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

        return redirect()->back();
    }

    public function DeleteAddress($id)
    {
        DB::table('address')->where('id', $id)->delete();
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
                if($code->end_date < Carbon::now())
                {
                    return redirect()->back()->with('expired_code', 'Mã giảm giá đã hết hạn!');
                }
                if ($promo_user->promocode_id == $code->id) { {
                        if ($code->max_usage_per_users == count((array)$promo_user->promocode_id)) {
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
}
