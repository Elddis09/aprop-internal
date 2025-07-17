<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FoController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SuperadminController;
use Illuminate\Support\Facades\Route;

// ================== ROUTE GENERAL ==================
Route::get('/', function () {
    return view('Pages.Landing.landingpage');
});

Route::get('/faqs', function () {
    return view('Pages.FAQ.faqs');
});

Route::get('/proposal/tracking/{id}', [ProposalController::class, 'trackingPublic'])->name('proposal.tracking.public');

// ================== ROUTE AUTHENTICATION ==================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ================== ROUTE FRONT OFFICE ==================
Route::middleware(['auth', 'check.password', 'role:frontoffice'])->group(function () {
    Route::get('/dashboard-fo', [FoController::class, 'dashboard'])->name('fo.dashboard');
});

// ================== ROUTE SUPERADMIN ==================
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/data-user', [SuperadminController::class, 'dataUser'])->name('superadmin.data-user');
    Route::get('/user/create', [SuperadminController::class, 'create'])->name('superadmin.user.create');
    Route::get('/admin/users/{id}/edit', [SuperadminController::class, 'edit'])->name('superadmin.user.edit');
    Route::put('/admin/users/{id}', [SuperadminController::class, 'update'])->name('superadmin.user.update');
    Route::post('/user', [SuperadminController::class, 'storeUser'])->name('user.store');
    // Route::put('/admin/users/{id}/reset-password', [SuperadminController::class, 'resetPassword'])->name('admin.user.reset-password');
    Route::delete('/user/{id}', [SuperadminController::class, 'deleteUser'])->name('superadmin.user.delete');
});

// ================== ROUTE ALL ROLE ==================
Route::middleware(['auth', 'check.password', 'role:superadmin,frontoffice,backoffice,stafpimpinan,sekretarisumum,stafbinpres,binpres,sekretarisdua,ketuadua,ketuaumum,keuangan,bai,stafumum,bidangumum,sekretaristiga,ketuatiga'])->group(function () {
    Route::get('/dashboard-admin', [SuperadminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/proposal-terbaru', [ProposalController::class, 'proposalTerbaru'])->name('superadmin.proposal-terbaru');

    // Proposal routes
    Route::get('/bank-proposals', [ProposalController::class, 'bankProposals'])->name('superadmin.proposal.bank-proposal');
    Route::get('/data-proposal', [ProposalController::class, 'dataProposal'])->name('superadmin.proposal.data-proposal');
    Route::get('/proposal/{id}', [ProposalController::class, 'show'])->name('superadmin.proposal.show');
    Route::get('/proposal/edit/{id}', [ProposalController::class, 'edit'])->name('superadmin.proposal.edit');
    Route::put('/proposal/update/{proposal}', [ProposalController::class, 'update'])->name('superadmin.proposal.update');
    Route::get('/proposal/tanda-terima/{id}', [ProposalController::class, 'tandaTerima'])->name('superadmin.proposal.tanda-terima');
    Route::get('/proposal/disposisi/{id}', [ProposalController::class, 'disposisi'])->name('superadmin.proposal.disposisi');
    Route::get('/proposal/form-undangan/{id}', [ProposalController::class, 'formUndangan'])->name('superadmin.proposal.form-undangan');
    Route::get('/proposal/form-peminjaman/{id}', [ProposalController::class, 'formPeminjaman'])->name('superadmin.proposal.form-peminjaman');
    Route::get('/proposal/form-ceklis/{id}', [ProposalController::class, 'formCeklis'])->name('superadmin.proposal.form-ceklis');
    Route::put('/proposal/ubah-status/{id}', [ProposalController::class, 'ubahStatus'])->name('superadmin.proposal.ubah-status');
    Route::get('/proposals/export/excel', [ProposalController::class, 'exportCsv'])->name('proposal.export.csv');
    Route::post('/proposal/{proposal}/generate-agenda', [ProposalController::class, 'generateAgendaNumber'])->name('proposal.generateAgenda');
});

// ==================  ROUTE CREATE PROPOSAL ==================
Route::middleware(['auth', 'check.password', 'role:frontoffice,superadmin,backoffice,stafpimpinan,sekretarisumum,stafbinpres,binpres,sekretarisdua,ketuadua,ketuaumum,keuangan,bai,stafumum,bidangumum,sekretaristiga,ketuatiga'])->prefix('frontoffice')->group(function () {
    Route::get('/proposal', [ProposalController::class, 'dataProposal'])->name('klien.proposal.data-proposal');
    Route::get('/proposal/create', [ProposalController::class, 'create'])->name('klien.proposal.create');
    Route::post('/proposal', [ProposalController::class, 'store'])->name('klien.proposal.store');
});
