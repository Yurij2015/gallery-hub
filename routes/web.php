<?php

use App\Http\Controllers\BucketObjectsController;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
});

require __DIR__.'/auth.php';
