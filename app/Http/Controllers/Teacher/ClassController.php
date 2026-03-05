<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    public function index(){
        $classes = DB::table('class_subjects')
                        ->join('classes', 'classes.class_id', '=', 'class_subjects.class_id')
                        ->leftJoin('enrollments', 'enrollments.class_id', '=', 'classes.class_id')
                        ->whereNull('classes.deleted_at')
                        ->where('class_subjects.teacher_id', Auth::user()->id)
                        ->select(
                            'classes.class_id',
                            'classes.name as class_name',
                            DB::raw('COUNT(DISTINCT enrollments.student_id) as total_students'),
                            DB::raw('COUNT(DISTINCT class_subjects.subject_id) as total_subjects')
                        )
                        ->groupBy(
                            'classes.class_id',
                            'classes.name'
                        )
                        ->get();
        return view('teacher.classes.index', compact('classes'));
    }

    public function students($id)
    {
        $students = DB::table('enrollments')
            ->join('users', 'users.id', '=', 'enrollments.student_id')
            ->where('enrollments.class_id', $id)
            ->select('users.name')
            ->get();

        return response()->json($students);
    }

    public function subjects($id)
    {
        $subjects = DB::table('class_subjects')
            ->join('subjects', 'subjects.subject_id', '=', 'class_subjects.subject_id')
            ->where('class_subjects.class_id', $id)
            ->where('class_subjects.teacher_id', Auth::id())
            ->select('subjects.subject_name')
            ->get();

        return response()->json($subjects);
    }
}
