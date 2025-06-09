<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CaborProfileController;
use App\Http\Controllers\KlienController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SuperadminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::get('/', function () {
    return view('Pages.landingpage');
});
// Route::get('/dashboard-klien', function () {
//     return view('Pages.dashboard-klien');
// });
// Route::get('/data-proposal', function () {
//     return view('Pages.data-proposal');
// });
// Route::get('/data-proposal-admin', function () {
//     return view('Pages.data-proposal-internal');
// });
// Route::get('/data-user', function () {
//     return view('Pages.data-user');
// });
// Route::get('/ajukan-proposal', function () {
//     return view('Pages.ajukan-proposal');
// });
// Route::get('/profile', function () {
//     return view('Pages.profile-cabor');
// });
// Route::get('/detail-proposal', function () {
//     return view('Pages.detail-proposal');
// });
// Route::get('/login', function () {
//     return view('Auth.login');
// });
// Route::get('/register', function () {
//     return view('Auth.register');
// });
Route::get('/update-proposal', function () {
    return view('Pages.update-proposal');
});
// Route::get('/dashboard-admin', function () {
//     return view('Pages.dashboard-admin');
// });
// Route::get('/proposal-terbaru', function () {
//     return view('Pages.proposal-terbaru');
// });
Route::get('/detail-proposal-terbaru-fo', function () {
    return view('Pages.detail-proposal-terbaru-fo');
});
Route::get('/proses-proposal-fo', function () {
    return view('Pages.proses-proposal-fo');
});
// Route::get('/detail-proposal-allRole', function () {
//     return view('Pages.detail-proposal-allRole');
// });
Route::get('/update-status-proposal-allRole', function () {
    return view('Pages.update-status-proposal-allRole');
});
// Route::get('/user', function () {
//     return view('Pages.user');
// });

Route::get('/faqs', function () {
    return view('Pages.faqs');
});

// ================== GROUP PREFIX AUTHENTICATION ==================
// Registrasi klien
Route::get('/register', [KlienController::class, 'registerForm']);
Route::post('/register', [KlienController::class, 'registerStore']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route khusus klien (harus login dan role Klien)
Route::middleware(['auth', 'role:frontoffice'])->group(function () {
    Route::get('/dashboard-klien', [KlienController::class, 'dashboard']);
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/data-user', [SuperadminController::class, 'dataUser'])->name('superadmin.data-user');
    Route::get('/user/create', [SuperadminController::class, 'create'])->name('superadmin.user.create');
    Route::post('/user', [SuperadminController::class, 'storeUser'])->name('user.store');
    Route::delete('/user/{id}', [SuperadminController::class, 'deleteUser'])->name('superadmin.user.delete');
});

Route::get('/proposal/tracking/{id}', [ProposalController::class, 'trackingPublic'])->name('proposal.tracking.public');

// Route khusus Superadmin
Route::middleware(['auth', 'role:superadmin,frontoffice,backoffice,stafpimpinan,sekretarisumum,stafbinpres,binpres,sekretarisdua,ketuadua,ketuaumum,keuangan,bai'])->group(function () {
    Route::get('/dashboard-admin', [SuperadminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/proposal-terbaru', [ProposalController::class, 'proposalTerbaru'])->name('superadmin.proposal-terbaru');

    // Proposal routes
    Route::get('/proposal', [ProposalController::class, 'index'])->name('superadmin.proposal.index');
    Route::get('/proposal/{id}', [ProposalController::class, 'show'])->name('superadmin.proposal.show');
    Route::get('/proposal/tanda-terima/{id}', [ProposalController::class, 'tandaTerima'])->name('superadmin.proposal.tanda-terima');
    Route::put('/proposal/ubah-status/{id}', [ProposalController::class, 'ubahStatus'])->name('superadmin.proposal.ubah-status');
    Route::get('/proposals/export/excel', [ProposalController::class, 'exportCsv'])->name('proposal.export.csv');
});

// ================== ROUTING PROPOSAL ==================
Route::middleware(['auth', 'role:frontoffice'])->prefix('frontoffice')->group(function () {
    Route::get('/proposal', [ProposalController::class, 'index'])->name('klien.proposal.index');
    Route::get('/proposal/create', [ProposalController::class, 'create'])->name('klien.proposal.create');
    Route::post('/proposal', [ProposalController::class, 'store'])->name('klien.proposal.store');
    Route::get('/proposal/{id}', [ProposalController::class, 'show'])->name('klien.proposal.show');
    Route::get('/proposal/{id}/edit', [ProposalController::class, 'edit'])->name('klien.proposal.edit');
    Route::put('/proposal/{id}', [ProposalController::class, 'update'])->name('klien.proposal.update');

    // Menampilkan halaman profil cabor
    Route::get('/profil-cabor', [CaborProfileController::class, 'index'])->name('klien.profil-cabor.index');
    Route::put('/profil-cabor/{id}', [CaborProfileController::class, 'update'])->name('klien.profil-cabor.update');
});


Route::get('/proposal/file/{filename}', function ($filename) {
    $path = storage_path('app') . DIRECTORY_SEPARATOR . 'proposals' . DIRECTORY_SEPARATOR . $filename;
    // Untuk debug lebih lanjut, tampilkan path yang sedang dicoba
    \Log::info("Attempting to serve file from: " . $path);

    if (file_exists($path)) {
        \Log::info("File found at: " . $path);
        return response()->file($path);
    } else {
        \Log::error("File NOT found at: " . $path); // Gunakan error agar lebih menonjol di log
        abort(404, 'File proposal tidak ditemukan.');
    }
})->name('proposal.file');


Route::get('/test-proposal/{id}', function ($id) {
    $proposal = \App\Models\Proposal::find($id);
    if (!$proposal) {
        return "Proposal dengan ID $id tidak ditemukan";
    }
    return "Proposal dengan ID $id ditemukan: " . $proposal->judul;
});
