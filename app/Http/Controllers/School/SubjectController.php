<?php

namespace App\Http\Controllers\School;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = DB::table('subjects')->where('school_id', Auth::user()->school_id)->whereNull('deleted_at')->get();
        return view('subject.index', compact('subjects'));
    }

    public function show($id)
    {
        $subject = Subject::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $subject
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_name' => 'required|string|max:255',
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
                Subject::create([
                    'subject_name' => $request->subject_name,
                    'school_id' => Auth::user()->school_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                // return response()->json([
                //     'status' => true,
                //     'message' => 'Subject created successfully'
                // ]);
                Alert::success('Success', 'Subject created successfully');
                return redirect()->route('subject.index');
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error creating subject: ' . $e->getMessage()
                ]);
                Alert::error('Error', 'Error creating subject: ' . $e->getMessage());
                return redirect()->route('subject.index');
            }
        }
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $subject
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'update_subject_name' => 'required|string|max:255',
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
                $subject = Subject::findOrFail($id);
                $subject->subject_name = $request->update_subject_name;
                $subject->updated_at = now();
                $subject->save();

                // return response()->json([
                //     'status' => true,
                //     'message' => 'Subject updated successfully'
                // ]);
                Alert::success('Success', 'Subject updated successfully');
                return redirect()->route('subject.index');
            } catch (\Exception $e) {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Error updating subject: ' . $e->getMessage()
                // ]);
                Alert::error('Error', 'Error updating subject: ' . $e->getMessage());
                return redirect()->route('subject.index');
            }
        }
    }

    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->deleted_at = now();
            $subject->save();

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Subject deleted successfully'
            // ]);
            Alert::success('Success', 'Subject deleted successfully');
            return redirect()->route('subject.index');
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Error deleting subject: ' . $e->getMessage()
            // ]);
            Alert::error('Error', 'Error deleting subject: ' . $e->getMessage());
            return redirect()->route('subject.index');
        }
    }

    public function assignTeachersForm()
    {
        
        $assignedTeachers = DB::table('class_subjects')
            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
            ->join('users', 'class_subjects.teacher_id', '=', 'users.id')
            ->where('class_subjects.school_id', Auth::user()->school_id)
            ->where('users.role_id', '3')
            ->whereNull('class_subjects.deleted_at')
            ->select(
                'class_subjects.*',
                'subjects.subject_name',
                'users.name as teacher_name',
                'classes.name as class_name'
            )
            ->get();
        $grouped = $assignedTeachers
            ->groupBy(function ($item) {
                return $item->teacher_id . '-' . $item->class_id;
            })
            ->map(function ($group) {
                return [
                    'teacher_id'   => $group->first()->teacher_id,
                    'class_id'     => $group->first()->class_id,
                    'teacher_name' => $group->first()->teacher_name,
                    'class_name'   => $group->first()->class_name,
                    'subjects'     => $group->pluck('subject_name')->implode(', '),
                    'subject_ids'  => $group->pluck('subject_id')->implode(',')
                ];
            });


        $subjects = Subject::where('school_id', Auth::user()->school_id)->whereNull('deleted_at')->get();
        $teachers = DB::table('users')
            ->where('school_id', Auth::user()->school_id)
            ->where('role_id', '3') // Assuming role_id '3' corresponds to teachers
            ->whereNull('deleted_at')
            ->get();
        $classes = DB::table('classes')
            ->where('school_id', Auth::user()->school_id)
            ->whereNull('deleted_at')
            ->get();
        return view('subject.assign_teachers', compact('grouped','assignedTeachers', 'subjects', 'teachers', 'classes'));
    }

    public function assignTeachers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,class_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => false,
                'message'   => 'Validation Error',
                'errors'    => $validator->errors()
            ]);
        } else {
            try {
                foreach ($request->subject_id as $subjectId) {
                    DB::table('class_subjects')->insert([
                        'subject_id' => $subjectId,
                        'teacher_id' => $request->teacher_id,
                        'class_id'   => $request->class_id,
                        'school_id'  => Auth::user()->school_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                // return response()->json([
                //     'status' => true,
                //     'message' => 'Teacher assigned to subject successfully'
                // ]);
                Alert::success('Success', 'Teacher assigned to subject successfully');
                return redirect()->route('subject.assignTeachersForm');
            } catch (\Exception $e) {
                return response()->json([
                'status' => false,
                'message' => 'Error assigning teacher: ' . $e->getMessage()
            ]);
                // Alert::error('Error', 'Error assigning teacher: ' . $e->getMessage());
                // return redirect()->route('subject.assign_teachers_form');
            }
        }
    }

    public function assignTeachersUpdate(Request $request){

        DB::table('class_subjects')
        ->where('teacher_id', $request->teacher_id)
        ->where('class_id', $request->class_id)
        ->delete();

        $data = [];
        try {
            foreach ($request->subject_id as $subjectId) {
            $data[] = [
                'teacher_id' => $request->teacher_id,
                'class_id'   => $request->class_id,
                'subject_id' => $subjectId,
                'school_id'  => Auth::user()->school_id,
                'created_at' => now(),
                'updated_at' => now(),
                ];
            }

            DB::table('class_subjects')->insert($data);

            return response()->json([
                'status' => true,
                'message' => 'Assignment Updated'
            ]);
            Alert::success('Success', 'Teacher assignment updated successfully');
            return redirect()->route('subject.assignTeachersForm');
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating teacher assignment: ' . $e->getMessage()
            ]);
        }
    }

    public function assignTeachersDelete(Request $request){
        try {
            DB::table('class_subjects')
            ->where('teacher_id', $request->teacher_id)
            ->where('class_id', $request->class_id)
            ->delete();

            // return response()->json([
            //     'status' => true,
            //     'message' => 'Assignment Deleted'
            // ]);
            Alert::success('Success', 'Teacher assignment deleted successfully');
            return redirect()->route('subject.assignTeachersForm');
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting teacher assignment: ' . $e->getMessage()
            ]);
        }
    }
}
