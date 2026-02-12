<?php

namespace App\Http\Controllers\School;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ClassController extends Controller
{
    public function index()
    {
        $classes = DB::table('classes')->where('school_id', Auth::user()->school_id)->whereNull('deleted_at')->get();
        return view('class.index', compact('classes'));
    }

    public function show($id)
    {
        $class = Classes::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $class
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                Classes::create([
                    'name' => $request->name,
                    'school_id' => Auth::user()->school_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // return response()->json([
                //     'status' => true,
                //     'message' => 'Class created successfully'
                // ]);
                Alert::success('Success', 'Class created successfully');
                return redirect()->route('class.index');
            } catch (\Exception $e) {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Error creating class: ' . $e->getMessage()
                // ]);
                Alert::error('Error', 'Error creating class: ' . $e->getMessage());
                return redirect()->route('class.index');
            }
        }
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $class
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'update_name' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                $class = Classes::findOrFail($id);
                $class->name = $request->update_name;
                $class->updated_at = now();
                $class->save();

                // return response()->json([
                //     'status' => true,
                //     'message' => 'Class updated successfully'
                // ]);
                Alert::success('Success', 'Class updated successfully');
                return redirect()->route('class.index');
            } catch (\Exception $e) {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Error updating class: ' . $e->getMessage()
                // ]);
                Alert::error('Error', 'Error updating class: ' . $e->getMessage());
                return redirect()->route('class.index');
            }
        }
    }  

    public function destroy($id)
    {
        try {
            $class = Classes::findOrFail($id);
            $class->delete();

            Alert::success('Success', 'Class deleted successfully');
            return redirect()->route('class.index');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Failed to delete class: ' . $th->getMessage());
            return redirect()->route('class.index');
        }
    }
}
