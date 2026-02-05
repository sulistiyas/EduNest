<?php

namespace App\Http\Controllers\Auth;

use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RolesController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->whereNull('deleted_at')->get();
        return view('role.index_role', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('roles')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Alert::success('Success', 'Role created successfully.');
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Roles::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $role
        ]);
        // return view('school.edit');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'update_name' => 'required|string|max:255|unique:roles,name,'.$id.',role_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('roles')->where('role_id', $id)->update([
            'name' => $request->update_name,
            'updated_at' => now(),
        ]);
        Alert::success('Success', 'Role updated successfully.');
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('roles')->where('role_id', $id)->delete();
        Alert::success('Success', 'Role deleted successfully.');
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    public function AssignRoleToUser(Request $request)
    {
        //
    }
}
