<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Tempat Sampah Lokasi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-slate-900 rounded-md shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="text-slate-400 dark:text-slate-500 text-[10px] uppercase tracking-[0.2em] font-black bg-slate-50/50 dark:bg-slate-800/50">
                                <th class="px-8 py-5">Nama Lokasi & Nama Penanggung Jawab</th>
                                <th class="px-8 py-5">Jumlah Barang</th>
                                <th class="px-8 py-5 text-center">Tanggal Dihapus</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">

                            @forelse ($locations as $location)
                                <tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-slate-700 dark:text-slate-200 text-sm">
                                            {{ $location->name }}</div>
                                        <div class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 tracking-wider">
                                            {{ $location->user->name }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span
                                            class="text-sm text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg">
                                            {{ $location->item_count }} Barang
                                        </span>
                                    </td>
                                    <td
                                        class="px-8 py-6 text-center font-bold text-slate-700 dark:text-slate-300 text-sm">
                                        {{ $location->deleted_at->diffForHumans() }}
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        {{-- mengembalikan lokasi --}}
                                        <form action="" method="post">
                                            <button type="submit" class="text-green-600 dark:text-gray-200 text-sm text-bold">Kembalikan</button>
                                        </form>
                                        <form action="" method="post">
                                            <button type="submit" class="text-red-600 text-sm text-bold">Hapus Permanen

                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors">
                                    <td colspan="4" class="px-8 py-6 text-center text-slate-400 dark:text-slate-500">
                                        Tidak ada lokasi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
