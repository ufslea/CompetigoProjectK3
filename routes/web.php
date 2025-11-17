<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubLombaController;
use App\Http\Controllers\PartisipanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\OrganizerProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\LaporanController;

// Public home
Route::get('/', function () {
    return view('welcome');
});

// Resource routes (tanpa middleware)
Route::resource('users', UserController::class);
Route::resource('events', EventController::class);
Route::resource('sub-lomba', SubLombaController::class);
Route::resource('partisipan', PartisipanController::class);
Route::resource('pengumuman', PengumumanController::class);
Route::resource('hasil', HasilController::class);
Route::resource('sertifikat', SertifikatController::class);
Route::resource('notifikasi', NotifikasiController::class);

// ===================================
// ORGANIZER ROUTES
// ===================================
Route::middleware(['auth', 'organizer'])
    ->prefix('organizer')
    ->name('organizer.')
    ->group(function () {
        Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('dashboard');

        // EVENT
        Route::prefix('events')->as('events.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/create', [EventController::class, 'create'])->name('create');
            Route::post('/', [EventController::class, 'store'])->name('store');
            Route::get('/{id}', [EventController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EventController::class, 'update'])->name('update');
            Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy');

            // SUB-LOMBA dalam event
            Route::prefix('{event_id}/sublomba')->as('sublomba.')->group(function () {
                Route::get('/', [SubLombaController::class, 'index'])->name('index');
                Route::get('/create', [SubLombaController::class, 'create'])->name('create');
                Route::post('/', [SubLombaController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [SubLombaController::class, 'edit'])->name('edit');
                Route::put('/{id}', [SubLombaController::class, 'update'])->name('update');
                Route::delete('/{id}', [SubLombaController::class, 'destroy'])->name('destroy');
            });
        });

        // PARTICIPANTS
        Route::get('/participants', [PartisipanController::class, 'index'])->name('participants.index');
        Route::get('/participants/{id}', [PartisipanController::class, 'show'])->name('participants.show');

        // ANNOUNCEMENTS
        Route::prefix('announcements')->as('announcements.')->group(function () {
            Route::get('/', [PengumumanController::class, 'index'])->name('index');
            Route::get('/create', [PengumumanController::class, 'create'])->name('create');
            Route::post('/', [PengumumanController::class, 'store'])->name('store');
            Route::get('/{id}', [PengumumanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PengumumanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PengumumanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengumumanController::class, 'destroy'])->name('destroy');
        });

        // RESULTS
        Route::prefix('results')->as('results.')->group(function () {
            Route::get('/', [HasilController::class, 'index'])->name('index');
            Route::get('/create', [HasilController::class, 'create'])->name('create');
            Route::post('/', [HasilController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [HasilController::class, 'edit'])->name('edit');
            Route::put('/{id}', [HasilController::class, 'update'])->name('update');
            Route::delete('/{id}', [HasilController::class, 'destroy'])->name('destroy');
        });

        // USER PROFILE
        Route::prefix('profile')->as('profile.')->group(function () {
            Route::get('/', [OrganizerProfileController::class, 'index'])->name('index');
            Route::get('/edit', [OrganizerProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [OrganizerProfileController::class, 'update'])->name('update');
        });
    });

// ===================================
// ADMIN ROUTES
// ===================================
Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // USERS
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // EVENTS
        Route::prefix('events')->as('events.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/{id}', [EventController::class, 'show'])->name('show');

            Route::prefix('{event_id}/sublomba')->as('sublomba.')->group(function () {
                Route::get('/', [SubLombaController::class, 'index'])->name('index');
                Route::get('/{id}/edit', [SubLombaController::class, 'edit'])->name('edit');
                Route::put('/{id}', [SubLombaController::class, 'update'])->name('update');
            });

            Route::prefix('{event_id}/participants')->as('participants.')->group(function () {
                Route::get('/', [PartisipanController::class, 'index'])->name('index');
                Route::get('/{id}', [PartisipanController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [PartisipanController::class, 'edit'])->name('edit');
                Route::put('/{id}', [PartisipanController::class, 'update'])->name('update');
            });
        });

        // ANNOUNCEMENTS
        Route::prefix('announcements')->as('announcements.')->group(function () {
            Route::get('/', [PengumumanController::class, 'index'])->name('index');
            Route::get('/create', [PengumumanController::class, 'create'])->name('create');
            Route::post('/', [PengumumanController::class, 'store'])->name('store');
            Route::get('/{id}', [PengumumanController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PengumumanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PengumumanController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengumumanController::class, 'destroy'])->name('destroy');
        });

        // RESULTS
        Route::prefix('results')->as('results.')->group(function () {
            Route::get('/', [HasilController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [HasilController::class, 'edit'])->name('edit');
            Route::put('/{id}', [HasilController::class, 'update'])->name('update');
        });

        // REPORTS
        Route::prefix('reports')->as('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/{id}', [ReportController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ReportController::class, 'update'])->name('update');
        });
    });

// ===================================
// FAVORITE ROUTES (Global - accessible to all authenticated users)
// ===================================
Route::middleware('auth')->group(function () {
    Route::post('/favorit', [FavoritController::class, 'store'])->name('favorit.store');
    Route::delete('/favorit/{events_id}', [FavoritController::class, 'destroy'])->name('favorit.destroy');
    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
});

// ===================================
// PARTICIPANT ROUTES
// ===================================
Route::middleware(['auth', 'participant'])
    ->prefix('participant')
    ->name('participant.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('competitions')->name('competitions.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/{competition}', [EventController::class, 'show'])->name('show');
            Route::get('/{competition}/register', [PartisipanController::class, 'register'])->name('register');
            Route::post('/{competition}/register', [PartisipanController::class, 'storeRegistration'])->name('register.store');
            Route::get('/{competition}/create', [PartisipanController::class, 'create'])->name('create');
            Route::post('/{competition}', [PartisipanController::class, 'store'])->name('store');
            Route::post('/{competition}/submit', [PartisipanController::class, 'submit'])->name('submit');
            Route::get('/{competition}/edit/{submission}', [PartisipanController::class, 'edit'])->name('edit');
            Route::put('/{competition}/update/{submission}', [PartisipanController::class, 'update'])->name('update');
            Route::delete('/{competition}/delete/{submission}', [PartisipanController::class, 'destroy'])->name('destroy');
            Route::get('/{competition}/announcement', [PengumumanController::class, 'announcement'])->name('announcement');
        });

        Route::prefix('results')->name('results.')->group(function () {
            Route::get('/', [HasilController::class, 'index'])->name('index');
            Route::get('/{competition}', [HasilController::class, 'show'])->name('show');
            Route::get('/certificates', [SertifikatController::class, 'certificates'])->name('certificates');
            Route::get('/certificates/{certificate}/download', [SertifikatController::class, 'downloadCertificate'])->name('certificates.download');
            Route::get('/certificates/{certificate}/preview', [HasilController::class, 'previewCertificate'])->name('certificates.preview');
        });

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotifikasiController::class, 'index'])->name('index');
            Route::post('/{notifikasi_id}/mark-as-read', [NotifikasiController::class, 'markAsRead'])->name('mark-as-read');
            Route::post('/mark-all-as-read', [NotifikasiController::class, 'markAllAsRead'])->name('mark-all-as-read');
            Route::delete('/{notifikasi_id}', [NotifikasiController::class, 'destroy'])->name('destroy');
            Route::delete('/delete-all', [NotifikasiController::class, 'destroyAll'])->name('destroy-all');
        });
        
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'profile'])->name('index');
            Route::put('/update', [AdminDashboardController::class, 'updateProfile'])->name('update');
            Route::put('/password', [AdminDashboardController::class, 'updatePassword'])->name('password');
        });

        Route::get('/profile/favorites', [FavoritController::class, 'index'])->name('favorites');

        // REPORTS (Participant CRUD)
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::get('/create', [LaporanController::class, 'create'])->name('create');
            Route::post('/', [LaporanController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [LaporanController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LaporanController::class, 'update'])->name('update');
            Route::delete('/{id}', [LaporanController::class, 'destroy'])->name('destroy');
        });
    });

// ===================================
// SHARED AUTH & PROFILE ROUTES (All roles)
// ===================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Shared profile routes for all authenticated users
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
