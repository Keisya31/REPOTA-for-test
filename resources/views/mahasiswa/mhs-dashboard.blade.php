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
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
            });
        </script>
    @endif
    
    <div>
        <h1 class="text-xl font-bold pb-3 text-[#121435] text-center">Skripsi Saya</h1>
    </div>
    <div>
        @if ($skripsi)
            <div class="flex gap-7">
                <div class="mb-5 pt-6">
                    <a href="{{ route('mhs.skripsi.edit', $skripsi->id) }}">
                        <button class="px-4 py-2 bg-[#0F172A] text-white rounded-lg text-sm hover:bg-[#3b3c51] active:scale-95 transition-all duration-100 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        Edit Skripsi
                        </button>
                    </a>   
                </div>
                <div  class="mb-5 pt-6">
                    <form id='delete-form-{{ $skripsi->id }}' method="POST" action="{{ route('mhs.skripsi.destroy', $skripsi->id) }}" class="px-2 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 active:scale-95 transition-all duration-100 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $skripsi->id }})">
                            Hapus</button>
                    </form> 
                </div>
                {{-- Pop up dialog untuk hapus --}}
                <script>
                    function confirmDelete(id) {
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Data skripsi akan dihapus secara permanen!",
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
            </div>
            <div class="flex mt-7  pb-5 gap-7 rounded-lg">
                <div class="bg-orange-500 pt-3 relative overflow-x-auto w-full sm:rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 transform">
                    <table class="w-full text-sm rounded-lg text-left text-gray-500 dark:text-gray-400">
                        <tbody>
                            <tr class="border-b">
                                <th class="px-6 py-2 bg-gray-100 font-bold">Judul Skripsi</th>
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->judul }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-1 bg-gray-100">Status</th>
                                <td class="px-6 py-1 flex flex-row  gap-2 font-medium text-gray-900 dark:text-white bg-white">Uploaded
                                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-green-500">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-1 bg-gray-100">Tanggal Sidang</th>
                                
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->tanggal_sidang->format('d-m-Y') }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-1 w-36 bg-gray-100">Dosen Pembimbing 1</th>
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->pembimbing_1 }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-1 w-36 bg-gray-100">Dosen Pembimbing 2</th>
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->pembimbing_2 }}</td>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-1 w-36 bg-gray-100">Ketua Dosen Penguji</th>
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->penguji_sidang }}</td>
                            </tr>
                            
                            <tr class="border-b">
                                <th scope="col" class="px-6 py-1 bg-gray-100">Tema Skripsi</th>
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->tema }}</td>
                            </tr>
                            <tr class="border-b">
                                <th scope="col" class="px-6 py-3 bg-gray-100">Abstrak</th>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->abstrak }}</td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
                <div class="bg-white h-1/2 w-auto sm:rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                    <h2 class="text-base font-bold p-3 border-b border-gray-200">DETAIL:</h2>
                        <table class="w-full text-sm rounded-lg text-left text-gray-500 dark:text-gray-400">
                            <tbody>
                                <tr class="border-b">
                                    <th class="px-6 py-1 bg-gray-100">Nama Mahasiswa</th>
                                    <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->nama_mhs }}</td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-1 bg-gray-100">NIM</th>
                                    <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->nim_mhs }}</td>
                                </tr>
                                <tr class="border-b">
                                <th class="px-6 py-1 bg-gray-100">Tanggal Upload</th>
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white">{{ $skripsi->created_at->format('d-m-Y') }}</td>
                                </tr>
                                <tr class="border-b">
                                <th class="px-6 py-1 bg-gray-100">Halaman Depan </th>
                                <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white pb-3">
                                    @if ($skripsi->path_hlm_depan)
                                        {{ basename($skripsi->path_hlm_depan) }}
                                        <a href="{{ route('mhs.skripsi.download-hlm-depan', $skripsi->id) }}" class="text-blue-500 hover:underline ml-3">Download File</a>
                                    @else
                                        Tidak ada file
                                    @endif
                                </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-1 bg-gray-100">BAB 1</th>
                                    <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white pb-3">
                                        @if ($skripsi->path_bab1)
                                            {{ basename($skripsi->path_bab1) }}
                                            <a href="{{ route('mhs.skripsi.download-bab1', $skripsi->id) }}" class="text-blue-500 hover:underline ml-3">Download File</a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <th class="px-6 py-1 bg-gray-100">Full File</th>
                                    <td class="px-6 py-1 font-medium text-gray-900 dark:text-white bg-white pb-3">
                                        @if ($skripsi->path_file)
                                            {{ basename($skripsi->path_file) }}
                                            <a href="{{ route('mhs.skripsi.download', $skripsi->id) }}" class="text-blue-500 hover:underline ml-3">Download File</a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    
                </div>
            </div>
        @else
            <div class="flex item-center justify-center w-full min-h-60">    
                <div class="bg-white w-full p-10 max-w-2xl mt-10 rounded-lg shadow-lg hover:shadow-2xl transition-all hover:-translate-y-2 ">
                    <div class="flex flex-col items-center justify-center">
                        <p class="text-gray-500 pb-7 font-medium">Belum ada data skripsi. Silakan tambahkan skripsi baru.</p>
                        <a href="{{ route('mhs.skripsi.create') }}">
                            <button class="px-4 py-2 bg-[#0F172A] text-white rounded-lg text-sm hover:bg-[#3b3c51] active:scale-95 transition-all duration-100 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            Tambah Skripsi
                            </button>
                        </a>   
                        
                    </div>
                </div>
            </div>
        @endif
    </div>

    
</x-app-layout>