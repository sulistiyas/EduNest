<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function authRole($role_name){
        if (!Auth::user()->hasRole($role_name)) {
            abort(403);
        }
    }
    public function index(){
        $users_data = DB::table('users')->where('deleted_at', null)->get();
        $roles_data = DB::table('roles')->where('deleted_at', null)->get();
        foreach ($users_data as $user) {
            foreach ($roles_data as $role) {
                if ($user->role_id == $role->role_id) {
                    $user->role_name = $role->name;
                }
            }
        }
        $school_data = DB::table('schools')->where('deleted_at', null)->whereNotIn('school_id', [1])->get();
        foreach ($users_data as $user) {
            foreach ($school_data as $school) { 
                if ($user->school_id == $school->school_id) {
                    $user->school_name = $school->name;
                }
            }
        }
        return view('users.index', [
            'users_data' => $users_data,
            'roles_data' => $roles_data,
            'school_data' => $school_data,
            'endPoint'=>'super-admin/users',
            'formAction' => route('users.store'),
            // 'formActionUpdate' => route('school_users.update', ['id' => '']),
            'formActionDelete' => 'users/delete',
        ]);
    }
    public function show($id){
        $user = User::with(['school', 'role'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'school' => $user->school?->name,
                'role' => $user->role?->name,
                'created_at' => $user->created_at->format('d M Y H:i'),
            ]
        ]);
    }

    public function store(Request $request){
        // $authRole = Auth::user()->role->name;

        // $allowedRoles = [
        //     'super_admin'  => ['super_admin', 'school_admin', 'teacher', 'student'],
        //     'school_admin' => ['school_admin', 'teacher', 'student'],
        // ]; 

        // if (!isset($allowedRoles[$authRole])) {
        //     abort(403, 'You do not have permission to create users.');
        // }

        
        // $allowedRoleIds = Roles::whereIn('name', $allowedRoles[$authRole])
        //     ->pluck('role_id')
        //     ->toArray();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // 'role_id' => ['required', Rule::in($allowedRoleIds)],
            // 'role_id' => 'required|integer|exists:roles,role_id',
            // 'school_id' => 'required|integer|exists:schools,school_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        }else{
            try {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role_id' => $request->role_id,
                    'school_id' => $request->school_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                Alert::success('Success', 'User created successfully');
                return redirect()->route('users.index');
            } catch (\Throwable $th) {
                Alert::error('Error', 'Failed to create user: ' . $th->getMessage());
                return redirect()->route('users.index');
            }
        }
    }

    public function edit($id){
        $user = User::with(['school', 'role'])->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }   
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'update_name' => 'required|string|max:255',
            'update_email' => 'required|string|email|max:255',
            // 'update_role_id' => 'required|integer|exists:roles,role_id',
            // 'update_school_id' => 'required|integer|exists:schools,school_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        }else{
            try {
                $user = User::findOrFail($id);
                $user->name = $request->update_name;
                $user->email = $request->update_email;
                $user->role_id = $request->update_role_id;
                $user->school_id = $request->update_school_id;
                $user->updated_at = now();
                $user->save();

                Alert::success('Success', 'User updated successfully');
                return redirect()->route('users.index');
            } catch (\Throwable $th) {
                Alert::error('Error', 'Failed to update user: ' . $th->getMessage());
                return redirect()->route('users.index');
            }
        }
    }

    public function destroy($id){
        try {
            $user = User::findOrFail($id);
            $user->delete();

            Alert::success('Success', 'User deleted successfully');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }   
}
