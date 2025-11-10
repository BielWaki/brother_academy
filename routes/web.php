<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlunoAuthController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::middleware('guest:aluno')->group(function () {
    Route::get('/aluno/login', [AlunoAuthController::class, 'showLoginForm'])->name('aluno.login.form');
    Route::post('/aluno/login', [AlunoAuthController::class, 'login'])->name('aluno.login');
    
    Route::get('/aluno/matricula', [AlunoAuthController::class, 'showRegistrationForm'])->name('aluno.register.form');
    Route::post('/aluno/matricula', [AlunoAuthController::class, 'register'])->name('aluno.register');
});

Route::middleware('auth:aluno')->group(function () {
    Route::get('/aluno/dashboard', [PainelController::class, 'alunoDashboard'])->name('aluno.dashboard');
    Route::post('/aluno/logout', [AlunoAuthController::class, 'logout'])->name('aluno.logout');
    Route::get('/aluno/mudar-senha', [AlunoAuthController::class, 'showChangePasswordForm'])->name('aluno.senha.form');
    Route::post('/aluno/mudar-senha', [AlunoAuthController::class, 'updatePassword'])->name('aluno.senha.update');
    Route::get('/aluno/perfil', [PainelController::class, 'showPerfil'])->name('aluno.perfil');
    Route::get('/aluno/pagamentos', [PainelController::class, 'showPagamentos'])->name('aluno.pagamentos');
});



Route::prefix('gestao')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:web')->group(function () {
    
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::prefix('pagamentos')->group(function () {
            Route::get('/', [AdminController::class, 'indexPagamentos'])->name('pagamentos.index');
            Route::get('/novo', [AdminController::class, 'createPagamentos'])->name('pagamentos.create');
            Route::post('/', [AdminController::class, 'storePagamentos'])->name('pagamentos.store');
        });
        
        Route::prefix('planos')->group(function () {
            Route::get('/', [AdminController::class, 'indexPlanos'])->name('planos.index');
            Route::get('/novo', [AdminController::class, 'createPlanos'])->name('planos.create');
            Route::post('/', [AdminController::class, 'storePlanos'])->name('planos.store');
            Route::get('/{id}/editar', [AdminController::class, 'editPlanos'])->name('planos.edit');
            Route::put('/{id}', [AdminController::class, 'updatePlanos'])->name('planos.update');
            Route::delete('/{id}', [AdminController::class, 'destroyPlanos'])->name('planos.destroy');
            Route::put('/{id}/restaurar', [AdminController::class, 'restorePlanos'])->name('planos.restore'); 
        });
        
        Route::prefix('modalidades')->group(function () {
            Route::get('/', [AdminController::class, 'indexModalidades'])->name('modalidades.index');
            Route::get('/novo', [AdminController::class, 'createModalidades'])->name('modalidades.create');
            Route::post('/', [AdminController::class, 'storeModalidades'])->name('modalidades.store');
            Route::get('/{id}/editar', [AdminController::class, 'editModalidades'])->name('modalidades.edit');
            Route::put('/{id}', [AdminController::class, 'updateModalidades'])->name('modalidades.update');
            Route::delete('/{id}', [AdminController::class, 'destroyModalidades'])->name('modalidades.destroy');
            Route::put('/{id}/restaurar', [AdminController::class, 'restoreModalidades'])->name('modalidades.restore');
        });

        Route::prefix('professores')->group(function () {
            Route::get('/', [AdminController::class, 'indexProfessores'])->name('professores.index');
            Route::get('/novo', [AdminController::class, 'createProfessores'])->name('professores.create');
            Route::post('/', [AdminController::class, 'storeProfessores'])->name('professores.store');
            Route::get('/{id}/editar', [AdminController::class, 'editProfessores'])->name('professores.edit');
            Route::put('/{id}', [AdminController::class, 'updateProfessores'])->name('professores.update');
            Route::delete('/{id}', [AdminController::class, 'destroyProfessores'])->name('professores.destroy');
        });
        
        Route::prefix('alunos')->group(function () {
            Route::get('/', [AdminController::class, 'indexAlunos'])->name('alunos.index');
            Route::get('/novo', [AdminController::class, 'createAlunos'])->name('alunos.create');
            Route::post('/', [AdminController::class, 'storeAlunos'])->name('alunos.store');
            Route::get('/{id}/editar', [AdminController::class, 'editAlunos'])->name('alunos.edit');
            Route::put('/{id}', [AdminController::class, 'updateAlunos'])->name('alunos.update');
            Route::patch('/{id}/bloqueio', [AdminController::class, 'toggleBlockAlunos'])->name('alunos.toggleBlock');
        });
    });

});