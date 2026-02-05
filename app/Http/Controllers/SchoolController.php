<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = DB::table('schools')->whereNull('deleted_at')->get();
        return view('school.index', compact('schools'));
    }
    public function create()
    {
        // return view('school.create');
    }

    public function show($id)
    {
        $school = School::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $school
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        }else {
            try {
                School::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                Alert::success('Success', 'School created successfully');
                return redirect()->route('school.index');
            } catch (\Throwable $th) {
                Alert::error('Error', 'Failed to create school: ' . $th->getMessage());
                return redirect()->route('school.index');
            }
        }
    }
    public function edit($id)
    {
        $school = School::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $school
        ]);
        // return view('school.edit');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'update_name' => 'required|string|max:255',
            'update_address' => 'nullable|string|max:255',
            'update_email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        }else {
            try {
                $school = School::findOrFail($id);
                $school->name = $request->update_name;
                $school->slug = Str::slug($request->update_name);
                $school->address = $request->update_address;
                $school->phone = $request->update_phone;
                $school->email = $request->update_email;
                $school->updated_at = now();
                $school->save();

                Alert::success('Success', 'School updated successfully');
                return redirect()->route('school.index');
            } catch (\Throwable $th) {
                Alert::error('Error', 'Failed to update school: ' . $th->getMessage());
                return redirect()->route('school.index');
            }
        }
    }
    public function destroy($id)
    {
        try {
            $school = School::findOrFail($id);
            $school->delete();

            Alert::success('Success', 'School deleted successfully');
            return redirect()->route('school.index');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Failed to delete school: ' . $th->getMessage());
            return redirect()->route('school.index');
        }
    }

    
}
