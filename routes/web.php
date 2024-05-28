<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\AdminMemberController;
use App\Http\Controllers\admin\AdminItemController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\general\GeneralHomeController;
use App\Http\Controllers\general\GeneralProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /** 管理者 */
    Route::get('/admin/home', [AdminHomeController::class, 'home'])->name('admin.home');
    Route::get('/admin', function(){
        return redirect()->route('admin.home');
    })->name('admin');

    Route::get('/admin/member', [AdminMemberController::class, 'list'])->name('admin.member');
    Route::get('/admin/member/register', [AdminMemberController::class, 'register'])->name('admin.member.register');
    Route::post('/admin/member/create', [AdminMemberController::class, 'create'])->name('admin.member.create');
    Route::get('/admin/member/detail/{member_id}', [AdminMemberController::class, 'detail'])->name('admin.member.detail');
    Route::get('/admin/member/edit/{member_id}', [AdminMemberController::class, 'edit'])->name('admin.member.edit');
    Route::post('/admin/member/update', [AdminMemberController::class, 'update'])->name('admin.member.update');
    Route::post('/admin/member/delete', [AdminMemberController::class, 'delete'])->name('admin.member.delete');
    Route::post('/admin/member/proccess', [AdminMemberController::class, 'proccess'])->name('admin.member.proccess');

    Route::get('/admin/item', [AdminItemController::class, 'list'])->name('admin.item');
    Route::get('/admin/item/register', [AdminItemController::class, 'register'])->name('admin.item.register');
    Route::post('/admin/item/create', [AdminItemController::class, 'create'])->name('admin.item.create');


    /** 一般 */
    Route::get('/general/home', [GeneralHomeController::class, 'home'])->name('general.home');
    Route::get('/general', function(){
        return redirect()->route('general.home');
    })->name('general');

    Route::get('/general/profile', [GeneralProfileController::class, 'index'])->name('general.profile');
    Route::get('/general/profile/edit', [GeneralProfileController::class, 'edit'])->name('general.profile.edit');
    Route::post('/general/profile/request', [GeneralProfileController::class, 'request'])->name('general.profile.request');
    Route::post('/general/profile/cancel', [GeneralProfileController::class, 'cancel'])->name('general.profile.cancel');
});

require __DIR__.'/auth.php';
