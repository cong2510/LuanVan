<?php

namespace App\Http\Controllers;

use toastr;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Brand;
use App\Models\Theloai;
use App\Mail\RegisterMail;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;


class AuthContoller extends Controller
{
    public function login()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $brand = Brand::all();

        if (auth()->check()) {
            return redirect()->back();
        } else {
            return view('login', [
                'theloai' => $theloai,
                'role' => $role,
                'brand' => $brand,
            ]);
        }
    }

    public function signup()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $brand = Brand::all();

        if (auth()->check()) {
            return redirect()->back();
        } else {
            return view('signup', [
                'theloai' => $theloai,
                'role' => $role,
                'brand' => $brand,
            ]);
        }
    }

    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginGoogleCallback()
    {
        $userGoogle = Socialite::driver('google')->user();

        $userExist = DB::table('users')
            ->where('email', '=', $userGoogle->getEmail())
            ->first();

        $userGoogleExist = DB::table('users')
            ->where('google_id', '=', $userGoogle->getId())
            ->first();

        if ($userExist) {
            if ($userGoogleExist) {
                Auth::loginUsingId($userExist->id);
                toastr()->success('Chào mừng!', "Thanh Ngan Shop", ['timeOut' => 1000]);
                return redirect(route('index'));
            } else {
                toastr()->warning('Đã tồn tại tài khoản!', "", ['timeOut' => 1000]);
                return redirect(route('login'));
            }
        } else {
            $user = DB::table('users')
                ->insertGetId(
                    [
                        'name' => $userGoogle->getName(),
                        'email' => $userGoogle->getEmail(),
                        'password' => Hash::make(Str::random(40)),
                        'google_id' => $userGoogle->getId(),
                        'email_verified_at' => Carbon::now(),
                    ]
                );

            Auth::loginUsingId($user);
            toastr()->success('Chào mừng!', "Thanh Ngan Shop", ['timeOut' => 1000]);
            return redirect(route('index'));
        }
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function createUser(Request $request)
    {
        $request->validate(
            [
                'email' => [
                    'required',
                    'email'
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255'
                ],
                'password' => [
                    'required',
                    'confirmed',
                    'min:8'
                ]
            ],
            [
                'email.required' => "Thiếu email!",
                'email.email' => "Email không hợp lệ!",

                'name.required' => "Thiếu họ và tên!",
                'name.string' => "Tên đăng nhập cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên đăng nhập tối đa 255 ký tự",

                'password.required' => "Thiếu mật khẩu!",
                'password.confirmed' => "Mật khẩu không trùng khớp",
                'password.min' => "Mật khẩu phải từ 8 ký tự trở lên"
            ]
        );

        $userExist = DB::table('users')
            ->where('email', '=', $request->get('email'))
            ->first();

        if ($userExist == null) {

            // $user = User::create([
            //     'name' => $request->get('name'),
            //     'email' => $request->get('email'),
            //     'password' => Hash::make($request->get('password')),
            //     'remember_token' => Str::random(40),
            // ]);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(40);
            $user->save();

            Mail::to($user->email)->send(new RegisterMail($user));

            return redirect()->back()->with('signup_success', 'Đăng ký thành công');
        }
        return redirect(route('signup'))->with('user_already_exist', 'Email đã tồn tại!');
    }

    public function loginUser(Request $request)
    {

        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                'email.required' => "Thiếu email!",
                'email.email' => "Email không hợp lệ!",
                'password.required' => "Thiếu mật khẩu!"
            ]
        );

        $checkVerify = DB::table('users')
            ->where('email', '=', $request->get('email'))
            ->first();

        if (!$checkVerify) {
            return redirect()->back()->with('user_not_found', 'Email không tồn tại!');
        } else {
            if ($checkVerify->email_verified_at == null) {
                toastr()->warning('', 'Bạn chưa xác thực tài khoản!');
                return redirect()->back();
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                toastr()->success('Chào mừng!', "Đăng nhập thành công!", ['timeOut' => 1000]);
                return redirect(route('index'));
            } else {
                return redirect()->back()->with('user_not_found', 'Email hoặc mật khẩu không chính xác!');
            }
        }
    }

    public function verify($token)
    {
        $user = DB::table('users')->where('remember_token', '=', $token);
        if (!empty($user)) {
            $user->update(
                [
                    'remember_token' => Str::random(40),
                    'email_verified_at' => Carbon::now(),
                ]
            );
            // $user->email_verified_at = date('Y-m-d H:i:s');
            // $user->remember_token = Str::random(40);
            // $user->save();

            toastr()->success('Chào mừng!', "Xác thực email thành công!", ['timeOut' => 1000]);
            return redirect(route('login'));
        } else {
            abort(404);
        }
    }

    public function forgotPassword()
    {
        $theloai = Theloai::all();
        $role = Role::all();
        $brand = Brand::all();

        if (auth()->check()) {
            return redirect()->back();
        } else {
            return view('forgotPassword', [
                'theloai' => $theloai,
                'role' => $role,
                'brand' => $brand,
            ]);
        }

    }

    public function storeForgotPassword(Request $request)
    {
        $request->validate(
            [
                'email' => [
                    'required',
                    'email'
                ],
            ],
            [
                'email.required' => "Thiếu email!",
                'email.email' => "Email không hợp lệ!",
            ]
        );

        $user = User::where('email', '=', $request->email)->first();
        if ($user != null) {
            if ($user->google_id != null) {
                return redirect()->back()->with('error', 'Email không hợp lệ');
            } else {
                $user->remember_token = Str::random(40);
                $user->save();

                Mail::to($user->email)->send(new ForgotPasswordMail($user));
                return redirect()->back()->with('success', 'Kiểm tra email và khôi phục mật khẩu');
            }
        } else {
            return redirect()->back()->with('error', 'Email không tồn tại');
        }
    }

    public function resetPassword($token)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if ($user != null) {
            $data['user'] = $user;
            return view('resetpassword', $data);
        } else {
            abort(404);
        }
    }

    public function postResetPassword($token, Request $request)
    {
        $request->validate(
            [
                'password' => [
                    'required',
                    'confirmed',
                    'min:8'
                ]
            ],
            [
                'password.required' => "Thiếu mật khẩu!",
                'password.confirmed' => "Mật khẩu không trùng khớp",
                'password.min' => "Mật khẩu phải từ 8 ký tự trở lên"
            ]
        );

        $user = User::where('remember_token', '=', $token)->first();
        if ($user != null) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->remember_token = Str::random(40);
                $user->save();

                return redirect(route('login'))->with('success', "Đặt lại mật khẩu thành công!");
            } else {
                return redirect()->back()->with('error', 'Mật khẩu không trùng khớp!');
            }
        } else {
            abort(404);
        }
    }
}
