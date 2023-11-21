<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Theloai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function InforUser()
    {
        $theloai = Theloai::all();
        $role = Role::all();

        return view('infor',[
            'theloai' => $theloai,
            'role' => $role,
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
                    ]
                ],
                [
                    'gender.in' => "Chọn giới tính!",
                ]
            );
            DB::table('users')
                ->where('id', '=', auth()->user()->id)
                ->update([
                    'gender' => $request->get('gender'),
                ]);
        }
        return redirect(route('inforuser'));
    }
}
