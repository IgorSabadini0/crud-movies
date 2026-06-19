<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;

// Rota principal redirecionando ou renderizando direto
Route::get('/', [FilmeController::class, 'index']);

// Rotas do CRUD de Filmes
Route::get('/filmes', [FilmeController::class, 'index'])->name('index');
Route::get('/filmes/create', [FilmeController::class, 'create'])->name('create');
Route::post('/filmes/store', [FilmeController::class, 'store'])->name('store');
Route::get('/filmes/buscar', [FilmeController::class, 'buscar'])->name('buscar');
Route::get('/filmes/edit/{id}', [FilmeController::class, 'edit'])->name('edit');
Route::post('/filmes/update/{id}', [FilmeController::class, 'update'])->name('update');
Route::delete('/filmes/deletar/{id}', [FilmeController::class, 'deletar'])->name('deletar');