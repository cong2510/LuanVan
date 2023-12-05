<?php

namespace App\Http\Controllers\Admin;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PromoController extends Controller
{
    public function AllPromo()
    {
        $promos = PromoCode::all();

        return view('admin.promo.allpromo', [
            'promos' => $promos,
        ]);
    }

    public function AddPromo()
    {
        return view('admin.promo.addpromo');
    }

    public function StorePromo(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'max:20',
                    'unique:promocode,name'
                ],
                'type' => [
                    'required',
                ],
                'value' => [
                    'required',
                    'numeric',
                ],
                'max_usage' => [
                    'required',
                    'numeric',
                ],
                'max_usage_per_users' => [
                    'required',
                    'numeric',
                ],
                'end_date' => [
                    'required',
                    'date',
                ],

            ],
            [
                'name.required' => "Thiếu code!",
                'name.max' => "Tên quyền tối đa 20 ký tự",
                'name.unique' => 'Code đã tồn tại!',

                'type.required' => "Thiếu loại code!",

                'value.required' => "Thiếu số tiền giảm!",
                'value.numeric' => "Phải là số!",

                'max_usage.required' => "Thiếu số lần sử dụng!",
                'max_usage.numeric' => "Phải là số!",

                'max_usage_per_users.required' => "Thiếu số lần tài khoản sử dụng!",
                'max_usage_per_users.numeric' => "Phải là số!",

                'end_date.required' => "Thiếu ngày hết hạn!",
            ]
        );


        if ($request->type == "2") {
            if ($request->value > 100)
            {
                return redirect()->back()->with("value_incorrect", "Phải dưới 100 và trên 0");
            }

            DB::table('promocode')->insert([
                'name' => $request->name,
                'type' => "Percent",
                'value' => $request->value,
                'max_usage' => $request->max_usage,
                'max_usage_per_users' => $request->max_usage_per_users,
                'end_date' => $request->end_date,
            ]);

        } else {

            DB::table('promocode')->insert([
                'name' => $request->name,
                'type' => "Cash",
                'value' => $request->value,
                'max_usage' => $request->max_usage,
                'max_usage_per_users' => $request->max_usage_per_users,
                'end_date' => $request->end_date,
            ]);

        }

        toastr()->success("", 'Thêm mã thành công', ['timeOut' => 1000]);
        return redirect()->route('all.promo');
    }

    public function DeletePromo($id)
    {
        DB::table('promocode')->where('id', $id)->delete();
        toastr()->success('','Xóa thành công!', [''=> 100]);
        return redirect()->route('all.promo');
    }

    public function EditPromo($id)
    {
        $promo = PromoCode::findOrFail($id);

        return view('admin.promo.editpromo', [
            'promo' => $promo,
        ]);
    }

    public function UpdatePromo(Request $request)
    {
        $promo_id = $request->id;
        $request->validate(
            [
                'name' => [
                    'required',
                    'max:20',
                ],
                'type' => [
                    'required',
                ],
                'value' => [
                    'required',
                    'numeric',
                ],
                'max_usage' => [
                    'required',
                    'numeric',
                ],
                'max_usage_per_users' => [
                    'required',
                    'numeric',
                ],
                'end_date' => [
                    'required',
                    'date',
                ],

            ],
            [
                'name.required' => "Thiếu code!",
                'name.max' => "Tên quyền tối đa 20 ký tự",

                'type.required' => "Thiếu loại code!",

                'value.required' => "Thiếu số tiền giảm!",
                'value.numeric' => "Phải là số!",

                'max_usage.required' => "Thiếu số lần sử dụng!",
                'max_usage.numeric' => "Phải là số!",

                'max_usage_per_users.required' => "Thiếu số lần tài khoản sử dụng!",
                'max_usage_per_users.numeric' => "Phải là số!",

                'end_date.required' => "Thiếu ngày hết hạn!",
            ]
        );


        if ($request->type == "2") {
            if ($request->value > 100)
            {
                return redirect()->back()->with("value_incorrect", "Phải dưới 100 và trên 0");
            }

            DB::table('promocode')->where('id', $promo_id)->update([
                'name' => $request->name,
                'type' => "Percent",
                'value' => $request->value,
                'max_usage' => $request->max_usage,
                'max_usage_per_users' => $request->max_usage_per_users,
                'end_date' => $request->end_date,
            ]);

        } else {

            DB::table('promocode')->where('id', $promo_id)->update([
                'name' => $request->name,
                'type' => "Cash",
                'value' => $request->value,
                'max_usage' => $request->max_usage,
                'max_usage_per_users' => $request->max_usage_per_users,
                'end_date' => $request->end_date,
            ]);

        }

        toastr()->success("", 'Cập nhật mã thành công', ['timeOut' => 1000]);
        return redirect()->route('all.promo');
    }
}
