<?php

use App\Http\Controllers\Admin;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class ,'index'])->name('home');
    // Permissions
    Route::delete('permissions/destroy', [\PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', \PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [\RolesController::class,'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', \RolesController::class);

    // Users
    Route::delete('users/destroy', [\UsersController::class,'massDestroy'])->name('users.massDestroy');
    Route::resource('users', \UsersController::class);

    // Time Entries
//    Route::delete('time-entries/destroy', [\TimeEntriesController::class, 'massDestroy'])->name('time-entries.massDestroy');
//    Route::get('time-entries/show-current', [\TimeEntriesController::class, 'showCurrent'])->name('time-entries.showCurrent');
//    Route::post('time-entries/update-current', [\TimeEntriesController::class, 'updateCurrent'])->name('time-entries.updateCurrent');
//    Route::resource('time-entries', \TimeEntriesController::class);
    Route::delete('time-entries/destroy', 'TimeEntriesController@massDestroy')->name('time-entries.massDestroy');
    Route::get('time-entries/show-current', 'TimeEntriesController@showCurrent')->name('time-entries.showCurrent');
    Route::post('time-entries/update-current', 'TimeEntriesController@updateCurrent')->name('time-entries.updateCurrent');
    Route::resource('time-entries', 'TimeEntriesController');
    // Reports
    Route::get('reports', [Admin\ReportsController::class, 'index'])->name('reports.index');
});

