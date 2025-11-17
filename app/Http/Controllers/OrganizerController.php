<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Partisipan;
use App\Models\Pengumuman;
use App\Models\Hasil;
use App\Models\SubLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    public function dashboard()
    {
        $organizer_id = Auth::user()->user_id;

        // Total Events
        $totalEvent = Event::where('organizer_id', $organizer_id)->count();

        // Total Active Participants
        $pesertaAktif = Partisipan::whereHas('sublomba', function ($query) use ($organizer_id) {
            $query->whereHas('event', function ($q) use ($organizer_id) {
                $q->where('organizer_id', $organizer_id);
            });
        })->where('status', 'submitted')->count();

        // Total Announcements
        $pengumuman = Pengumuman::whereHas('event', function ($query) use ($organizer_id) {
            $query->where('organizer_id', $organizer_id);
        })->count();

        // Active Events (recent + upcoming)
        $eventAktif = Event::where('organizer_id', $organizer_id)
            ->where('status', 'active')
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();

        // Results Statistics
        $totalResults = Hasil::whereHas('partisipan.sublomba', function ($query) use ($organizer_id) {
            $query->whereHas('event', function ($q) use ($organizer_id) {
                $q->where('organizer_id', $organizer_id);
            });
        })->count();

        // Recent Announcements
        $recentAnnouncements = Pengumuman::whereHas('event', function ($query) use ($organizer_id) {
            $query->where('organizer_id', $organizer_id);
        })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Sub Lomba Count
        $totalSubLomba = SubLomba::whereHas('event', function ($query) use ($organizer_id) {
            $query->where('organizer_id', $organizer_id);
        })->count();

        // Top performing sub-lomba by participants
        $topSubLomba = SubLomba::whereHas('event', function ($query) use ($organizer_id) {
            $query->where('organizer_id', $organizer_id);
        })
            ->withCount(['partisipans'])
            ->orderBy('partisipans_count', 'desc')
            ->take(3)
            ->get();

        $data = compact(
            'totalEvent',
            'pesertaAktif',
            'pengumuman',
            'eventAktif',
            'totalResults',
            'recentAnnouncements',
            'totalSubLomba',
            'topSubLomba'
        );

        return view('organizer.dashboard', $data);
    }
}
