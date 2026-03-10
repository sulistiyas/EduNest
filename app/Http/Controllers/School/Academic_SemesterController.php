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
            'create_academic_year_name' => 'required|string',
            'create_start_date' => 'required|date',
            'create_end_date' => 'required|date|after:create_start_date',
            'create_is_active' => 'required|boolean',
        ]);

        if($validate->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validate->errors()
            ]);
        }else{
            try {
                $yearName = $request->create_academic_year_name;
                $startDate = $request->create_start_date;
                $endDate = $request->create_end_date;
                $getAcademicYearName = Academic_Years::where('year_name', $request->create_academic_year_name)->first();
                if($getAcademicYearName) {
                    // return response()->json([
                    //     'status' => false,
                    //     'message' => 'Academic year name already exists'
                    // ]);
                    Alert::error('Error', 'Academic year name already exists');
                    return redirect()->route('academic_year.index');
                    
                }else{

                    // if($request->create_is_active) {
                    //     // Deactivate all other academic years
                    //     Academic_Years::where('is_active', true)->update(['is_active' => false]);
                    // }
                    $years = explode('/', $yearName);

                    $startYear = $years[0];
                    $endYear = $years[1];

                    if( date('Y', strtotime($startDate)) < $startYear || date('Y', strtotime($endDate)) > $endYear) {
                        // return response()->json([
                        //     'status' => false,
                        //     'message' => 'Start and end dates must match the academic year format'
                        // ]);
                        Alert::error('Error', 'Start and end dates must match the academic year format');
                        return redirect()->route('academic_year.index');
                    }else{
                        if($startDate > $endDate) {
                            // return response()->json([
                            //     'status' => false,
                            //     'message' => 'Start date must be before end date'
                            // ]);
                            Alert::error('Error', 'Start date must be before end date');
                            return redirect()->route('academic_year.index');
                        }else{
                            if($endDate < $startDate){
                                // return response()->json([
                                //     'status' => false,
                                //     'message' => 'End date must be after start date'
                                // ]);
                                Alert::error('Error', 'End date must be after start date');
                                return redirect()->route('academic_year.index');
                            }else{
                                Academic_Years::create([
                                    'year_name' => $request->create_academic_year_name,
                                    'start_date' => $request->create_start_date,
                                    'end_date' => $request->create_end_date,
                                    'is_active' => $request->create_is_active,
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
                        }
                    }
                    
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
            'update_end_date' => 'required|date',
            'update_is_active' => 'required',
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
                $yearName = $request->update_academic_year_name;
                $startDate = $request->update_start_date;
                $endDate = $request->update_end_date;
                
                $years = explode('/', $yearName);
                $startYear = $years[0];
                $endYear = $years[1];

                if( date('Y', strtotime($startDate)) < $startYear || date('Y', strtotime($endDate)) > $endYear) {
                        // return response()->json([
                        //     'status' => false,
                        //     'message' => 'Start and end dates must match the academic year format'
                        // ]);
                        Alert::error('Error', 'Start and end dates must match the academic year format');
                        return redirect()->route('academic_year.index');
                    }else{
                        if($startDate > $endDate) {
                            // return response()->json([
                            //     'status' => false,
                            //     'message' => 'Start date must be before end date'
                            // ]);
                            Alert::error('Error', 'Start date must be before end date');
                            return redirect()->route('academic_year.index');
                        }else{
                            if($endDate < $startDate){
                                // return response()->json([
                                //     'status' => false,
                                //     'message' => 'End date must be after start date'
                                // ]);
                                Alert::error('Error', 'End date must be after start date');
                                return redirect()->route('academic_year.index');
                            }else{
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
                            }
                        }
                    }
                
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
    public function index_semester()
    {
        $getActiveAcademicYear = Academic_Years::where('is_active', true)->first();
        $activeAcademicYear = $getActiveAcademicYear ? $getActiveAcademicYear : null;
        $semesters = DB::table('semesters')
                        ->join('academic_years', 'semesters.academic_year_id', '=', 'academic_years.academic_year_id')
                        ->select('semesters.*', 'academic_years.year_name')
                        // ->where('semesters.academic_year_id', $activeAcademicYear ? $activeAcademicYear->academic_year_id : null)
                        ->whereNull('semesters.deleted_at')
                        ->orderBy('academic_years.is_active', 'desc')
                        ->get();
        if($activeAcademicYear) {
            // Alert::info('Active Academic Year', 'The active academic year is : ' . $activeAcademicYear->year_name);
            return view('academic_setup.index_semesters', compact('semesters', 'activeAcademicYear'));
        }else{
            Alert::warning('No Active Academic Year', 'There is currently no active academic year. Please set an active academic year to manage semesters.');
            return view('academic_setup.index_semesters', compact('semesters', 'activeAcademicYear'));
        }
        
    }

    public function setActiveSemester($id)
    {
        try {
            $semester = DB::table('semesters')->where('semester_id', $id)->first();
            $getAcademicYear = DB::table('academic_years')->where('academic_year_id', $semester->academic_year_id)->first();
            if(!$getAcademicYear->is_active) {
                Alert::error('Error', 'Cannot activate semester. The associated academic year is not active.');
                return redirect()->route('semester.index');
            }else{
                if($semester) {
                    // Deactivate all other semesters
                    DB::table('semesters')->where('is_active', true)->update(['is_active' => false]);
                    // Activate the selected semester
                    DB::table('semesters')->where('semester_id', $id)->update(['is_active' => true]);
                    Alert::success('Success', 'Semester activated successfully');
                    return redirect()->route('semester.index');
                }else{
                    Alert::error('Error', 'Semester not found');
                    return redirect()->route('semester.index');
                }
            }
            
        } catch (\Exception $e) {
            Alert::error('Error', 'Error activating semester: ' . $e->getMessage());
            return redirect()->route('semester.index');
        }
    }

    public function setDeactiveSemester($id)
    {
        try {
            $semester = DB::table('semesters')->where('semester_id', $id)->first();
            if($semester) {
                // Deactivate the selected semester
                DB::table('semesters')->where('semester_id', $id)->update(['is_active' => false]);
                Alert::success('Success', 'Semester deactivated successfully');
                return redirect()->route('semester.index');
            }else{
                Alert::error('Error', 'Semester not found');
                return redirect()->route('semester.index');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Error deactivating semester: ' . $e->getMessage());
            return redirect()->route('semester.index');
        }
    }

    
}
