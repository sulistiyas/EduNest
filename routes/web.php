<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RolesController;
use App\Http\Controllers\School\UserController;

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
            Route::get('class',[App\Http\Controllers\School\ClassController::class, 'index'])->name('class.index');
            Route::get('class/show/{id}',[App\Http\Controllers\School\ClassController::class, 'show'])->name('class.show');
            Route::post('class/store',[App\Http\Controllers\School\ClassController::class, 'store'])->name('class.store');
            Route::get('class/edit/{id}',[App\Http\Controllers\School\ClassController::class, 'edit'])->name('class.edit');
            Route::post('class/update/{id}',[App\Http\Controllers\School\ClassController::class, 'update'])->name('class.update');
            Route::delete('class/delete/{id}',[App\Http\Controllers\School\ClassController::class, 'destroy'])->name('class.destroy');
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


