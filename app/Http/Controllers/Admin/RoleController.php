<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::query()->paginate(10);

        return view('admin.permission.allpermission', [
            'permissions' => $permissions,
        ]);
    }

    public function AddPermission()
    {
        return view('admin.permission.addpermission');
    }

    public function StorePermission(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:50'
                ],
                'group_name' => [
                    'required',
                ],
            ],
            [
                'name.required' => "Thiếu tên quyền!",
                'name.string' => "Tên quyền cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên quyền tối đa 50 ký tự",

                'group_name.required' => "Thiếu nhóm quyền!",
            ]
        );

        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        toastr()->success("", 'Thêm quyền thành công', ['timeOut' => 5000]);
        return redirect()->route('all.permission');
    }

    public function EditPermission($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permission.editpermission', [
            'permission' => $permission,
        ]);
    }

    public function UpdatePermission(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:50'
                ],
                'group_name' => [
                    'required',
                ],
            ],
            [
                'name.required' => "Thiếu tên quyền!",
                'name.string' => "Tên quyền cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên quyền tối đa 50 ký tự",

                'group_name.required' => "Thiếu nhóm quyền!",
            ]
        );

        $per_id = $request->id;
        Permission::findOrFail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        toastr()->success("", 'Cập nhật quyền thành công', ['timeOut' => 5000]);
        return redirect()->route('all.permission');
    }

    public function DeletePermission($id)
    {
        Permission::findOrFail($id)->delete();
        toastr()->success("", 'Xóa quyền thành công', ['timeOut' => 5000]);
        return redirect()->route('all.permission');
    }

    public function ImportPermission()
    {

        return view('admin.permission.importpermission');
    }

    public function Export()
    {
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request)
    {
        $request->validate(
            [
                'importfile' => 'required|mimes:xlx,xls,xlsx|max:2048'
            ],
            [
                'importfile.required' => "Chọn file muốn import!",
                'importfile.mimes' => "File phải là dạng xlsx!",
            ]
        );

        Excel::import(new PermissionImport, $request->file('importfile'));
        return redirect()->back()->with('success', 'Import file thành công!');
    }
}
