<?php

use App\Http\Livewire\HomeComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LanguageController, StaterkitController};
use App\Http\Livewire\Back\App\SettingComponent;
use App\Http\Livewire\Back\Permission\{CreatePermissionComponent, EditPermissionComponent, PermissionComponent};
use App\Http\Livewire\Back\Role\{CreateRoleComponent, EditRoleComponent, RoleComponent};
use App\Http\Livewire\Back\User\{CreateUserComponent, EditUserComponent, ShowUserComponent, UserComponent};

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
Route::mailPreview();

// Route::get('/', [StaterkitController::class, 'home'])->name('home');
// Route::get('home', [StaterkitController::class, 'home'])->name('home');
Route::redirect('/', 'login');

// Route Components
Route::get('layouts/collapsed-menu', [StaterkitController::class, 'collapsed_menu'])->name('collapsed-menu');
Route::get('layouts/full', [StaterkitController::class, 'layout_full'])->name('layout-full');
Route::get('layouts/without-menu', [StaterkitController::class, 'without_menu'])->name('without-menu');
Route::get('layouts/empty', [StaterkitController::class, 'layout_empty'])->name('layout-empty');
Route::get('layouts/blank', [StaterkitController::class, 'layout_blank'])->name('layout-blank');


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', HomeComponent::class)->name('dashboard');

    Route::middleware(['permission:crud permission'])->prefix('permissions')->name('permissions.')->group(function() {
        Route::get('/', PermissionComponent::class)->name('index');
        Route::get('/create', CreatePermissionComponent::class)->name('create');
        Route::get('/{id}/edit', EditPermissionComponent::class)->name('edit');
    });

    Route::middleware(['permission:crud role'])->prefix('roles')->name('roles.')->group(function() {
        Route::get('/', RoleComponent::class)->name('index');
        Route::get('/create', CreateRoleComponent::class)->name('create');
        Route::get('/{id}/edit', EditRoleComponent::class)->name('edit');
    });

    Route::prefix('users')->name('users.')->group(function() {
        Route::get('/', UserComponent::class)->name('index')->middleware('permission:show users');
        Route::get('/create', CreateUserComponent::class)->name('create')->middleware('permission:create users');
        Route::get('/{id}/edit', EditUserComponent::class)->name('edit')->middleware('permission:edit users');
        Route::get('/{id}/show', ShowUserComponent::class)->name('show')->middleware('permission:show users');
    });

    Route::name('settings')->get('settings', SettingComponent::class)->middleware(['permission:setting']);

});
