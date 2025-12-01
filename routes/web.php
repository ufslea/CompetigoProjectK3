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
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

        // SUB-LOMBA
        Route::get('/events/{event_id}/sublomba', [SubLombaController::class, 'index'])->name('sublomba.index');
        Route::get('/events/{event_id}/sublomba/create', [SubLombaController::class, 'create'])->name('sublomba.create');
        Route::post('/events/{event_id}/sublomba', [SubLombaController::class, 'store'])->name('sublomba.store');
        Route::get('/sublomba/{id}/edit', [SubLombaController::class, 'edit'])->name('sublomba.edit');
        Route::put('/sublomba/{id}', [SubLombaController::class, 'update'])->name('sublomba.update');
        Route::delete('/sublomba/{id}', [SubLombaController::class, 'destroy'])->name('sublomba.destroy');

        // PARTICIPANTS
        Route::get('/participants', [PartisipanController::class, 'index'])->name('participants.index');
        Route::get('/participants/{id}', [PartisipanController::class, 'show'])->name('participants.show');

        // ANNOUNCEMENTS
        Route::get('/announcements', [PengumumanController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [PengumumanController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [PengumumanController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{id}', [PengumumanController::class, 'show'])->name('announcements.show');
        Route::get('/announcements/{id}/edit', [PengumumanController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{id}', [PengumumanController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{id}', [PengumumanController::class, 'destroy'])->name('announcements.destroy');

        // RESULTS
        Route::get('/results', [HasilController::class, 'index'])->name('results.index');
        Route::get('/results/create', [HasilController::class, 'create'])->name('results.create');
        Route::post('/results', [HasilController::class, 'store'])->name('results.store');
        Route::get('/results/{id}/edit', [HasilController::class, 'edit'])->name('results.edit');
        Route::put('/results/{id}', [HasilController::class, 'update'])->name('results.update');

        // USER PROFILE
        Route::get('/profile', [OrganizerProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [OrganizerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [OrganizerProfileController::class, 'update'])->name('profile.update');
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
            Route::post('/{notification}/mark-as-read', [NotifikasiController::class, 'markAsRead'])->name('mark-as-read');
            Route::post('/mark-all-as-read', [NotifikasiController::class, 'markAllAsRead'])->name('mark-all-as-read');
            Route::delete('/{notification}/delete', [NotifikasiController::class, 'destroy'])->name('destroy');
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
// AUTH & PROFILE ROUTES
// ===================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
