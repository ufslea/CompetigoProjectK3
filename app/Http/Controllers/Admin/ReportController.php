<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with(['pelapor', 'event'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.reports.index', compact('laporans'));
    }

    public function edit($laporan_id)
    {
        $report = Laporan::with(['pelapor', 'event'])->findOrFail($laporan_id);
        return view('admin.reports.edit', compact('report'));
    }

    public function update(Request $request, $laporan_id)
    {
        $report = Laporan::findOrFail($laporan_id);
        
        $validated = $request->validate([
            'status'     => 'required|in:pending,processed,finished,refused',
            'tanggapan'  => 'nullable|string|max:2000',
        ]);

        $report->update($validated);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function show($laporan_id)
    {
        $laporan = Laporan::with(['pelapor', 'event'])->findOrFail($laporan_id);
        return view('admin.reports.show', compact('laporan'));
    }
}

