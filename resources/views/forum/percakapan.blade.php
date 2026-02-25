<x-app-layout>
    <div class="min-h-screen py-12 px-4" style="background-color: #FAF9F0">
        {{-- Header --}}
        <div class="max-w-7xl mx-auto text-center mb-10">
            <div class="flex items-center justify-center gap-4 mb-4">
                <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4 3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h1v2a1 1 0 0 0 1.707.707L9.414 13H15a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4Z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M8.023 17.215c.033-.03.066-.062.098-.094L10.243 15H15a3 3 0 0 0 3-3V8h2a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-1v2a1 1 0 0 1-1.707.707L14.586 18H9a1 1 0 0 1-.977-.785Z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">FORUM DISKUSI REPOTA</h1>
                    <p class="text-gray-600 mt-2">Berdiskusi Bersama Mahasiswa di Sini</p>
                </div>
            </div>
        </div>

        {{-- Forum Rooms Grid --}}
        <div class="max-w-7xl mx-auto">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">All Rooms</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Main Room Card --}}
                <a href="{{ route('forum.utama') }}" class="block group">
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6 border-l-4 border-blue-500">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-blue-600 group-hover:text-blue-700">
                                    Main Room
                                </h3>
                                <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                                    Last message {{ $mainThread ? $mainThread->created_at->diffForHumans() : 'No messages yet' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-blue-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a1 1 0 01-1-1V6a1 1 0 011-1h14a1 1 0 011 1v9a1 1 0 01-1 1h-4l-4 4v-4z"/>
                                </svg>
                                <span class="text-2xl font-bold">{{ $mainThreadCount }}</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">
                            Room ini berisi diskusi umum dan topik bebas terkait skripsi
                        </p>
                    </div>
                </a>

                {{-- Skripsi Topic Rooms --}}
                @forelse($rooms as $room)
                    <a href="{{ route('forum.skripsi', $room['skripsi']->id) }}" class="block group">
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 p-6 border-l-4 border-indigo-500">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1 pr-4">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 line-clamp-2 mb-2">
                                        {{ $room['skripsi']->judul }}
                                    </h3>
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                                        Last message {{ $room['last_message']->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-indigo-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a1 1 0 01-1-1V6a1 1 0 011-1h14a1 1 0 011 1v9a1 1 0 01-1 1h-4l-4 4v-4z"/>
                                    </svg>
                                    <span class="text-2xl font-bold">{{ $room['message_count'] }}</span>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2">
                                Room ini berisi diskusi terkait topik {{ $room['skripsi']->judul }}
                            </p>
                        </div>
                    </a>
                @empty
                    {{-- Kalau belum ada room skripsi --}}
                    
                @endforelse
            </div>

            {{-- Empty State (kalau cuma Main Room) --}}
            @if(count($rooms) === 0)
                <div class="mt-10 text-center py-12 bg-white rounded-xl shadow-md">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">
                        Belum Ada Diskusi Topik Skripsi
                    </h3>
                    <p class="text-gray-500 mb-6">
                        Mulai diskusi dengan mencari skripsi dan klik "Diskusikan Topik"
                    </p>
                    <a href="{{ route('base') }}" class="inline-block px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        Cari Skripsi
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>