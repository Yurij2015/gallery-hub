<?php

use App\Http\Controllers\BucketObjectsController;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/buckets', [BucketController::class, 'index'])->name('buckets.index');


    Route::get('/bucket-objects/{bucketName}', [BucketObjectsController::class, 'index'])->name('bucket-objects');
    //projects
    //TODO add username to the route
    //Route::get('/{userName}/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->where('project',
        '[0-9]+')->name('projects.show');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/edit/{project}', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});


Route::get('/user-projects/{user}/{project}', [ProjectController::class, 'clientGallery'])->name('user-projects.show');
Route::get('/download-folder/{project}', [ProjectController::class, 'downloadFolder'])->name('download-folder');

//likes and comments ajax
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
    Route::post('/projects/{project}/like', [ProjectController::class, 'saveUserLike'])->name('projects.like');
    Route::post('/projects/{project}/comment', [ProjectController::class, 'saveUserComment'])->name('projects.comment');
});

require __DIR__.'/auth.php';
