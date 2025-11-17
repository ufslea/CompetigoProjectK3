@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Daftar Peserta</h1>
            <p class="text-gray-600 mt-2">Kelola dan lihat detail semua peserta kompetisi Anda</p>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="h-5 w-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Empty State --}}
        @if($participants->isEmpty())
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M7.485 9.75H4.5A2.25 2.25 0 002.25 12v0a2.25 2.25 0 002.25 2.25h2.985m0 0a4 4 0 110-8.048m0 8.048h3.985A2.25 2.25 0 0019.5 12v0a2.25 2.25 0 00-2.25-2.25h-2.985m0-8.048v.005"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada peserta</h3>
                <p class="mt-2 text-sm text-gray-600">Peserta akan muncul di sini setelah melakukan registrasi.</p>
            </div>
        @else
            {{-- Participants Table --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Peserta</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Sub Lomba</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Institusi</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($participants as $participant)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $participant->user->nama ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600">{{ $participant->user->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">{{ $participant->sublomba->nama ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">{{ $participant->sublomba->event->nama ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600">{{ $participant->institusi ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $participant->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                               ($participant->status == 'rejected' ? 'bg-red-100 text-red-800' : 
                                               ($participant->status == 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($participant->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('organizer.participants.show', $participant->partisipan_id) }}"
                                           class="inline-flex items-center px-3 py-1 text-sm text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded transition">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

@include('components.footer')
@endsection
