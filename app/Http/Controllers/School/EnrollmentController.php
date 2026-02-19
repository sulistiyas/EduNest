<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function index()
    {
        $class_enrollments = DB::table('enrollments')
            ->join('users', 'enrollments.student_id', '=', 'users.id')
            ->join('classes', 'enrollments.class_id', '=', 'classes.class_id')
            ->select('enrollments.*', 'users.name as student_name', 'classes.name as class_name')
            ->where('users.role_id', '4')
            ->get();
        $class_data = DB::table('classes')
            ->where('school_id', Auth::user()->school_id)
            ->get();
        $student_data = DB::table('users')
            ->where('role_id', '4')
            ->get();
        return view('class.student_enrollment.index', compact('class_enrollments', 'class_data', 'student_data'));
    }

    public function store(Request $request)
    {
        // Code to create a new enrollment
    }

    public function show($id)
    {
        // Code to show a specific enrollment
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
