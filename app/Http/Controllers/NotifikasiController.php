<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        // For participant route, show only their notifications
        if (request()->routeIs('participant.notifications.*')) {
            $notifikasi = Notifikasi::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            return view('participant.notifications', compact('notifikasi'));
        }
        
        // For admin/organizer, show all
        $notifikasi = Notifikasi::with('user')->get();
        return view('notifikasi.index', compact('notifikasi'));
    }

    public function create()
    {
        $users = User::all();
        return view('notifikasi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'judul' => 'required|string',
            'pesan' => 'required|string'
        ]);

        Notifikasi::create($request->all());
        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil dikirim');
    }

    public function destroy(Notifikasi $notifikasi)
    {
        $notifikasi->delete();
        return redirect()->route('notifikasi.index')->with('success', 'Notifikasi berhasil dihapus');
    }

    public function markAsRead($notification)
    {
        $notifikasi = Notifikasi::findOrFail($notification);
        
        // Check ownership for participants
        if (request()->routeIs('participant.notifications.*') && $notifikasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $notifikasi->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    public function destroyAll()
    {
        Notifikasi::where('user_id', Auth::id())->delete();
        
        return redirect()->route('participant.notifications.index')
            ->with('success', 'All notifications deleted.');
    }
}
