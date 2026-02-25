<x-app-layout>
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ $message }}',
            });
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ Session::get('error') }}',
            });
        </script>
    @endif
    
    <div>
        <h1 class="text-xl font-bold pb-3 text-[#121435] text-center">Kelola Skripsi Mahasiswa</h1>
    </div>
    <div class="flex justify-between">
        <div class="mb-5 pt-6">
            <a href="{{ route('admin.tambah-skripsi.create') }}">
                <button class="px-4 py-2 bg-gradient-to-r bg-[#0F172A] text-white rounded-lg text-sm hover:bg-[#3b3c51] active:scale-95 transition-all duration-100 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                Tambah Skripsi
                </button>
            </a>
        </div>
        <div class="flex items-start gap-2 mb-2 pt-6">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="w-full">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari " 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-[#FF5722] focus:border-[#FF5722]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- tabel  --}}
    <div class="relative overflow-x-auto sm:rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 transform">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase font-bold bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">NO</th>
                    <th scope="col" class="px-6 py-3">NIM</th>
                    <th scope="col" class="px-6 py-3 ">NAMA MAHASISWA</th>
                    <th scope="col" class="px-6 py-3">JUDUL</th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Detail</span>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse ($skripsi as $index => $s)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $skripsi->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $s->nim_mhs }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $s->nama_mhs }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $s->judul }}
                        </td>
                        <td class="px-6 py-4">
                            <button class="active:scale-95 transition-all duration-100 "> 
                                <a href="{{ route('admin.detail-skripsi.show', $s->id) }}" class="px-3 py-2 bg-white border border-[#FF5722] text-[#FF5722] hover:bg-[#FF5722] hover:text-white rounded-lg text-sm">Detail</a>
                            </button>
                            {{-- <button class="active:scale-95 transition-all duration-100 "> 
                                <a href="{{ route('admin.detail-skripsi.show', $s->id) }}" class="px-3 py-2 bg-white border border-[#FF5722] text-[#FF5722] hover:bg-[#FF5722] hover:text-white rounded-lg text-sm" onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'detail-{{ $s->id }}' }))">Detail</a>
                            </button> --}}
                            
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button id="actions-dropdown-button-{{ $s->id }}" data-dropdown-toggle="actions-dropdown-{{ $s->id }}" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div id="actions-dropdown-{{ $s->id }}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actions-dropdown-button-{{ $s->id }}">
                                    <li>
                                        <a href="{{ route("admin.tambah-skripsi.edit", $s->id) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-start">Edit</a>
                                    </li>
                                    <li>
                                        <form id='delete-form-{{ $s->id }}' method="POST" action="{{ route('admin.tambah-skripsi.destroy', $s->id) }}"  class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-start">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $s->id }})" class="w-full text-start hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                Hapus</button>
                                        </form>
                                    </li>
                                     
                                </ul>
                            </div>
                        </td>
                    </tr>

                    {{-- {{-- Detail modal for this skripsi --}}
                    {{-- <x-modal name="detail-{{ $s->id }}" :show="false" maxWidth="2xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Detail Skripsi</h3>
                                <button type="button" class="text-gray-500 hover:text-gray-700" onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'detail-{{ $s->id }}' }))">Tutup</button>
                            </div>

                            <div class="space-y-3">
                                <p><strong>NIM:</strong> {{ $s->mahasiswa->nim }}</p>
                                <p><strong>Nama:</strong> {{ $s->mahasiswa->mhs_nama }}</p>
                                <p><strong>Judul:</strong> {{ $s->judul }}</p>
                                <p><strong>Tema:</strong> {{ $s->tema ?? '-' }}</p>
                                <p><strong>Tanggal Upload:</strong> {{ optional($s->created_at)->format('d-m-Y') ?? '-' }}</p>
                                <div>
                                    <strong>Abstrak:</strong>
                                    <p class="mt-2 text-sm text-gray-700">{{ $s->abstrak }}</p>
                                </div>
                                <div>
                                    <strong>File:</strong>
                                    @if ($s->path_file)
                                        <a href="{{ asset('storage/' . $s->path_file) }}" class="text-blue-600 hover:underline" target="_blank" download>Download File</a>
                                    @else
                                        <span>Tidak ada file</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </x-modal> --}}
                  
                @empty
                <tr>
                    <td colspan="10" class="bg-white border-b mb-3 text-center align-middle h-20">Tidak ada data skripsi </td>    
                </tr>
                @endforelse
            </tbody>
            {{-- Pop up dialog untuk hapus --}}
            <script>
                function confirmDelete(id) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data skripsi akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
                }
            </script>
        </table>
        
    </div>
    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4">
        <span class="text-sm font-normal text-gray-500">
            Showing 
            <span class="font-semibold text-gray-900">
                {{ $skripsi->firstItem() }}-{{ $skripsi->lastItem() }} 
            </span>
            of
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ $skripsi->total() }}
            </span>
        </span>
        
        @if ($skripsi->hasPages())
        <ul class="inline-flex items-stretch -space-x-px">
            <!-- Previous Page Link -->
            <li>
                <a href="{{ $skripsi->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-900 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 {{ $skripsi->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                    <span class="sr-only">Previous</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" />
                    </svg>
                </a>
            </li>

            <!-- Pagination Links -->
            @foreach ($skripsi->getUrlRange(1, $skripsi->lastPage()) as $page => $url)
                @if ($page == 1 || $page == $skripsi->lastPage() || ($page >= $skripsi->currentPage() - 1 && $page <= $skripsi->currentPage() + 1))
                    <li>
                        <a href="{{ $url }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                        class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 
                        {{ $skripsi->currentPage() == $page ? 'z-10 text-primary-900 font-bold bg-primary-50 border-primary-300' : '' }}">
                            {{ $page }}
                        </a>
                    </li>
                @elseif ($page == $skripsi->currentPage() - 2 || $page == $skripsi->currentPage() + 2)
                    <li>
                        <span class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300">...</span>
                    </li>
                @endif
            @endforeach

            <!-- Next Page Link -->
            <li>
                <a href="{{ $skripsi->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-900 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 {{ !$skripsi->hasMorePages() ? 'cursor-not-allowed opacity-50' : '' }}">
                    <span class="sr-only">Next</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
                    </svg>
                </a>
            </li>
        </ul>
        @endif
    </nav>
</x-app-layout>