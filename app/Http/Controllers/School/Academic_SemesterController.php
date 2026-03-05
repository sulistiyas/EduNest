<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Academic_Years;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class Academic_SemesterController extends Controller
{
    // Academic Year
    public function index_academic_year()
    {
        $academicYears = DB::table('academic_years')->whereNull('deleted_at')->orderBy('is_active', 'desc')->get();
        return view('academic_setup.index_academic_years', compact('academicYears'));
    }

    public function store_academic_year(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'year_name' => 'required|string|unique:academic_years,year_name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
        ]);

        if($validate->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validate->errors()
            ]);
        }else{
            try {
                $getAcademicYearName = Academic_Years::where('year_name', $request->year_name)->first();
                if($getAcademicYearName) {
                    // return response()->json([
                    //     'status' => false,
                    //     'message' => 'Academic year name already exists'
                    // ]);
                    Alert::error('Error', 'Academic year name already exists');
                    return redirect()->route('academic_year.index');
                }else{
                    Academic_Years::create([
                        'year_name' => $request->year_name,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'is_active' => $request->is_active,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    // return response()->json([
                    //     'status' => true,
                    //     'message' => 'Academic year created successfully'
                    // ]);
                    Alert::success('Success', 'Academic year created successfully');
                    return redirect()->route('academic_year.index');
                }
            } catch (\Exception $e) {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Error creating academic year: ' . $e->getMessage()
                // ]);
                Alert::error('Error', 'Error creating academic year: ' . $e->getMessage());
                return redirect()->route('academic_year.index');
            }
        }
    }

    public function show_academic_year($id)
    {
        $academicYear = Academic_Years::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $academicYear
        ]); 
    }

    public function edit_academic_year($id)
    {
        $academicYear = Academic_Years::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $academicYear
        ]); 
    }

    public function update_academic_year(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'update_academic_year_name' => 'required|string',
            'update_start_date' => 'required|date',
            'update_end_date' => 'required|date|after:update_start_date',
            'update_is_active' => 'required|boolean',
        ]);

        if($validate->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validate->errors()
            ]);
        }else{
            try {
                $academicYear = Academic_Years::findOrFail($id);
                $academicYear->update([
                    'year_name' => $request->update_academic_year_name,
                    'start_date' => $request->update_start_date,
                    'end_date' => $request->update_end_date,
                    'is_active' => $request->update_is_active,
                    'updated_at' => now(),
                ]);
                // return response()->json([
                //     'status' => true,
                //     'message' => 'Academic year updated successfully'
                // ]);
                Alert::success('Success', 'Academic year updated successfully');
                return redirect()->route('academic_year.index');
            } catch (\Exception $e) {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Error updating academic year: ' . $e->getMessage()
                // ]);
                Alert::error('Error', 'Error updating academic year: ' . $e->getMessage());
                return redirect()->route('academic_year.index');
            }
        }
    }

    public function destroy_academic_year($id)
    {
        try {
            $academicYear = Academic_Years::findOrFail($id);
            if($academicYear->is_active) {
                Alert::error('Error', 'Cannot delete an active academic year. Please deactivate it first.');
                return redirect()->route('academic_year.index');
            }else {
                $academicYear->delete();
            }
            Alert::success('Success', 'Academic year deleted successfully');
            return redirect()->route('academic_year.index');
        } catch (\Exception $ex) {
            Alert::error('Error', 'Failed to delete academic year: ' . $ex->getMessage());
            return redirect()->route('academic_year.index');
        }
    }

    

    // Semesters
    public function index_semesters()
    {
        $semesters = DB::table('semesters')
                        ->join('academic_years', 'semesters.academic_year_id', '=', 'academic_years.id')
                        ->whereNull('semesters.deleted_at')->get();
        return view('academic_setup.index_semesters', compact('semesters'));
    }

    
}
