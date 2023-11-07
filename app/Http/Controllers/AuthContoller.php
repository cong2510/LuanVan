<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Theloai;
use App\Models\User;
use toastr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\RegisterMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class AuthContoller extends Controller
{
    public function login()
    {
        $theloai = Theloai::all();
        $role= Role::all();

        return view('login', [
            'theloai' => $theloai,
            'role' => $role,
    ]);
    }

    public function signup()
    {
        $theloai = Theloai::all();
        $role= Role::all();

        return view('signup', [
            'theloai' => $theloai,
            'role' => $role,
    ]);
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
            if (!$userGoogleExist) {
                if($userExist->email_verified_at == null)
                {
                    $user = DB::table('users')->where('email', '=', $userGoogle->getEmail())
                    ->update(
                        [
                            'google_id' => $userGoogle->getId(),
                            'email_verified_at' => Carbon::now(),
                        ]
                    );
                }
                else{
                    $user = DB::table('users')->where('email', '=', $userGoogle->getEmail())
                    ->update(
                        [
                            'google_id' => $userGoogle->getId(),
                        ]
                    );
                }
            } else {
                Auth::loginUsingId($userExist->id);
                toastr()->success('Chào mừng!', "Thanh Ngan Shop", ['timeOut' => 5000]);
                return redirect(route('index'));
            }
        } else {
            $user = DB::table('users')
                ->insertGetId(
                    [
                        'name' => $userGoogle->getName(),
                        'email' => $userGoogle->getEmail(),
                        'password' => Hash::make(Str::random(8)),
                        'google_id' => $userGoogle->getId(),
                        'email_verified_at' => Carbon::now(),
                    ]
                );

            Auth::loginUsingId($user);
            return redirect(route('index'));
        }

        Auth::loginUsingId($userExist->id);
        toastr()->success('Chào mừng!', "Thanh Ngan Shop", ['timeOut' => 5000]);
        return redirect(route('index'));
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

            return redirect()->back()->with('signup_success', 'Đăng ký thành công');;;
        }
        return redirect(route('signup'))->with('user_already_exist', 'Email đã tồn tại!');;
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

        if ($checkVerify->email_verified_at == null) {
            toastr()->warning('', 'Bạn chưa xác thực tài khoản!');
            return redirect()->back();
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            toastr()->success('Chào mừng!', "Đăng nhập thành công!", ['timeOut' => 5000]);
            return redirect(route('index'));
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

            toastr()->success('Chào mừng!', "Xác thực email thành công!", ['timeOut' => 5000]);
            return redirect(route('login'));
        } else {
            abort(404);
        }
    }
}
