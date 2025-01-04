<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarefaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/logout', [ProfileController::class, 'logout'])->name('profile.logout');
});

Route::middleware('auth')->controller(CategoriaController::class)->prefix("categoria")->group( function(){
    Route::get("/index", "index")->name("categoria.index");
    Route::get("/create", "create")->name("categoria.create");
    Route::post("/store", "store")->name("categoria.store");
    Route::get("/edit/{id}", "edit")->name("categoria.edit");
    Route::post("/ativa/{id}", "ativa")->name("categoria.ativa");
    Route::post("/desativa/{id}", "desativa")->name("categoria.desativa");
    Route::post("/update/{id}", "update")->name("categoria.update");
    Route::delete("/destroy/{id}", "destroy")->name("categoria.destroy");
});

Route::middleware('auth')->controller(TarefaController::class)->prefix("tarefa")->group(function () {
    Route::get("/index", "index")->name("tarefa.index");
    Route::get("/create", "create")->name("tarefa.create");
    Route::post("/store", "store")->name("tarefa.store");
    Route::get("/edit/{id}", "edit")->name("tarefa.edit");
    Route::post("/update/{id}", "update")->name("tarefa.update");
    Route::post("/ativa/{id}", "ativa")->name("tarefa.ativa");
    Route::post("/desativa/{id}", "desativa")->name("tarefa.desativa");
    Route::post("/avancaStatus/{id}", "avancaStatus")->name("tarefa.avancaStatus");
    Route::delete("/destroy/{id}", "destroy")->name("tarefa.destroy");
});

require __DIR__.'/auth.php';
