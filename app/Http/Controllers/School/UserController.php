<?php

namespace App\Http\Controllers\School;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $school_id = Auth::user()->school_id;
        $users_data = DB::table('users')->where('deleted_at', null)->where('school_id', $school_id)->get();
        $roles_data = DB::table('roles')->where('deleted_at', null)->whereNotIn('role_id', [1])->get();
        foreach ($users_data as $user) {
            foreach ($roles_data as $role) {
                if ($user->role_id == $role->role_id) {
                    $user->role_name = $role->name;
                }
            }
        }
        $school_data = DB::table('schools')->where('deleted_at', null)->get();
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
            'formAction' => route('school_users.store'),
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // 'role_id' => 'required|integer|exists:roles,role_id',
            // 'school_id' => 'required|integer|exists:schools,school_id',
        ]);

        if($validator->fails()){
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
                    'password' => $request->password,
                    'role_id' => $request->role_id,
                    'school_id' => Auth::user()->school_id,
                ]);

                Alert::success('Success', 'User created successfully');
                return redirect()->route('school_users.index');
            } catch (\Exception $e) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Error: ' . $e->getMessage()
                ]);
                Alert::error('Error', 'Failed to create user: ' . $e->getMessage());
                return redirect()->route('school_users.index');
            }
        }
    }
}
