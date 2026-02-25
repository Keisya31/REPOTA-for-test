<x-app-layout>
    <div class="min-h-12 flex flex-col items-center justify-center" style = "background-color: #FAF9F0">              
        <div class="flex items-center">
            <svg class="w-12 h-12 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7.833 2c-.507 0-.98.216-1.318.576A1.92 1.92 0 0 0 6 3.89V21a1 1 0 0 0 1.625.78L12 18.28l4.375 3.5A1 1 0 0 0 18 21V3.889c0-.481-.178-.954-.515-1.313A1.808 1.808 0 0 0 16.167 2H7.833Z"/>
            </svg>
            <div class="text-center mt-7 mb-10">
                <h1 class="font-bold text-center text-2xl pb-5">GET SOME REFERENCES AND INSIGHT HERE!!</h1>
                <h3 class="font-normal text-center text-base">Cari skripsi kakak tingkat, cari referensi, cari topik di REPOTA aja</h3>
            </div>
        </div>
        <div class="flex items-start mt-5">
           <img src="{{ asset('images/logo-if.png') }}" alt="Logo IF" class="h-16 w-auto mr-4">
            <form action="{{ route('base') }}" method="GET">
                <div class="flex items-center justify-start ">
                    <input type="text" name="search" class="h-12 w-96 shadow-inner px-4 text-gray-500 text-sm border border-gray-500 rounded-l-xl bg-transparent focus:outline-none focus:border-blue-500" placeholder="Masukkan kata kunci..."  value="{{ $query ?? '' }}" required>
                    <button class="h-12 px-4 bg-gray-700 text-white rounded-r-xl text-sm hover:bg-indigo-600 transition" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-7 mb-2">
            @if($query)
                @if($results->isNotEmpty())
                    <div class="flex justify-between items-center mb-3">
                        <h5 class="mt-7 mb-1">Ditemukan <strong>{{ count($results) }}</strong> dokumen relevan</h5>
                    </div>

                    @foreach($results as $skripsi)
                        <div class="mb-4 px-4 border-2 rounded-md shadow-sm bg-white hover:bg-blue-50 transform transition hover:-translate-y-0.5 hover:border-l-4 hover:border-blue-600">
                            <div class="py-3">
                                <div class="flex justify-between">
                                    <h5>
                                        <a href="{{ route('detail.skripsi', $skripsi->id) }}" class="font-bold text-xl text-blue-800 underline hover:text-blue-600">
                                            {{ $skripsi->judul }}
                                        </a>
                                    </h5>
                                    {{-- <span class="badge bg-success align-self-start" title="Cosine Similarity Score">
                                        Skor: {{ number_format($skripsi->score, 4) }}
                                    </span> --}}
                                </div>
                                <p class="text-sm text-green-500 ">{{ $skripsi->nama_mhs }}</p>
                                
                                <p class="text-gray-600 mt-2">
                                    {{ Str::limit($skripsi->abstrak, 200) }}
                                </p>
                                
                                <div class="flex justify-between items-center mt-3 mb-3">
                                    <a href="{{ route("forum.skripsi", $skripsi->id) }}" class="bg-orange-400 hover:bg-orange-500 rounded-md px-2 py-1 text-white text-sm">Diskusikan Topik</a>
                                </div>
                            </div>
                        </div>
                    @endforeach 
                @else
                    <div class="alert alert-warning text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i><br>
                        Maaf, tidak ditemukan dokumen yang cocok dengan kata kunci "<strong>{{ $query }}</strong>".
                        <br>Coba gunakan kata kunci yang lebih umum.
                    </div>        
                @endif
            @endif
        </div>
    </div>


</x-app-layout>