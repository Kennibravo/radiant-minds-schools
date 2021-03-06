<?php

use App\Http\Controllers\AcademicSessionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\PDController;
use App\Http\Controllers\PDTypesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TermController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    //Teacher routes
    Route::get('/create/teacher', [TeacherController::class, 'create']);
    Route::get('/view/teacher/{slug}', [TeacherController::class, 'show']);
    Route::get('/edit/teacher/{slug}', [TeacherController::class, 'edit']);
    Route::post('/store/teacher', [TeacherController::class, 'store']);
    Route::patch('/update/teacher/{slug}', [TeacherController::class, 'update']);
    Route::patch('/suspend/teacher/{id}', [TeacherController::class, 'suspend']);
    Route::patch('/activate/teacher/{id}', [TeacherController::class, 'activate']);
    Route::patch('/deactivate/teacher/{id}', [TeacherController::class, 'deactivate']);
    Route::patch('/restore/teacher/{id}', [TeacherController::class, 'restore']);
    Route::delete('/delete/teacher/{id}', [TeacherController::class, 'destroy']);
    Route::delete('/forceDelete/teacher/{id}', [TeacherController::class, 'forceDelete']);

    //Student Routes
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('create/student', [StudentController::class, 'create']);
    /**
     * {student} stands for admission number 
     * so wherever you see it in the routes 
     * that's what it means. I don't know what
     * I was thinking when i decided to name it like that
     * but I am too lazy to change it now.
     */
    Route::get('/studentSettings/{student}', [StudentController::class, 'showStudentSettingsView']);
    Route::get('view/student/{student}', [StudentController::class, 'show']);
    Route::get('/edit/student/{student}', [StudentController::class, 'edit']);
    Route::get('/student-subjects/{student}', [StudentController::class, 'getSubjects']);
    Route::get('/results/sessional/{student}/{academicSessionId}', [StudentController::class, 'getSessionalResults']);
    Route::get('/results/term/{student}/{termId}/{academicSessionId}', [StudentController::class, 'getTermResults']);
    Route::post('/store/image/{id}', [StudentController::class, 'uploadImage']);
    Route::post('/store/student', [StudentController::class, 'store']);
    Route::patch('/update/student/{id}', [StudentController::class, 'update']);
    Route::patch('/suspend/student/{id}', [StudentController::class, 'suspend']);
    Route::patch('/activate/student/{id}', [StudentController::class, 'activate']);
    Route::patch('/deactivate/student/{id}', [StudentController::class, 'deactivate']);
    Route::patch('/promote/student/{id}', [StudentController::class, 'promote']);
    Route::patch('/demote/student/{id}', [StudentController::class, 'demote']);
    Route::delete('/delete/student/{id}', [StudentController::class, 'destroy']);
    Route::delete('/forceDelete/student/{id}', [StudentController::class, 'forceDelete']);

    //Classroom ROutes
    Route::get('/classrooms', [ClassroomController::class, 'index']);
    Route::get('/edit/classroom/{id}', [ClassroomController::class, 'edit']);
    Route::get('/view/classroom/{id}', [ClassroomController::class, 'show']);
    Route::get('/set/classroom-subjects/{id}', [ClassroomController::class, 'setSubjects']);
    Route::post('/store/classroom', [ClassroomController::class, 'store']);
    Route::post('/update/classroom-subjects/{id}', [ClassroomController::class, 'updateSubjects']);
    Route::patch('/update/classroom/{id}', [ClassroomController::class, 'update']);
    Route::delete('/delete/classroom/{id}', [ClassroomController::class, 'destroy']);

    //Term routes
    Route::get('/terms', [TermController::class, 'index']);
    Route::get('/edit/term/{id}', [TermController::class, 'edit']);
    Route::post('/store/term', [TermController::class, 'store']);
    Route::patch('/update/term/{id}', [TermController::class, 'update']);
    Route::delete('/delete/term/{id}', [TermController::class, 'destroy']);

    // Subject routes
    Route::get('/subjects', [SubjectController::class, 'index']);
    Route::get('/edit/subject/{id}', [SubjectController::class, 'edit']);
    Route::post('/store/subject', [SubjectController::class, 'store']);
    Route::patch('/update/subject/{id}', [SubjectController::class, 'update']);
    Route::delete('/delete/subject/{id}', [SubjectController::class, 'destroy']);

    //AcademicSession routes
    Route::get('/academicSessions', [AcademicSessionController::class, 'index']);
    Route::get('/edit/academicSessions/{id}', [AcademicSessionController::class, 'edit']);
    Route::get('/update/setCurrentAcademicSession/{id}', [AcademicSessionController::class, 'setCurrentAcademicSession']);
    Route::post('/store/academicSessions', [AcademicSessionController::class, 'store']);
    Route::patch('/update/academicSessions/{id}', [AcademicSessionController::class, 'update']);
    Route::delete('/delete/academicSessions/{id}', [AcademicSessionController::class, 'destroy']);

    //Guardian Routes
    Route::get('/edit/guardian/{phone}', [GuardianController::class, 'edit']);
    Route::patch('/update/guardian/{phone}', [GuardianController::class, 'update']);

    //Result ROutes
    Route::get('/create/result/{student}', [ResultController::class, 'create']);
    Route::get('/performanceReport/{student}/{academicSessionId}/{termId}', [ResultController::class, 'showPerformanceReport']);
    Route::get('/edit/result/{id}', [ResultController::class, 'edit']);
    Route::post('/store/result/{student}', [ResultController::class, 'store']);
    Route::patch('/update/result/{id}', [ResultController::class, 'update']);
    Route::delete('/delete/result/{id}', [ResultController::class, 'destroy']);

    //Pychomotor Domain Routes
    Route::get('/create/pd/{id}/{termId}/{academicSessionId?}', [PDController::class, 'create']);
    Route::post('/store/pd/{id}/{termId}', [PDController::class, 'store']);

    //Pychomotor domain type routes
    Route::get('/pdTypes', [PDTypesController::class, 'index']);
    Route::get('/edit/pdType/{slug}', [PDTypesController::class, 'edit']);
    Route::post('/store/pdType', [PDTypesController::class, 'store']);
    Route::patch('/update/pdType/{id}', [PDTypesController::class, 'update']);
    Route::delete('/delete/pdType/{id}', [PDTypesController::class, 'destroy']);
});

require __DIR__ . '/auth.php';
