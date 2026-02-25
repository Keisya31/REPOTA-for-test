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
    <div class=" w-full max-w-[90vw] mb-10 sm:max-w-md lg:max-w-lg xl:max-w-xl 2xl:max-w-2xl bg-white rounded-xl p-[clamp(1.25rem,2vw,2.5rem)] shadow dark:border dark:bg-gray-800/80 dark:border-gray-700 items-center justify-center mx-auto">
        <div>
            <h2 class="font-bold text-lg text-gray-900">Edit Data Skripsi</h2>
        </div>
        <form action="{{ route("admin.tambah-skripsi.update", $skripsi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-6 mb-6 mt-6 md:grid-cols-2">
                <div>
                    <label for="nama_mhs" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nama Lengkap
                        <span class="text-red-700 !important">*</span> 
                    </label>
                    <input type="text" id="nama_mhs" name="nama_mhs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Lengkap" value = "{{ $skripsi->nama_mhs }}" required></input>
                </div>
                <div>
                    <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        NIM
                        <span class="text-red-700 !important">*</span> 
                    </label>
                    <input type="text" id="nim" name="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="NIM" value = "{{ $skripsi->nim_mhs }}" required></input>
                </div>
            </div>
            <div class="mb-6">
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Judul Skripsi
                    <span class="text-red-700 !important">*</span>
                </label>
                <input type="text" id="judul" name="judul"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Judul Skirpsi" value = "{{ $skripsi->judul }}" required></input>
            </div>  
            <div class="mb-6">
                <label for="abstrak" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Abstrak
                    <span class="text-red-700 !important">*</span>
                </label>
                <textarea id="abstrak" name="abstrak" rows="7" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>{{ old('abstrak', $skripsi->abstrak) }}</textarea>
            </div> 
            <div class="grid gap-6 mb-6 mt-6 md:grid-cols-2">
                <div>
                    <label for="tema" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tema Skripsi</label>
                    <select id="tema" name="tema" class="form-select text-sm font-medium bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 w-full p-2.5" required>
                        <option value="" disabled {{ old('tema') ? '' : 'selected' }}>--Pilih Tema Skripsi--</option>
                        <option value="siscer" {{ $skripsi->tema === 'siscer' ? 'selected' : '' }}>Sistem Cerdas</option>
                        <option value="rpl" {{ $skripsi->tema === 'rpl' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                        <option value="si" {{ $skripsi->tema === 'si' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option value="kv" {{ $skripsi->tema === 'kv' ? 'selected' : '' }}>Komputasi Visual</option>
                    </select>
                </div>
                <div>
                    <label for="tanggal_sidang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Tanggal Sidang
                        <span class="text-red-700 !important">*</span>
                    </label>
                    <input type="date" id="tanggal_sidang" name="tanggal_sidang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value = "{{ $skripsi->tanggal_sidang ? $skripsi->tanggal_sidang->format('Y-m-d') : '' }}"></input>
                </div>
                <div>
                    <label for="pembimbing_1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nama Pembimbing 1
                        <span class="text-red-700 !important">*</span>
                    </label>
                    <input type="text" id="pembimbing_1"  name="pembimbing_1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pembimbing 1" value="{{ $skripsi->pembimbing_1 }}" required></input>
                </div>
                <div>
                    <label for="pembimbing_2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Pembimbing 2</label>
                    <input type="text" id="pembimbing_2" name="pembimbing_2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pembimbing 2" value="{{ $skripsi->pembimbing_2 }}" required></input>
                </div>
            </div>
            <div class="mb-6">
               <label for="penguji" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Ketua Penguji</label>
                <input type="text" id="penguji" name="penguji" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#121435] focus:border-[#121435] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Penguji" value="{{ $skripsi->penguji_sidang }}" required></input>
            </div>
            
            <div class="flex items-center justify-center w-full">
                <label for="file_skripsi" 
                    id="drop-area-skripsi"
                    class="flex flex-col items-center justify-center w-full h-40 mb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    @if(isset($skripsi) && $skripsi->path_file)
                        {{-- file lama --}}
                        <div id="existing-file-skripsi" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-12 h-12 mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mb-1 text-sm font-semibold text-gray-700">
                                {{ basename($skripsi->path_file) }}
                            </p>
                            <button type="button" 
                                onclick="clearFile('skripsi')" 
                                class="mt-3 text-xs text-red-600 hover:text-red-800 underline"> Remove file </button>
                        </div>
                    @endif   
                        {{-- Default content (sebelum upload) --}}
                        <div id="default-content-skripsi" class=" {{ isset($skripsi) && $skripsi->path_file ? 'hidden' : 'flex' }} flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Click to upload Full File</span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PDF (MAX. 2MB)
                            </p>
                        </div>
                        {{-- File uploaded content (setelah pilih file) --}}
                        <div id="file-content-skripsi" class="hidden flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-12 h-12 mb-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300" id="file-name-skripsi">
                                <!-- Filename akan muncul di sini -->
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="file-size-skripsi">
                                <!-- File size akan muncul di sini -->
                            </p>
                            <button type="button" 
                                    onclick="clearFile('skripsi')" 
                                    class="mt-3 text-xs text-red-600 hover:text-red-800 underline">
                                Remove file
                            </button>
                        </div>
                    
                    <input id="file_skripsi" name="file_skripsi" type="file" class="hidden" accept=".pdf" onchange="handleFileSelect(this, 'skripsi')">
                </label>
                @error('file_skripsi')
                    <p class="text-red-500 text-sm -mt-4 mb-4">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-center w-full">
                <label for="file_depan" 
                    id="drop-area-depan"
                    class="flex flex-col items-center justify-center w-full h-40 mb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    @if(isset($skripsi) && $skripsi->path_hlm_depan)
                        {{-- file lama --}}
                        <div id="existing-file-depan" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-12 h-12 mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mb-1 text-sm font-semibold text-gray-700">
                                {{ basename($skripsi->path_hlm_depan) }}
                            </p>
                            
                            <button type="button" 
                                onclick="clearFile('depan')" 
                                class="mt-3 text-xs text-red-600 hover:text-red-800 underline">
                            Remove file
                            </button>
                        </div>
                     @endif   
                        {{-- Default content (sebelum upload) --}}
                        <div id="default-content-depan" class=" {{ isset($skripsi) && $skripsi->path_hlm_depan ? 'hidden' : 'flex' }} flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Click to upload Halaman Depan</span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PDF (MAX. 1MB)
                            </p>
                        </div>
                        {{-- File uploaded content (setelah pilih file) --}}
                        <div id="file-content-depan" class="hidden flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-12 h-12 mb-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300" id="file-name-depan">
                                <!-- Filename akan muncul di sini -->
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="file-size-depan">
                                <!-- File size akan muncul di sini -->
                            </p>
                            <button type="button" 
                                    onclick="clearFile('depan')" 
                                    class="mt-3 text-xs text-red-600 hover:text-red-800 underline">
                                Remove file
                            </button>
                        </div>
                    
                    <input id="file_depan" name="file_depan" type="file" class="hidden" accept=".pdf" onchange="handleFileSelect(this, 'depan')">
                </label>
                @error('file_depan')
                    <p class="text-red-500 text-sm -mt-4 mb-4">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-center w-full">
                <label for="file_bab1" 
                    id="drop-area-bab1"
                    class="flex flex-col items-center justify-center w-full h-40 mb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                    @if(isset($skripsi) && $skripsi->path_bab1)
                        {{-- file lama --}}
                        <div id="existing-file-bab1" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-12 h-12 mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mb-1 text-sm font-semibold text-gray-700">
                                {{ basename($skripsi->path_bab1) }}
                            </p>
                            
                            <button type="button" 
                                onclick="clearFile('bab1')" 
                                class="mt-3 text-xs text-red-600 hover:text-red-800 underline">
                            Remove file
                            </button>
                        </div>
                       
                     @endif   
                        {{-- Default content (sebelum upload) --}}
                        <div id="default-content-bab1" class=" {{ isset($skripsi) && $skripsi->path_bab1 ? 'hidden' : 'flex' }} flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Click to upload BAB 1</span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PDF (MAX. 1MB)
                            </p>
                        </div>
                        {{-- File uploaded content (setelah pilih file) --}}
                        <div id="file-content-bab1" class="hidden flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-12 h-12 mb-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mb-1 text-sm font-semibold text-gray-700 dark:text-gray-300" id="file-name-bab1">
                                <!-- Filename akan muncul di sini -->
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="file-size-bab1">
                                <!-- File size akan muncul di sini -->
                            </p>
                            <button type="button" 
                                    onclick="clearFile('bab1')" 
                                    class="mt-3 text-xs text-red-600 hover:text-red-800 underline">
                                Remove file
                            </button>
                        </div>
                    
                    <input id="file_bab1" name="file_bab1" type="file" class="hidden" accept=".pdf" onchange="handleFileSelect(this, 'bab1')">
                </label>
                @error('file_bab1')
                    <p class="text-red-500 text-sm -mt-4 mb-4">{{ $message }}</p>
                @enderror
            </div>

            <script>
            function handleFileSelect(input, suffix = '') {
                const file = input.files[0];
                
                if (file) {
                    // Hide default content
                    document.getElementById('default-content-' + suffix).classList.add('hidden');
                    document.getElementById('default-content-' + suffix).classList.remove('flex');
                    
                    // Show file content
                    document.getElementById('file-content-' + suffix).classList.remove('hidden');
                    document.getElementById('file-content-' + suffix).classList.add('flex');
                    
                    // Display file info
                    document.getElementById('file-name-' + suffix).textContent = file.name;
                    document.getElementById('file-size-' + suffix).textContent = formatFileSize(file.size);
                    
                    // Change border color to green
                    document.getElementById('drop-area-' + suffix).classList.add('border-green-500');
                    document.getElementById('drop-area-' + suffix).classList.remove('border-gray-300');
                }
            }

            function clearFile(suffix) {
                const existingFile = document.getElementById('existing-file-' + suffix);
                if (existingFile) {
                    existingFile.classList.add('hidden');
                }
                // Clear input
                document.getElementById('file_' + suffix).value = '';
                
                const defaultContent = document.getElementById('default-content-' + suffix);
                if (defaultContent) {
                    defaultContent.classList.remove('hidden');
                    defaultContent.classList.add('flex');
                }

                // Show default content
                document.getElementById('default-content-' + suffix).classList.remove('hidden');
                document.getElementById('default-content-' + suffix).classList.add('flex');
                
                // Hide file content
                document.getElementById('file-content-' + suffix).classList.add('hidden');
                document.getElementById('file-content-' + suffix).classList.remove('flex');
                
                // Reset border color
                document.getElementById('drop-area-' + suffix).classList.remove('border-green-500');
                document.getElementById('drop-area-' + suffix).classList.add('border-gray-300');
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            </script>

            <div class="w-full flex flex-col justify-center">
                <button type="submit" class="text-white bg-[#FF5722] hover:bg-orange-700 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 active:scale-95 transition-all duration-100">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>