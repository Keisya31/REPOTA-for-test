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
        <h1 class="text-xl font-bold pb-3 text-[#121435] text-center">Kelola Data Mahasiswa</h1>
    </div>
    <div class="flex justify-between mb-2">
        <div class="mb-2 pt-6">
            <form action="{{ route('admin.kelola-mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="file_mahasiswa" class="cursor-pointer">
                    <div id="drop-area" class="px-4 py-4 bg-white text-gray-700 outline-dashed outline-2 outline-orange-300 rounded-lg text-sm hover:bg-orange-200 hover:text-white shadow-md flex items-center justify-center">
                        <div id="default-content" class="flex flex-row items-center justify-center gap-1">
                            <svg class="w-6 h-6 text-orange-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-4m5-13v4a1 1 0 0 1-1 1H5m0 6h9m0 0-2-2m2 2-2 2"/>
                            </svg>
                            <p class="text-gray-500">Tambah File Excel di sini (.xlsx, .xls)</p>
                        </div>
                        <div id="file-content" class="hidden flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z"></path></svg>
                            <p id="file-name" class="font-medium text-gray-700"></p>
                            <p id="file-size" class="text-xs text-gray-500"></p>
                        </div>
                    </div>
                </label>

                <input id="file_mahasiswa" name="file_mahasiswa" type="file" class="hidden" accept=".xlsx,.xls" onchange="handleFileSelect(this)">

                <div id="action-buttons" class="hidden mt-4 flex justify-center gap-3">
                    <button type="submit" class="bg-green-500 text-white hover:bg-green-600 rounded-lg px-2 py-2 text-sm font-semibold shadow-md active:scale-95 transition-all">
                        Unggah file
                    </button>
                    <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-800 text-sm underline">
                        Remove file
                    </button>
                </div>

                @error('file_mahasiswa')
                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                @enderror
                <script>
                function handleFileSelect(input) {
                    const file = input.files[0];
                    if (file) {
                        document.getElementById('default-content').classList.add('hidden');
                        document.getElementById('file-content').classList.remove('hidden');
                        document.getElementById('action-buttons').classList.remove('hidden'); // Tampilkan tombol
                        
                        document.getElementById('file-name').textContent = file.name;
                        document.getElementById('file-size').textContent = formatFileSize(file.size);
                    }
                }

                function clearFile() {
                    document.getElementById('file_mahasiswa').value = '';
                    document.getElementById('default-content').classList.remove('hidden');
                    document.getElementById('file-content').classList.add('hidden');
                    document.getElementById('action-buttons').classList.add('hidden'); // Sembunyikan tombol
                }

                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                }
                </script>
            </form>
        </div>
        <div class="flex items-start gap-2 mb-2 pt-6">
            <form action="{{ route('admin.kelola-mahasiswa') }}" method="GET" class="w-full">
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
        <div class="flex items-end pb-1 mb-2 pt-6">
            <form id="deleteAllForm" action="{{ route('admin.kelola-mahasiswa.destroy-all') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="confirmDeleteAll()" class="px-4 py-2 bg-red-600 text-white outline outline-red-700 rounded-lg text-sm hover:bg-red-700 hover:text-white shadow-md transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Kosongkan Daftar Mahasiswa
                </button>
                <script>
                    function confirmDeleteAll() {
                        Swal.fire({
                            title: 'Kosongkan Semua Data?',
                            text: "Seluruh daftar mahasiswa akan dihapus. Aksi ini digunakan untuk meriset data tahun ajaran!",
                            icon: 'error',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Kosongkan Semua!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('deleteAllForm').submit();
                            }
                        });
                    }
                </script>   
            </form>
        </div>
    </div>
    
    {{-- tabel --}}
   <div class="relative overflow-x-auto sm:rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 transform">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase font-bold bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">NO</th>
                    <th scope="col" class="px-6 py-3">NIM</th>
                    <th scope="col" class="px-6 py-3">NAMA MAHASISWA</th>
                    <th scope="col" class="px-6 py-3">STATUS</th>
                    <th scope="col" class="px-6 py-3">SEMESTER</th>
                    <th scope="col" class="px-6 py-3">KELAS</th>
                    <th scope="col" class="px-6 py-3">AKUN</th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Hapus</span>
                    </th>
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse ($mahasiswa as $index => $mhs)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $mahasiswa->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $mhs->nim }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $mhs->mhs_nama }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $mhs->status }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $mhs->semester }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $mhs->kelas }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($mhs->user)
                                <p class="text-green-500 font-medium">Akun Terdaftar</p>
                            @else
                               <p class="text-gray-400">Belum Ada Akun</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">                       
                            <form id='delete-form-{{ $mhs->nim }}' method="POST" action="{{ route('admin.kelola-mahasiswa.destroy', $mhs->nim) }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $mhs->nim }}')" class="w-full px-3 py-1 rounded-lg text-center bg-red-100 hover:bg-red-600 text-red-600 active:scale-95 transition-all duration-100 dark:hover:bg-gray-600 dark:hover:text-white hover:text-white flex gap-2">
                                   <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus</button>
                            </form>                        
                                                
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="10" class="bg-white border-b mb-3 text-center align-middle h-20">Tidak ada data mahasiswa </td>    
                </tr>
                @endforelse
            </tbody>
            {{-- Pop up dialog untuk hapus --}}
            <script>
                function confirmDelete(nim) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data mahasiswa akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + nim).submit();
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
                {{ $mahasiswa->firstItem() }}-{{ $mahasiswa->lastItem() }} 
            </span>
            of
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ $mahasiswa->total() }}
            </span>
        </span>

        @if ($mahasiswa->hasPages())
        <ul class="inline-flex items-stretch -space-x-px">
            <!-- Previous Page Link -->
            <li>
                <a href="{{ $mahasiswa->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-900 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 {{ $mahasiswa->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                    <span class="sr-only">Previous</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" />
                    </svg>
                </a>
            </li>

            <!-- Pagination Links -->
            @foreach ($mahasiswa->getUrlRange(1, $mahasiswa->lastPage()) as $page => $url)
                @if ($page == 1 || $page == $mahasiswa->lastPage() || ($page >= $mahasiswa->currentPage() - 1 && $page <= $mahasiswa->currentPage() + 1))
                    <li>
                        <a href="{{ $url }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                        class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 
                        {{ $mahasiswa->currentPage() == $page ? 'z-10 text-primary-900 font-bold bg-primary-50 border-primary-300' : '' }}">
                            {{ $page }}
                        </a>
                    </li>
                @elseif ($page == $mahasiswa->currentPage() - 2 || $page == $mahasiswa->currentPage() + 2)
                    <li>
                        <span class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300">...</span>
                    </li>
                @endif
            @endforeach

            <!-- Next Page Link -->
            <li>
                <a href="{{ $mahasiswa->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('months') ? '&months=' . request('months') : '' }}{{ request('year') ? '&year=' . request('year') : '' }}" 
                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-900 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 {{ !$mahasiswa->hasMorePages() ? 'cursor-not-allowed opacity-50' : '' }}">
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