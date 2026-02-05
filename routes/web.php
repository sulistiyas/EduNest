<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\Auth\RolesController;

Route::get('dash', function () {
    return view('Dash');
})->name('dash');

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
Route::post('users/update/{id}',[UsersController::class, 'update'])->name('users.update');
Route::delete('users/delete/{id}',[UsersController::class, 'destroy'])->name('users.destroy');

// Assign Role to User
Route::post('roles/assign-role',[RolesController::class, 'AssignRoleToUser'])->name('roles.assignRoleToUser');
