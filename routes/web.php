<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StageController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


// Route::get('', function () {
//     // User::insert([
//     //     'userName' => 'admin',
//     //     'email' => 'admin@gmail.com',
//     //     'password' => Hash::make('1234'),
//     // ]);
//     // $user = User::find(1);
//     // $user->assignRole('superAdmin');
// });
Route::get('', [AuthController::class,   'login_view'])->name('admin.loginview');
Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::get('/login', [AuthController::class,   'login_view'])->name('login');


Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    /* Lawyer */
    Route::get('/lawyer', [LawyerController::class, 'index'])->name('lawyer.index');
    Route::get('/lawyer/{id}', [LawyerController::class, 'show'])->name('lawyer.info');
    Route::get('/lawyer-create', [LawyerController::class, 'create'])->name('lawyers.create');
    Route::post('/lawyer-create', [LawyerController::class, 'store'])->name('lawyers.store');
    Route::post('/lawyer-update/{id}', [LawyerController::class, 'edit'])->name('lawyers.update');
Route::get('/lawyer-block/{id}', [LawyerController::class, 'block'])->name('lawyer.block');
Route::get('/lawyer-unblock/{id}', [LawyerController::class, 'unblock'])->name('lawyer.unblock');
    /* Client */
    Route::get('/client', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client-create', [ClientController::class, 'create'])->name('client.create');
    Route::post('/client-create', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client-show/{id}', [ClientController::class, 'show'])->name('client.show');
    Route::get('/client-edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/client-update/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
    Route::post('/client-files-create/{id}', [ClientController::class, 'storeFile'])->name('client.files.store');
    Route::get('/client-files-destroy/{id}', [ClientController::class, 'deleteFile'])->name('client.files.destroy');

    /* Case */
    Route::get('/case', [CaseController::class, 'index'])->name('case.index');
    Route::get('/cases/{id}', [CaseController::class, 'show'])->name('cases.show');

    Route::get('/cases-create', [CaseController::class, 'create'])->name('case.create');
    Route::post('/cases-create', [CaseController::class, 'store'])->name('case.store');
    Route::get('/cases-edit/{id}', [CaseController::class, 'edit'])->name('case.edit');
    Route::put('/case-update/{id}', [CaseController::class, 'update'])->name('case.update');

    Route::post('/file-case-store', [CaseController::class, 'fileStore'])->name('file.case.store');
    Route::post('/case/progress', [ReportController::class, 'store'])
        ->name('case.progress.increase');


    Route::get('/stage-index', [StageController::class, 'index'])->name('stage.index');
    Route::post('/stage-case-store', [StageController::class, 'store'])->name('stage.case.store');
    Route::get('/cases/{case}/export-pdf', [CaseController::class, 'exportPdf'])
        ->name('cases.export.pdf');


    Route::get('/expense-index', [ExpenseController::class, 'index'])->name('expense.index');
    Route::post('/expense-store', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('/expense-show/{case}', [ExpenseController::class, 'show'])->name('expense.show');

    Route::get('/cases/{id}/expenses/pdf', [ExpenseController::class, 'expensesPdf'])
        ->name('cases.expenses.pdf');


    Route::put('/case-update-price/{id}', [CaseController::class, 'updateCase'])->name('price.case.updated');

    Route::get('/expense-all', [ExpenseController::class, 'all'])->name('expense.all');
    Route::get('/payment-index', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment-store', [PaymentController::class, 'store'])->name('payment.store');

    Route::get('/cases/{id}/files', [CaseController::class, 'getFille'])
        ->name('case.files.index');

    Route::get('/cases/{id}/stage', [CaseController::class, 'getStage'])
        ->name('case.stages.index');

    Route::put('/case/stage/{id}', [StageController::class, 'update'])
        ->name('case.stages.edit');

    Route::get('/cases/{id}/report', [ReportController::class, 'show'])
        ->name('case.report.index');
});
 
// require __DIR__ . '/admin.php';
