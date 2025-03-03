<?php

use App\Http\Controllers\BucketObjectsController;
use App\Http\Controllers\BucketController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupportTicketController;
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
    Route::get('/profile-settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/update-user-settings', [UserController::class, 'updateUserSettings'])->name('update-user-settings');

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
    Route::post('/projects/store-folder/{project}', [ProjectController::class, 'storeFolder'])->name('projects.store-folder');
    Route::get('/projects/edit/{project}', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::get('/projects/basic-setting/{project}', [ProjectController::class, 'basicSettings'])->name('projects.basic-setting');
    Route::get('/projects/design-and-cover/{project}', [ProjectController::class, 'designAndCover'])->name('projects.design-and-cover');
    Route::get('/projects/reviews/{project}', [ProjectController::class, 'reviews'])->name('projects.reviews');
    Route::get('/projects/reviews', [ProjectController::class, 'allReviews'])->name('projects.all-reviews');
    Route::get('/projects/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::get('/projects/favorites/{project}', [ProjectController::class, 'favorites'])->name('projects.favorites');

    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::put('/projects-upload-images/{project}', [ProjectController::class, 'uploadImages'])->name('projects.upload-images');

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::get('/projects/statistic/{project}', [ProjectController::class, 'projectStatistic'])->name('project.statistic');
    Route::delete('/project/remove-object/{project}', [ProjectController::class, 'deleteObject'])->name('project.delete-object');

    // export archives (prjects)
    Route::get('/export/favorite-items/{project}', [ProjectController::class, 'exportFavoriteItems'])->name('export.favorite-items');
    Route::get('/export/consolidated-favorite-items/{project}', [ProjectController::class, 'exportConsolidatedFavoriteItems'])->name('export.consolidated-favorite-items');

    // project ajax requests
    Route::post('/project/set-cover-image/{project}', [ProjectController::class, 'setCoverImage'])->name('project.set-cover-image');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::get('/support/create', [SupportTicketController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportTicketController::class, 'store'])->name('support.store');
    Route::get('/support/{ticket}', [SupportTicketController::class, 'show'])->name('support.show');

    Route::resource('packages', PackageController::class);
});


Route::get('/user-projects/{user}/{project}', [ProjectController::class, 'clientGallery'])->name('user-projects.show');
Route::get('/download-folder/{project}', [ProjectController::class, 'downloadFolder'])->name('download-folder');

//likes and comments ajax
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
    Route::post('/projects/{project}/like', [ProjectController::class, 'saveUserLike'])->name('projects.like');
    Route::post('/projects/{project}/comment', [ProjectController::class, 'saveUserComment'])->name('projects.comment');
    Route::post('/download-object-increment/{project}', [ProjectController::class, 'downloadObjectUrlIncrement'])->name('download-object-url-increment');
    Route::post('/projects/{project}/add-review', [ProjectController::class, 'addReviewToProject'])->name('projects.add-review');
    Route::post('/projects/{project}/renew', [ProjectController::class, 'renewProject'])->name('projects.renew');
    Route::get('/projects/{project}/get-review', [ProjectController::class, 'getProjectReview'])->name('projects.get-review');
});

require __DIR__.'/auth.php';
