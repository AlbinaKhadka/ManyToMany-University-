<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Models\Students; 
use App\Models\Courses; 
use App\Models\Student; 




Route::get('/', function () {
    $students = Student::with('courses')->paginate(10);
    return view('Dashboard',compact('students'));
});
// Route::get('/studenttable', function () {
//     return view('studenttable');
// });
// Route::post('/add-student', [StudentController::class, 'store'])->name('add.student');
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');//displaying a dashboard
Route::get('/dashboard', [StudentController::class, 'studentList']);


Route::post('/add-students', [StudentController::class, 'addStudent']);
Route::get('create-student',function(){
    $student = Student::first();
    $student->courses()->attach([1,2]);
});

Route::get('/get-students/{id}', [StudentController::class, 'getStudent']);


Route::put('/edit-student/{id}', [StudentController::class, 'editStudent'])->name('editStudent');

// Route::post('/students/{student}/edit', [StudentsController::class, 'editStudent']); 
Route::delete('/delete-students/{id}', [StudentController::class, 'deleteStudent'])->name(' deleteStudent');

Route::get('/studentList', [StudentController::class, 'studentList']);
Route::get('/students/modal', [StudentsController::class, 'showStudents']);



Route::get('/student_trash', [StudentController::class, 'trash'])->name('students.trash');
Route::delete('/students/delete/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
Route::get('/students/restore/{id}', [StudentController::class, 'restore'])->name(' restoreStudent');
Route::get('/dashboard', [StudentController::class, 'showDashboard']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/students', [StudentController::class, 'studentList']);