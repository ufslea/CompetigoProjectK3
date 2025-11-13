<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubLombaController;
use App\Http\Controllers\PartisipanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\NotifikasiController;

Route::resource('users', UserController::class);
Route::resource('events', EventController::class);
Route::resource('sub-lomba', SubLombaController::class);
Route::resource('partisipan', PartisipanController::class);
Route::resource('pengumuman', PengumumanController::class);
Route::resource('hasil', HasilController::class);
Route::resource('sertifikat', SertifikatController::class);
Route::resource('notifikasi', NotifikasiController::class);
