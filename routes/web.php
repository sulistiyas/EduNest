<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RolesController;
use App\Http\Controllers\School\ClassController;
use App\Http\Controllers\School\EnrollmentController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Teacher\ClassController as TeacherClassController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login_form'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('dash', function () {
        return view('Dash');
    })->name('dash');

    Route::prefix('super-admin')
        ->middleware('role:super_admin')
        ->group(function () {
            // School Routes
            Route::get('school',[SchoolController::class, 'index'])->name('school.index');
            Route::get('school/show/{id}',[SchoolController::class, 'show'])->name('school.show');
            Route::get('school/create',[SchoolController::class, 'create'])->name('school.create');
            Route::post('school/store',[SchoolController::class, 'store'])->name('school.store');
            Route::get('school/edit/{id}',[SchoolController::class, 'edit'])->name('school.edit');
            Route::post('school/update/{id}',[SchoolController::class, 'update'])->name('school.update');
            Route::delete('school/delete/{id}',[SchoolController::class, 'destroy'])->name('school.destroy');

            // Roles and Permissions Routes
            Route::get('roles',[RolesController::class, 'index'])->name('roles.index');
            Route::post('roles/store',[RolesController::class, 'store'])->name('roles.store');
            Route::get('roles/edit/{id}',[RolesController::class, 'edit'])->name('roles.edit');
            Route::post('roles/update/{id}',[RolesController::class, 'update'])->name('roles.update');
            Route::delete('roles/delete/{id}',[RolesController::class, 'destroy'])->name('roles.destroy');
            // users Route
            Route::get('users',[UsersController::class, 'index'])->name('users.index');
            Route::get('users/show/{id}',[UsersController::class, 'show'])->name('users.show');
            Route::get('users/create',[UsersController::class, 'create'])->name('users.create');
            Route::post('users/store',[UsersController::class, 'store'])->name('users.store');
            Route::get('users/edit/{id}',[UsersController::class, 'edit'])->name('users.edit');
            // Route::post('users/update/{id}',[UsersController::class, 'update'])->name('users.update');
            Route::put('users/update/{id}',[UsersController::class, 'update'])->name('users.update');
            Route::delete('users/delete/{id}',[UsersController::class, 'destroy'])->name('users.destroy');

            // Assign Role to User
            Route::post('roles/assign-role',[RolesController::class, 'AssignRoleToUser'])->name('roles.assignRoleToUser');
    });
    Route::prefix('school-admin')
        ->middleware('role:school_admin')
        ->group(function () {
            // School Users Routes
            Route::get('school_users',[UserController::class, 'index'])->name('school_users.index');
            Route::post('school_users/store',[UserController::class, 'store'])->name('school_users.store');
            Route::get('school_users/show/{id}',[UserController::class, 'show'])->name('school_users.show');
            Route::get('school_users/edit/{id}',[UserController::class, 'edit'])->name('school_users.edit');
            Route::put('school_users/update/{id}',[UserController::class, 'update'])->name('school_users.update');
            Route::delete('school_users/delete/{id}',[UserController::class, 'destroy'])->name('school_users.destroy');

            // Class Routes
            Route::get('class',[ClassController::class, 'index'])->name('class.index');
            Route::get('class/show/{id}',[ClassController::class, 'show'])->name('class.show');
            Route::post('class/store',[ClassController::class, 'store'])->name('class.store');
            Route::get('class/edit/{id}',[ClassController::class, 'edit'])->name('class.edit');
            Route::post('class/update/{id}',[ClassController::class, 'update'])->name('class.update');
            Route::delete('class/delete/{id}',[ClassController::class, 'destroy'])->name('class.destroy');

            // Subject Routes
            Route::get('subject',[SubjectController::class, 'index'])->name('subject.index');
            Route::get('subject/show/{id}',[SubjectController::class, 'show'])->name('subject.show');
            Route::post('subject/store',[SubjectController::class, 'store'])->name('subject.store');
            Route::get('subject/edit/{id}',[SubjectController::class, 'edit'])->name('subject.edit');
            Route::post('subject/update/{id}',[SubjectController::class, 'update'])->name('subject.update');
            Route::delete('subject/delete/{id}',[SubjectController::class, 'destroy'])->name('subject.destroy');
            
            Route::get('subject/assign-teachers',[SubjectController::class, 'assignTeachersForm'])->name('subject.assignTeachersForm');
            Route::post('subject/assign-teachers/store',[SubjectController::class, 'assignTeachers'])->name('subject.assignTeachers');
            Route::post('subject/assign-teachers/update',[SubjectController::class, 'assignTeachersUpdate'])->name('subject.assignTeachersUpdate');
            Route::delete('subject/assign-teachers/delete',[SubjectController::class, 'assignTeachersDelete'])->name('subject.assignTeachersDelete');

            // Enrollment student
            Route::get('enrollment',[EnrollmentController::class, 'index'])->name('enrollment.index');
            Route::post('enrollment/store',[EnrollmentController::class, 'store'])->name('enrollment.store');
            Route::get('enrollment/show/{class_id}',[EnrollmentController::class, 'show'])->name('enrollment.show');
            Route::put('enrollment/update/{id}',[EnrollmentController::class, 'update'])->name('enrollment.update');
            Route::delete('enrollment/delete/{id}',[EnrollmentController::class, 'destroy'])->name('enrollment.destroy'); 
            // Get Student Available for Enrollment
            Route::get('enrollment/students/{class_id}', [EnrollmentController::class, 'getAvailableStudents'])->name('getAvailableStudents');

        });

    Route::prefix('teacher')
        ->middleware('role:teacher')
        ->group(function () {
            // Teacher Routes
            Route::get('/home', function () { return view('teacher.dash');})->name('teacher.dash');


            // Class Management
            Route::get('/classes', [TeacherClassController::class, 'index'])->name('teacher.classes.index');
            Route::get('/classes/{id}/students', [TeacherClassController::class, 'students']);
            Route::get('/classes/{id}/subjects', [TeacherClassController::class, 'subjects']);
            // Academic
            // Reporting
            // Account
        });


    // Route::middleware('role:admin')->group(function () {
    //     Route::get('/admin', fn () => 'Halaman Admin');
    // });

    // Route::middleware('role:guru')->group(function () {
    //     Route::get('/guru', fn () => 'Halaman Guru');
    // });

});

// Route::get('dash', function () {
//     return view('Dash');
// })->name('dash');


