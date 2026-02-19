<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class EnrollmentController extends Controller
{
    public function index()
    {
        $class_enrollments = DB::table('enrollments')
            ->join('classes', 'enrollments.class_id', '=', 'classes.class_id')
            ->join('users', 'enrollments.student_id', '=', 'users.id')
            // ->where('enrollments.school_id', Auth::user()->school_id)
            ->select(
                'classes.class_id',
                'classes.name as class_name',
                DB::raw("STRING_AGG(users.name, ', ') as students")
            )
            ->groupBy('classes.class_id', 'classes.name')
            ->get();

        $class_data = DB::table('classes')
            ->where('school_id', Auth::user()->school_id)
            ->get();
        $student_data = DB::table('users')
            ->where('role_id', '4')
            ->get();
        return view('class.student_enrollment.index', compact('class_enrollments', 'class_data', 'student_data'));
    }

    public function getAvailableStudents($class_id)
    {
        $schoolId = Auth::user()->school_id;

        // Ambil student yang SUDAH terdaftar di class
        $assignedStudentIds = DB::table('enrollments')
            ->where('class_id', $class_id)
            ->pluck('student_id');

        // Ambil student yang BELUM terdaftar
        $students = DB::table('users')
            ->where('school_id', $schoolId)
            ->where('role_id', 4) // student
            ->whereNotIn('id', $assignedStudentIds)
            ->select('id', 'name')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $students
        ]);
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,class_id',
            'student_id' => 'required|exists:users,id',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors()->first()
            ], 400);
        } else {
            try {
                foreach ($request->student_id as $studentId) {
                    DB::table('enrollments')->insert([
                        'class_id' => $request->class_id,
                        'student_id' => $studentId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                Alert::success('Success', 'Student enrolled successfully');
                return redirect()->route('enrollment.index');
            } catch (\Exception $e) {
                    return response()->json([
                    'status' => false,
                    'message' => 'Error enrolling student: ' . $e->getMessage()
                ]);
            }
        }
        
    }

    public function show($id)
    {
        $enrollments = Enrollment::with('student')
        ->where('class_id', $id)
        ->get();

        if ($enrollments->isEmpty()) {
            return response()->json([
                'status' => false
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $enrollments
        ]);
    }


    public function update(Request $request, $id)
    {
        // Code to update an existing enrollment
    }

    public function destroy($id)
    {
        // Code to delete an enrollment
    }
}
