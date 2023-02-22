<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FatherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Favorite_bookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SubjectController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::get('/students', [StudentController::class, 'all_accepted_students']);
Route::get('/student/{student_id}', [StudentController::class, 'show']);
Route::get('/top_students', [StudentController::class, 'top_students']);

Route::get('/teachers', [TeacherController::class, 'all_accepted_teachers']);
Route::get('/teacher/{teacher_id}', [TeacherController::class, 'show']);

 // book routes
 Route::get('books', [BookController::class ,'index']);
 Route::get('books/{id}', [BookController::class ,'show']);

  // favorite books routes
  Route::get('favorite_books/{book_id}', [Favorite_bookController::class ,'show_students']);
  Route::get('student/favorite_books/{student_id}', [Favorite_bookController::class ,'show_books']);

      // subject routes
      Route::get('subjects', [SubjectController::class ,'index']);
      Route::get('subjects/{id}', [SubjectController::class ,'show']);

  // session routes
  Route::get('/sessions', [SessionController::class, 'index']);
  Route::get('/sessions/{id}', [SessionController::class, 'show']);

Route::group(['middleware' => ['auth:api']], function () 
{
    Route::get('/logout', [UserController::class, 'logout']);
    Route::delete('/delete_user', [UserController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:api', 'father']], function ()
{
    Route::post('/students', [StudentController::class, 'store']);
});

Route::group(['middleware' => ['auth:api', 'teacher']], function ()
{
    // Sessions routes
    Route::post('/sessions', [SessionController::class, 'store']);
    Route::delete('/sessions/{id}', [SessionController::class, 'delete']);

    // Ratings routes
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::put('/ratings/{id}', [RatingController::class, 'update']);
    Route::delete('/ratings/{id}', [RatingController::class, 'delete']);
});

Route::group(['middleware' => ['auth:api', 'father', 'data']], function ()
{
    Route::get('/father_accepted_students', [StudentController::class, 'father_accepted_students']);
    Route::get('/father_pending_students', [StudentController::class, 'father_pending_students']);
    Route::post('/student/{student_id}', [StudentController::class, 'update']);
    Route::delete('/student/{student_id}', [StudentController::class, 'destroy']);

      // favorite books routes
    Route::post('favorite_books/{book_id}/{student_id}', [Favorite_bookController::class ,'store']);
    Route::delete('favorite_books/{book_id}/{student_id}', [Favorite_bookController::class ,'delete']);
});

Route::group(['middleware' => ['auth:api', 'admin']], function ()
{
     // book routes
    Route::post('/books', [BookController::class ,'store']);
    Route::post('/update_book/{id}', [BookController::class ,'update']);
    Route::delete('/books/{id}', [BookController::class ,'delete']);

     // subject routes
    Route::post('/subjects', [SubjectController::class ,'store']);
    Route::put('subjects/{id}', [SubjectController::class ,'update']);
    Route::delete('subjects/{id}', [SubjectController::class ,'delete']);

    Route::get('/all_pending_students', [StudentController::class, 'all_pending_students']);
    Route::post('/accept_student/{student_id}', [StudentController::class, 'accept_student']);
    Route::delete('/delete_student/{student_id}', [StudentController::class, 'delete_student']);

    Route::get('/all_pending_users', [UserController::class, 'all_pending_users']);
    Route::post('/accept_user/{user_id}', [UserController::class, 'accept_user']);
    Route::delete('/delete_user/{user_id}', [UserController::class, 'delete_user']);
    

    Route::get('/all_pending_teachers', [TeacherController::class, 'all_pending_teachers']);
    Route::get('/all_pending_fathers', [FatherController::class, 'all_pending_fathers']);

});