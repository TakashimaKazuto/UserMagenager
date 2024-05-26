<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminMemberController;
use App\Http\Controllers\admin\AdminItemController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /** 管理者 */
    Route::get('/admin/home', [AdminHomeController::class, 'home'])->name('admin.home');

    Route::get('/admin/member', [AdminMemberController::class, 'list'])->name('admin.member');
    Route::get('/admin/member/register', [AdminMemberController::class, 'register'])->name('admin.member.register');
    Route::post('/admin/member/create', [AdminMemberController::class, 'create'])->name('admin.member.create');
    Route::get('/admin/member/detail/{member_id}', [AdminMemberController::class, 'detail'])->name('admin.member.detail');
    Route::get('/admin/member/edit/{member_id}', [AdminMemberController::class, 'edit'])->name('admin.member.edit');
    Route::post('/admin/member/update', [AdminMemberController::class, 'update'])->name('admin.member.update');
    Route::post('/admin/member/delete', [AdminMemberController::class, 'delete'])->name('admin.member.delete');

    Route::get('/admin/item', [AdminItemController::class, 'list'])->name('admin.item');
    Route::get('/admin/item/register', [AdminItemController::class, 'register'])->name('admin.item.register');
    Route::post('/admin/item/create', [AdminItemController::class, 'create'])->name('admin.item.create');
});

require __DIR__.'/auth.php';
