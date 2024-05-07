<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VigenereController;



Route::get('/vigenere', [VigenereController::class, 'index'])->name('vigenere.index');
Route::post('/vigenere', [VigenereController::class, 'process'])->name('vigenere.process');
