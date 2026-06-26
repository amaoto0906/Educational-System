<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemoAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

// ===== 公開ページ =====
Route::get('/', [PageController::class, 'landing'])->name('landing');
Route::get('/roadmap', [PageController::class, 'roadmap'])->name('roadmap');

// ===== 認証 (受講生) =====
Route::get('/login', [DemoAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [DemoAuthController::class, 'login'])->name('login.post');
Route::get('/register', [DemoAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [DemoAuthController::class, 'register'])->name('register.post');
Route::post('/logout', [DemoAuthController::class, 'logout'])->name('logout');

// ===== 認証 (管理者・講師) =====
Route::get('/admin/login', [DemoAuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [DemoAuthController::class, 'adminLogin'])->name('admin.login.post');
Route::get('/teacher/login', [DemoAuthController::class, 'showTeacherLogin'])->name('teacher.login');
Route::post('/teacher/login', [DemoAuthController::class, 'teacherLogin'])->name('teacher.login.post');

// ===== 受講生 =====
Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/videos', [StudentController::class, 'videos'])->name('videos');
    Route::get('/materials', [StudentController::class, 'materials'])->name('materials');
    Route::get('/mock-exam', [StudentController::class, 'mockExam'])->name('mock-exam');
    Route::get('/review-tests', [StudentController::class, 'reviewTests'])->name('review-tests');
    Route::get('/review-tests/{id}', [StudentController::class, 'reviewTestShow'])->name('review-test-show');
    Route::post('/review-tests/{id}/submit', [StudentController::class, 'reviewTestSubmit'])->name('review-test-submit');
    Route::get('/review-tests/{id}/result', [StudentController::class, 'reviewTestResult'])->name('review-test-result');
});

// ===== 管理者 =====
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 専用画面 (汎用CRUDより前に定義)
    Route::get('/basic-settings', [AdminController::class, 'basicSettings'])->name('basic-settings');
    Route::put('/basic-settings', [AdminController::class, 'updateBasicSettings'])->name('basic-settings.update');
    Route::get('/bulk-register', [AdminController::class, 'bulkRegister'])->name('bulk-register');
    Route::post('/bulk-register/run', [AdminController::class, 'bulkRegisterRun'])->name('bulk-register.run');
    Route::get('/queue-monitor', [AdminController::class, 'queueMonitor'])->name('queue-monitor');
    Route::post('/queue-monitor/{id}/retry', [AdminController::class, 'retryJob'])->name('queue-monitor.retry');
    Route::get('/cron-monitor', [AdminController::class, 'cronMonitor'])->name('cron-monitor');
    Route::get('/error-logs', [AdminController::class, 'errorLogs'])->name('error-logs');
    Route::post('/reset', [AdminController::class, 'resetDemo'])->name('reset');

    // 汎用 CRUD (entity を既知キーに制約)
    $entities = ['projects', 'videos', 'materials', 'test_sets', 'questions', 'teachers', 'staff', 'exam_master', 'email_mistakes'];
    Route::get('/{entity}', [AdminController::class, 'index'])->name('crud.index')->whereIn('entity', $entities);
    Route::get('/{entity}/create', [AdminController::class, 'create'])->name('crud.create')->whereIn('entity', $entities);
    Route::post('/{entity}', [AdminController::class, 'store'])->name('crud.store')->whereIn('entity', $entities);
    Route::get('/{entity}/{id}/edit', [AdminController::class, 'edit'])->name('crud.edit')->whereIn('entity', $entities);
    Route::put('/{entity}/{id}', [AdminController::class, 'update'])->name('crud.update')->whereIn('entity', $entities);
    Route::delete('/{entity}/{id}', [AdminController::class, 'destroy'])->name('crud.destroy')->whereIn('entity', $entities);
    Route::post('/{entity}/{id}/toggle', [AdminController::class, 'toggle'])->name('crud.toggle')->whereIn('entity', $entities);
});

// ===== 講師 =====
Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/questions', [TeacherController::class, 'questions'])->name('questions');
    Route::get('/questions/create', [TeacherController::class, 'createQuestion'])->name('questions.create');
    Route::post('/questions', [TeacherController::class, 'storeQuestion'])->name('questions.store');
    Route::get('/questions/{id}/edit', [TeacherController::class, 'editQuestion'])->name('questions.edit');
    Route::put('/questions/{id}', [TeacherController::class, 'updateQuestion'])->name('questions.update');
    Route::delete('/questions/{id}', [TeacherController::class, 'destroyQuestion'])->name('questions.destroy');
});
