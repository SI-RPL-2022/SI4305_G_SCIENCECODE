<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontpageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomelessController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiscussionController;

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

Route::get('/', [FrontpageController::class, 'index'])->name('home');

Route::prefix('course')->name('course')->group(function () {
    Route::get('', [FrontpageController::class, 'course']);
    Route::get('/{id}', [FrontpageController::class, 'courseDetail']);
    Route::get('/{id}/material/{material_id}', [FrontpageController::class, 'courseContent']);

    Route::get('/enroll/{id}', [CourseController::class, 'enrollNow']);
    Route::get('/buy/{id}', [CourseController::class, 'buyCourse']);
});

Route::prefix('dashboard')->name('dashboard')->group(function () {
    Route::get('', [FrontpageController::class, 'dashboard']);

    Route::prefix('profile')->name('profile')->group(function() {
        Route::get('', [UserController::class, 'profile']);

        Route::post('change_bio', [UserController::class, 'changeBio']);
        Route::post('change_password', [UserController::class, 'changePassword']);
    });

    Route::prefix('enrollment')->name('enrollment')->group(function() {
        Route::get('', [CourseController::class, 'enrollList']);
        Route::get('{enroll_id}/{course_id}', [CourseController::class, 'enrollDetail']);
        Route::get('{enroll_id}/{course_id}/material/{material_id}', [CourseController::class, 'enrollContent']);
        Route::get('{enroll_id}/{course_id}/certificate', [CourseController::class, 'certificate']);

        Route::get('done/{enroll_id}/{course_id}/{material_id}', [CourseController::class, 'enrollDone']);
        Route::post('insertAnswer/{enroll_id}/{course_id}/{material_id}', [QuizController::class, 'insertAnswer']);
        Route::get('doneQuiz/{enroll_id}/{course_id}/{material_id}', [QuizController::class, 'quizDone']);
        Route::post('sendQuestion/{enroll_id}/{course_id}/{material_id}', [CourseController::class, 'sendQuestion']);
        Route::post('insert_rating/{enroll_id}/{course_id}', [CourseController::class, 'insertRating']);
    });

    Route::prefix('transaction')->name('transaction')->group(function() {
        Route::get('', [TransactionController::class, 'list']);
        Route::get('{id}', [TransactionController::class, 'detail']);

        Route::post('upload_payment/{id}', [TransactionController::class, 'uploadPayment']);
    });
    
    Route::prefix('admin')->name('admin')->group(function() {
        Route::prefix('instructor')->name('instructor')->group(function() {
            Route::get('', [InstructorController::class, 'index']);
            Route::get('add', [InstructorController::class, 'add']);
            Route::get('edit/{id}', [InstructorController::class, 'edit']);
            
            Route::post('insert', [InstructorController::class, 'insert']);
            Route::post('update/{id}', [InstructorController::class, 'update']);
            Route::get('delete/{id}', [InstructorController::class, 'delete']);
        });

        Route::prefix('user')->name('user')->group(function() {
            Route::get('', [UserController::class, 'index']);
            Route::get('add', [UserController::class, 'add']);
            Route::get('edit/{id}', [UserController::class, 'edit']);
            
            Route::post('insert', [UserController::class, 'insert']);
            Route::post('update/{id}', [UserController::class, 'update']);
            Route::get('delete/{id}', [UserController::class, 'delete']);
        });

        Route::prefix('transaction')->name('transaction')->group(function() {
            Route::get('', [TransactionController::class, 'index']);
            Route::get('{id}', [TransactionController::class, 'confirmation']);
            
            Route::get('validation_payment/{id}/{status}', [TransactionController::class, 'validationPayment']);
        });

        Route::prefix('course')->name('course')->group(function() {
            Route::get('', [CourseController::class, 'index']);
            Route::get('{id}', [CourseController::class, 'detail']);
            
            Route::get('validation_payment/{id}/{status}', [TransactionController::class, 'validationPayment']);
        });
    });


    Route::prefix('instructor')->name('instructor')->group(function() {
        Route::prefix('course')->name('course')->group(function() {
            Route::get('', [CourseController::class, 'instructorCourseList']);
            Route::get('add', [CourseController::class, 'instructorCourseAdd']);
            Route::get('{id}', [CourseController::class, 'instructorCourseDetail']);
            Route::get('{id}/edit', [CourseController::class, 'instructorCourseEdit']);

            Route::get('{id}/material', [CourseController::class, 'instructorCourseMaterial']);
            Route::get('{id}/material/add_section', [CourseController::class, 'instructorAddSection']);
            Route::get('{id}/material/{section_id}/edit_section', [CourseController::class, 'instructorEditSection']);
            Route::get('{id}/material/{section_id}/add_material/video', [CourseController::class, 'instructorAddMaterialVideo']);
            Route::get('{id}/material/{section_id}/add_material/quiz', [CourseController::class, 'instructorAddMaterialQuiz']);
            Route::get('{id}/material/{section_id}/edit_material/quiz', [CourseController::class, 'instructorEditMaterialQuiz']);
            Route::get('{id}/material/{section_id}/edit_material/video', [CourseController::class, 'instructorEditMaterialVideo']);

            Route::get('{id}/material/{material_id}/quiz', [CourseController::class, 'instructorAddQuiz']);
            Route::get('{id}/material/{material_id}/quiz/{quiz_id}/edit', [CourseController::class, 'instructorEditQuiz']);

            Route::get('{id}/delete', [CourseController::class, 'instructorCourseDelete']);
            Route::post('{id}/update', [CourseController::class, 'instructorCourseUpdate']);
            Route::post('insert', [CourseController::class, 'instructorCourseInsert']);

            Route::post('insert_section/{id}', [CourseController::class, 'instructorInsertSection']);
            Route::get('delete_section/{id}/{section_id}', [CourseController::class, 'instructorDeleteSection']);
            Route::post('update_section/{id}/{section_id}', [CourseController::class, 'instructorUpdateSection']);
            Route::post('insert_material/{material_type}/{id}/{section_id}', [CourseController::class, 'instructorInsertMaterial']);
            Route::post('update_material/{material_type}/{id}/{section_id}/{material_id}', [CourseController::class, 'instructorUpdateMaterial']);
            Route::get('delete_material/{id}/{section_id}/{material_id}', [CourseController::class, 'instructorDeleteMaterial']);

            Route::post('insert_quiz/{id}/{material_id}', [QuizController::class, 'insert']);
            Route::get('delete_quiz/{id}/{material_id}/{quiz_id}', [QuizController::class, 'delete']);
            Route::post('update_quiz/{id}/{material_id}/{quiz_id}', [QuizController::class, 'update']);
        });

        Route::prefix('discussion')->name('discussion')->group(function() {
            Route::get('', [DiscussionController::class, 'index']);
            Route::get('{id}', [DiscussionController::class, 'detail']);

            Route::post('insert_reply/{id}', [DiscussionController::class, 'insertReply']);
        });
    });
});


Route::prefix('profile')->name('profile')->group(function () {
    Route::get('', [FrontpageController::class, 'profile']);

    Route::post('change_bio', [ProfileController::class, 'changeBio']);
    Route::post('change_password', [ProfileController::class, 'changePassword']);
});

Route::prefix('transaction')
    ->name('transaction')
    ->group(function () {
        Route::get('', [TransactionController::class, 'index']);
        Route::get('add', [TransactionController::class, 'add']);
        Route::get('detail/{id}', [TransactionController::class, 'detail']);

        Route::post('insert', [TransactionController::class, 'insert']);
        Route::post('upload_payment/{id}', [TransactionController::class, 'uploadPayment']);
        Route::get('validation_payment/{id}/{status}', [TransactionController::class, 'validationPayment']);
        Route::post('select_driver/{id}', [TransactionController::class, 'selectDriver']);
    });


Route::prefix('auth')->name('auth')->group(function () {
    Route::get('login', [FrontpageController::class, 'login']);
    Route::get('register', [FrontpageController::class, 'register']);

    Route::post('do_login', [FrontpageController::class, 'do_login']);
    Route::post('do_register', [FrontpageController::class, 'do_register']);
    Route::get('do_logout', [FrontpageController::class, 'do_logout']);
});
