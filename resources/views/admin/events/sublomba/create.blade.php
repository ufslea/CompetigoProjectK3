@extends('layouts.admin')

@section('content')
<div class="flex">
    @include('components.sidebar-admin')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <h1 class="text-2xl font-bold text-[#1D3557] mb-6">Tambah Sub Lomba</h1>

        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('admin.events.sublomba.store', $event->events_id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Nama Sub Lomba</label>
                    <input type="text" name="nama"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('nama') border-red-500 @enderror"
                           value="{{ old('nama') }}"
                           required>
                    @error('nama')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Kategori</label>
                    <input type="text" name="kategori"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('kategori') border-red-500 @enderror"
                           value="{{ old('kategori') }}"
                           required>
                    @error('kategori')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Deskripsi</label>
                    <textarea name="deskripsi"
                              class="w-full p-3 border rounded h-32 focus:ring-[#1D3557] @error('deskripsi') border-red-500 @enderror"
                              required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Link</label>
                    <input type="url" name="link"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('link') border-red-500 @enderror"
                           value="{{ old('link') }}"
                           placeholder="https://example.com">
                    @error('link')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Deadline</label>
                    <input type="date" name="deadline"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('deadline') border-red-500 @enderror"
                           value="{{ old('deadline') }}"
                           required>
                    @error('deadline')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Status</label>
                    <select name="status"
                            class="w-full p-3 border rounded focus:ring-[#1D3557] @error('status') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Status --</option>
                        <option value="open" @selected(old('status') == 'open')>Open</option>
                        <option value="closed" @selected(old('status') == 'closed')>Closed</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Jenis Sub Lomba</label>
                    <div class="flex gap-6 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_sublomba" value="gratis"
                                   @checked(old('jenis_sublomba') == 'gratis' || !old('jenis_sublomba'))
                                   class="w-4 h-4">
                            <span class="text-gray-700">Gratis</span>
                            <span class="text-xs text-gray-500">(Perlu bukti follow sosmed)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_sublomba" value="berbayar"
                                   @checked(old('jenis_sublomba') == 'berbayar')
                                   class="w-4 h-4">
                            <span class="text-gray-700">Berbayar</span>
                            <span class="text-xs text-gray-500">(Perlu bukti pembayaran)</span>
                        </label>
                    </div>
                    @error('jenis_sublomba')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Requirement Submission</label>
                    <div class="flex gap-6 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="requires_submission" value="1"
                                   @checked(old('requires_submission', '1') == '1')
                                   class="w-4 h-4">
                            <span class="text-gray-700">Wajib Submit Karya</span>
                            <span class="text-xs text-gray-500">(Peserta harus upload karya)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="requires_submission" value="0"
                                   @checked(old('requires_submission') == '0')
                                   class="w-4 h-4">
                            <span class="text-gray-700">Hanya Registrasi</span>
                            <span class="text-xs text-gray-500">(Tidak perlu submit karya)</span>
                        </label>
                    </div>
                    @error('requires_submission')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.events.show', $event->events_id) }}"
                       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-[#1D3557] text-white rounded hover:bg-[#457B9D] transition">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@include('components.footer')
@endsection
