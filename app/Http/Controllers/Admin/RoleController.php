<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::all();

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
                    'max:50',
                    'unique:permissions,name'

                ],
                'group_name' => [
                    'required',
                ],
            ],
            [
                'name.required' => "Thiếu tên quyền!",
                'name.string' => "Tên quyền cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên quyền tối đa 50 ký tự",
                'name.unique' => 'Permission đã tồn tại!',
                'group_name.required' => "Thiếu nhóm quyền!",
            ]
        );

        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);
        toastr()->success("", 'Thêm quyền thành công', ['timeOut' => 1000]);
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

        toastr()->success("", 'Cập nhật quyền thành công', ['timeOut' => 1000]);
        return redirect()->route('all.permission');
    }

    public function DeletePermission($id)
    {
        Permission::findOrFail($id)->delete();

        toastr()->success("", 'Xóa quyền thành công', ['timeOut' => 1000]);
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


    ///////////////////Roles /////////////////////////

    public function AllRoles()
    {
        $roles = Role::all();
        return view('admin.role.allroles', [
            'roles' => $roles,
        ]);
    }

    public function AddRoles()
    {
        return view('admin.role.addroles');
    }

    public function StoreRoles(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:50',
                    'unique:roles,name'
                ],
            ],
            [

                'name.required' => "Thiếu tên role!",
                'name.string' => "Tên role cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên role tối đa 50 ký tự",
                'name.unique' => 'Role đã tồn tại!',
            ]
        );

        Role::create([
            'name' => $request->name,
        ]);
        toastr()->success("", 'Thêm role thành công', ['timeOut' => 1000]);
        return redirect()->route('all.roles');

    }

    public function EditRoles($id)
    {
        $roles = Role::findOrFail($id);

        return view('admin.role.editroles', [
            'roles' => $roles,
        ]);
    }

    public function UpdateRoles(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:50'
                ],
            ],
            [
                'name.required' => "Thiếu tên role!",
                'name.string' => "Tên role cần phải là 1 chuỗi ký tự chữ",
                'name.max' => "Tên role tối đa 50 ký tự",
            ]
        );

        $role_id = $request->id;
        Role::findOrFail($role_id)->update([
            'name' => $request->name,
        ]);

        toastr()->success("", 'Cập nhật role thành công', ['timeOut' => 1000]);
        return redirect()->route('all.roles');
    }

    public function DeleteRoles($id)
    {
        Role::findOrFail($id)->delete();
        toastr()->success("", 'Xóa role thành công', ['timeOut' => 1000]);
        return redirect()->route('all.roles');
    }


    //////////////// Role Permission ///////////////////

    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permission = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.rolepermission.add_roles_permission', [
            'roles' => $roles,
            'permission' => $permission,
            'permission_groups' => $permission_groups,
        ]);
    }

    public function StoreRolesPermission(Request $request)
    {
        $data = array();
        $permissions = $request->permission;

        if (!empty($permissions) && !empty($request->role_id)) {
            foreach ($permissions as $key => $per) {
                $data['role_id'] = $request->role_id;
                $data['permission_id'] = $per;

                DB::table('role_has_permissions')->insert($data);
            }
        } else {
            return redirect()->back()->with('error', 'Hãy chọn dữ liệu!');
        }

        toastr()->success("", 'Phân quyền thành công', ['timeOut' => 1000]);
        return redirect()->route('all.roles.permission');
    }

    public function AllRolesPermission()
    {
        $roles = Role::all();
        return view('admin.rolepermission.all_roles_permission', [
            'roles' => $roles,
        ]);
    }

    public function AdminEditRoles($id)
    {
        $role = Role::findOrFail($id);
        $permission = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.rolepermission.edit_roles_permission', [
            'role' => $role,
            'permission' => $permission,
            'permission_groups' => $permission_groups,
        ]);
    }

    public function AdminUpdateRoles(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        } else {
            $role->revokePermissionTo($permissions);
        }

        toastr()->success("", 'Cập nhật quyền role thành công', ['timeOut' => 1000]);
        return redirect()->route('all.roles.permission');
    }

    // public function AdminDeleteRoles($id)
    // {
    //     $role = Role::findOrFail($id);
    //     if (!is_null($role)) {
    //         $role->delete();
    //     }

    //     toastr()->success("", 'Xóa quyền role thành công', ['timeOut' => 5000]);
    //     return redirect()->route('all.roles.permission');
    // }

    //////////////// Add role cho user ///////////////////
    public function AllRolesUser()
    {
        $users = User::all();
        return view('admin.rolepermission.all_roles_user', [
            'users' => $users,
        ]);
    }

    public function AddRolesUser()
    {
        $roles = Role::all();
        $users = User::all();

        return view('admin.rolepermission.add_roles_user', [
            'roles' => $roles,
            'users' => $users,
        ]);
    }

    public function StoreRolesUser(Request $request)
    {
        $data = array();
        $roles = $request->role;

        if (!empty($roles) && !empty($request->user_id)) {
            foreach ($roles as $key => $role) {
                $data['role_id'] = $role;
                $data['model_type'] = "App/Models/User";
                $data['user_id'] = $request->user_id;

                DB::table('role_user')->insert($data);
            }
        } else {
            return redirect()->back()->with('error', 'Hãy chọn dữ liệu!');
        }

        toastr()->success("", 'Phân role thành công', ['timeOut' => 1000]);
        return redirect()->route('all.roles.user');
    }

    public function AdminEditUser($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.rolepermission.edit_roles_user', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function AdminUpdateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = $request->role;


        if (!empty($roles)) {
            $user->syncRoles($roles);
        } else {
            $user->syncRoles($roles);
        }

        toastr()->success("", 'Cập nhật user role thành công', ['timeOut' => 1000]);
        return redirect()->route('all.roles.user');
    }
}
