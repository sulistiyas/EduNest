<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;

Route::get('dash', function () {
    return view('Dash');
})->name('dash');

Route::get('school',[SchoolController::class, 'index'])->name('school.index');
Route::get('school/show/{id}',[SchoolController::class, 'show'])->name('school.show');
Route::get('school/create',[SchoolController::class, 'create'])->name('school.create');
Route::post('school/store',[SchoolController::class, 'store'])->name('school.store');
Route::get('school/edit',[SchoolController::class, 'edit'])->name('school.edit');
Route::put('school/update/{id}',[SchoolController::class, 'update'])->name('school.update');
Route::delete('school/delete/{id}',[SchoolController::class, 'destroy'])->name('school.destroy');
