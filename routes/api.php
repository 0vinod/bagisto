<?php

use App\Http\Controllers\Api\AttemptController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\ProgressController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\SyllabusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Subjects
    Route::get('/subjects', [SubjectController::class, 'index']);

    // Notes
    Route::get('/notes', [NoteController::class, 'index']);

    // Questions
    Route::get('/questions', [QuestionController::class, 'index']);

    // Syllabus
    Route::get('/syllabus_topics', [SyllabusController::class, 'topics']);
    Route::get('/syllabus_items', [SyllabusController::class, 'items']);

    // Progress Tracking
    Route::get('/syllabus_progress', [ProgressController::class, 'index']);
    Route::post('/syllabus_progress', [ProgressController::class, 'store']);
    Route::delete('/syllabus_progress', [ProgressController::class, 'destroy']);

    // Practice Attempts
    Route::get('/attempts/stats', [AttemptController::class, 'stats']);
    Route::get('/attempts', [AttemptController::class, 'index']);
    Route::post('/attempts', [AttemptController::class, 'store']);
});
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
