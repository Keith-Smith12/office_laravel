<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExelController;
use App\Http\Controllers\UserController;
use App\Livewire\FormComponente;

Route::get('/index', function () {
    return view('livewire.index');
});



Route::get('/lista', [exelController::class, 'generateExcel'])->name('gerar.excel'); // Processar envio
Route::get('/cadastrar-em-massa', [exelController::class, 'mostrarFormulario'])->name('mostrar.formulario'); // Exibir formulário de upload
Route::post('/enviar-excel', [exelController::class, 'enviar'])->name('enviar.excel'); // Processar envio

Route::resource('users', UserController::class);
