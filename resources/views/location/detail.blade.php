<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Detail Lokasi') }}
            </h2>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-room')"
                class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-200 dark:shadow-none transition-all duration-300 transform hover:scale-105">
                Edit Lokasi
            </button>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- area detail lokasi --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-md shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-2">{{ $location->name }}</h3>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mb-4">Penanggung Jawab:
                        {{ $location->user->name }}</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $location->description }}</p>
                </div>
            </div>


            <div
                class="bg-white dark:bg-slate-900 rounded-md shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Daftar Barang di Lokasi Ini
                    </h3>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mb-2">Jumlah Barang:
                        {{ $location->item_count }}</p>
                    <!-- Tambahkan tabel atau daftar barang di lokasi ini -->
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="text-slate-400 dark:text-slate-500 text-[10px] uppercase tracking-[0.2em] font-black bg-slate-50/50 dark:bg-slate-800/50">
                                <th class="px-8 py-5">Nama Lokasi & Nama Penanggung Jawab</th>
                                <th class="px-8 py-5">Jumlah Barang</th>
                                <th class="px-8 py-5 text-center">Tanggal Dibuat</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">




                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="create-room" :show="false" focusable>
        <div class="p-8 dark:bg-slate-900">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl font-black text-slate-800 dark:text-white">
                        Tambah Lokasi Baru
                    </h2>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Daftarkan lokasi baru</p>
                </div>
                <div class="p-3 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>

            <form method="post" action="{{ route('location.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="my-2">
                        <x-input-label for="nama_lokasi" :value="__('Nama Lokasi')" />
                        <x-text-input id="nama_lokasi" class="block mt-1 w-full" type="text" name="nama_lokasi"
                            :value="old('nama_lokasi')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('nama_lokasi')" class="mt-2" />
                    </div>

                    <div class="my-2">
                        <x-input-label for="petugas" :value="__('Petugas')" />
                        <select name="petugas" id="petugas"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Pilih Petugas</option>
                            @foreach ($petugas as $p)
                                <option value="{{ $p->id }}" {{ old('petugas') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('petugas')" class="mt-2" />
                    </div>
                </div>

                <div class="my-2">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea name="description" id="description"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>


                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-200 dark:shadow-none transition transform active:scale-95">
                        Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
