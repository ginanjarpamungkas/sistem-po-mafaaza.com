<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class UserController extends Controller
{
    public function getData(){
        $user = User::get();
        $role = Role::orderBy('name', 'ASC')->get();

        return view('auth.list',compact('user','role'));
    }

    public function store(Request $request){
        $validator = $this->validate($request, [
            'name' => 'required|unique:users',
            'role' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.unique' => 'Nama sudah digunakan. Coba yang lain.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.  Coba yang lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Kedua kolom password harus sama.'
        ]);
        
        $user = new User;
        $user->name = $request->name;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $user->assignRole($request->role);

        return back()->with('success', 'User baru sudah ditambahkan.');
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'successs' => 'Record Delete successsfully'
        ]);
    }
    
    public function rolePermission(Request $request){
        $role = $request->get('role');
        
        $permissions = null;
        $hasPermission = null;
        
        $roles = Role::all()->pluck('name');
        
        if (!empty($role)) {
            $getRole = Role::findByName($role);
            
            $hasPermission = DB::table('role_has_permissions')
                ->select('permissions.name')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_id', $getRole->id)->get()->pluck('name')->all();
            
            $permissions = Permission::all()->pluck('name');
        }
        return view('role.role-permission', compact('roles', 'permissions', 'hasPermission'));
    }

    public function addPermission(Request $request){
        $this->validate($request, [
            'name' => 'required|string|unique:permissions'
        ]);
    
        $permission = Permission::firstOrCreate([
            'name' => $request->name
        ]);
        return redirect()->back();
    }

    public function setRolePermission(Request $request, $role){
        $role = Role::findByName($role);
        
        $role->syncPermissions($request->permission);
        return redirect()->back()->with(['success' => 'Permission to Role Saved!']);
    }

    public function roles(Request $request, $id){
        $user = User::findOrFail($id);
        $roles = Role::all()->pluck('name');
        return view('role.roles', compact('user', 'roles'));
    }

    public function setRole(Request $request, $id){
        $this->validate($request, [
            'role' => 'required'
        ]);
    
        $user = User::findOrFail($id);
        $user->syncRoles($request->role);
        return redirect()->back()->with(['success' => 'Role Sudah Di Set']);
    }
}
