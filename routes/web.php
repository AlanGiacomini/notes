<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use Illuminate\Support\Facades\Route;

// Before Login
Route::middleware([CheckIsNotLogged::class])->group(function(){
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
});

//After Login
Route::middleware([CheckIsLogged::class])->group(function(){
    //método name coloca apelido na rota para usá-las no html usando {{Routes('nome')}}
    Route::get('/', [MainController::class, 'index'])->name('home');
    //New note
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new.note');
    Route::post('/newNoteSubmit', [MainController::class, 'insertNote'])->name('insert.note');
    //Edit note
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit.note');
    Route::post('/editNoteSubmit', [MainController::class, 'updateNote'])->name('update.note');
    //Delete note
    Route::get('/removeNote/{id}', [MainController::class, 'removeNote'])->name('remove.note');
    Route::get('/removeNoteSubmit/{id}', [MainController::class, 'deleteNote'])->name('delete.note');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});