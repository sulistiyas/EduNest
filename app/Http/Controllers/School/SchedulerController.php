<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SchedulerController extends Controller
{
    public function index()
    {
        $getActiveSemester = DB::table('semesters')->where('is_active', true)->first();
        $getActiveAcademicYear = DB::table('academic_years')->where('is_active', true)->first();
        if (!$getActiveSemester || !$getActiveAcademicYear) {
            Alert::error('Error', 'Active Academic Year or Semester not found. Please set them up first.');
            return redirect()->route('dash');
        }else{
            $schedules = DB::table('schedules')
                ->join('class_subjects','class_subjects.class_subject_id','=','schedules.class_subject_id')
                ->join('classes','classes.class_id','=','class_subjects.class_id')
                ->join('subjects','subjects.subject_id','=','class_subjects.subject_id')
                ->join('users','users.id','=','class_subjects.teacher_id')
                // ->where('classes.class_id',1)
                ->where('classes.school_id', Auth::user()->school_id)
                ->where('schedules.semester_id',$getActiveSemester->semester_id)
                ->select(
                    'subjects.subject_name',
                    'users.name as teacher',
                    'schedules.day_of_week',
                    'schedules.start_time',
                    'schedules.end_time'
                )
                ->orderBy('schedules.day_of_week','asc')
                ->get();
            $classSubjects = DB::table('class_subjects')
                ->join('classes','classes.class_id','=','class_subjects.class_id')
                ->join('subjects','subjects.subject_id','=','class_subjects.subject_id')
                ->join('users','users.id','=','class_subjects.teacher_id')
                ->select(
                    'class_subjects.class_subject_id',
                    'classes.name as class_name',
                    'subjects.subject_name',
                    'users.name as teacher_name'
                )
                ->get();

            $semesters = DB::table('semesters')->where('academic_year_id', $getActiveAcademicYear->academic_year_id)->orderBy('semester_name','asc')->get();
            return view('schedule.index', compact('schedules', 'classSubjects', 'semesters', 'getActiveAcademicYear', 'getActiveSemester'));
        }
        
    }

    public function show($id){
        // 
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_subject_id' => 'required',
            'semester_id' => 'required',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Please fill in all required fields.');
            return back()->withErrors($validator)->withInput();
        }

        if($request->start_time >= $request->end_time){
            Alert::error('Error','End time must be greater than start time');
            return back();
        }

        $classSubject = DB::table('class_subjects')
            ->where('class_subject_id',$request->class_subject_id)
            ->first();

        if(!$classSubject){
            Alert::error('Error','Class subject not found');
            return back();
        }

        // Class conflict
        $classConflict = DB::table('schedules')
            ->join('class_subjects','class_subjects.class_subject_id','=','schedules.class_subject_id')
            ->where('class_subjects.class_id',$classSubject->class_id)
            ->where('schedules.day_of_week',$request->day_of_week)
            ->where(function($q) use ($request){
                $q->where('start_time','<',$request->end_time)
                ->where('end_time','>',$request->start_time);
            })
            ->exists();

        if($classConflict){
            Alert::error('Error','Class already has schedule at this time');
            return back();
        }

        // Teacher conflict
        $teacherConflict = DB::table('schedules')
            ->join('class_subjects','class_subjects.class_subject_id','=','schedules.class_subject_id')
            ->where('class_subjects.teacher_id',$classSubject->teacher_id)
            ->where('schedules.day_of_week',$request->day_of_week)
            ->where(function($q) use ($request){
                $q->where('start_time','<',$request->end_time)
                ->where('end_time','>',$request->start_time);
            })
            ->exists();

        if($teacherConflict){
            Alert::error('Error','Teacher already has schedule at this time');
            return back();
        }

        // Room conflict
        $roomConflict = DB::table('schedules')
            ->where('room',$request->room)
            ->where('day_of_week',$request->day_of_week)
            ->where(function($q) use ($request){
                $q->where('start_time','<',$request->end_time)
                ->where('end_time','>',$request->start_time);
            })
            ->exists();

        if($roomConflict){
            Alert::error('Error','Room already used at this time');
            return back();
        }

        try {
            DB::table('schedules')->insert([
                'class_subject_id' => $request->class_subject_id,
                'semester_id' => $request->semester_id,
                'day_of_week' => $request->day_of_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'room' => $request->room,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        // return response()->json([
            //     'status' => true,
            //     'message' => 'Teacher assigned to subject successfully'
            // ]);
            Alert::success('Success', 'Schedule created successfully');
            return redirect()->route('schedule.index');
        } catch (\Exception $ex) {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Error creating schedule: ' . $ex->getMessage()
            // ]);

            Alert::error('Error', 'Error creating schedule: ' . $ex->getMessage());
            return redirect()->route('schedule.index');
        }
    }

    public function update(Request $request, $id){
        // 
    }

    public function destroy($id){
        // 
    }
}
