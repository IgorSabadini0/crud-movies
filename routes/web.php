<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;

// Rota principal redirecionando ou renderizando direto
Route::get('/', [FilmeController::class, 'index']);

// Rotas do CRUD de Filmes
Route::get('/filmes', [FilmeController::class, 'index'])->name('filmes.index');
Route::get('/filmes/create', [FilmeController::class, 'create'])->name('filmes.create');
Route::post('/filmes/store', [FilmeController::class, 'store'])->name('filmes.store');
Route::get('/filmes/buscar', [FilmeController::class, 'buscar'])->name('filmes.buscar');
Route::get('/filmes/edit/{id}', [FilmeController::class, 'edit'])->name('filmes.edit');
Route::post('/filmes/update/{id}', [FilmeController::class, 'update'])->name('filmes.update');
Route::delete('/filmes/deletar/{id}', [FilmeController::class, 'deletar'])->name('filmes.deletar');