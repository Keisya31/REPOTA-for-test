<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="relative flex items-center justify-center mb-14">
            <button class="absolute left-0 text-sm font-medium text-gray-600 hover:text-black transition">
                <a href="{{ route("forum.utama") }}" class="mr-1"> < Kembali</a>
            </button>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">FORUM DISKUSI:BALASAN</h1>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 bg-[#F2F1E1] rounded-lg overflow-hidden shadow-sm min-h-[600px]">  
            <div class="flex-1 flex flex-col">
                <div class="flex-1 p-6 space-y-3 overflow-y-auto">
                    
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0"></div> <div class="flex-1">
                            <div class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-orange-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="font-bold text-sm">{{ $thread->nama_pengirim }}</span>
                                <span class="font-bold text-xs">{{ $thread->created_at->format('d-m-Y H:i') }}</span>
                            </div>
                            <div class="mt-1 bg-white border-2 border-black p-3 ml-10 relative shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                                <p class="text-gray-800">{{ $thread->isi_pesan }}</p>
                            </div>
                        </div>
                    </div>

                    @foreach($replies as $r)
                    
                        <div class="flex items-start gap-4 ml-12 mt-2">
                            <div class="flex-shrink-0"></div> <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    <span class="font-bold text-sm">{{ $r->nama_pengirim }}</span>
                                    <span class="font-bold text-xs">{{ $r->created_at->format('d-m-Y H:i') }}</span>
                                </div>
                                <div class="mt-1 bg-white border border-gray-400 p-2 ml-10 rounded-sm">
                                    <p class="text-sm text-gray-700">{{ $r->isi_pesan }}</p>
                                </div>
                            </div>
                        </div>
                
                        <div id="display-{{ $r->id }}" class="items-start ml-28 ">
                            @php
                                $isOwner = false;
                                // Jika Login: Cek user_id
                                if (Auth::check() && $r->user_id === Auth::id()) {
                                    $isOwner = true;
                                } 
                                // Jika Anonim: Cek apakah session_token di DB sama dengan session browser sekarang
                                elseif (!$r->user_id && $r->session_token === session()->getId()) {
                                    $isOwner = true;
                                }

                                $isAdmin = Auth::check() && Auth::user()->role === 'adm';
                            @endphp

                            <div class="flex gap-2 text-xs mt-2">
                                @if($isOwner)
                                    <button onclick="toggleEdit({{ $r->id }})" class="text-blue-500 hover:underline">Edit</button>
                                @endif

                                @if($isOwner || $isAdmin)
                                    <form action="{{ route('forum.destroy', $r->id) }}" 
                                        method="POST" 
                                        id="delete-form-{{ $r->id }}" 
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete('{{ $r->id }}')" 
                                                class="text-red-500 hover:underline cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- Form Edit disembunyikan --}}
                        <div id="form-{{ $r->id }}" class="hidden mt-2">
                            <form action="{{ route('forum.update', $r->id) }}" method="POST">
                                @csrf @method('PUT')
                                <textarea name="isi_pesan" class="w-full border-black border-2 p-2 text-sm">{{ $r->isi_pesan }}</textarea>
                                <div class="flex gap-2 mt-1">
                                    <button type="submit" class="bg-black text-white px-3 py-1 text-xs">Simpan</button>
                                    <button type="button" onclick="toggleEdit({{ $r->id }})" class="text-xs underline">Batal</button>
                                </div>
                            </form>
                        </div>

                    @endforeach
                       
                </div>
                <script>
                    function toggleEdit(id) {
                        const displayDiv = document.getElementById(`display-${id}`);
                        const formDiv = document.getElementById(`form-${id}`);
                        
                        if (formDiv.classList.contains('hidden')) {
                            formDiv.classList.remove('hidden');
                            displayDiv.classList.add('hidden');
                        } else {
                            formDiv.classList.add('hidden');
                            displayDiv.classList.remove('hidden');
                        }
                    }

                    function confirmDelete(id) {
                        Swal.fire({
                            title: 'Hapus pesan?',
                            text: "Pesan yang dihapus tidak bisa dikembalikan.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444', 
                            cancelButtonColor: '#6b7280',  
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true 
                        }).then((result) => {
                            if (result.isConfirmed) {
                                
                                document.getElementById('delete-form-' + id).submit();
                            }
                        })
                    }
                </script>

                <div class="p-4 bg-[#E8E7D5] border-t border-gray-300">
                    <form action="{{ $thread ? route('forum.reply') : route('forum.store') }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        <div class="w-12 h-12 bg-[#2D3748] rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        
                        <div class="relative flex-1">
                            <textarea name="isi_pesan" rows="1" 
                                class="w-full bg-transparent border-none focus:ring-0 placeholder-gray-500 resize-none py-3" 
                                placeholder="Tulis balasan pesan di sini..."></textarea>
                        </div>
                        <input type="hidden" name="parent_id" value="{{ $thread->id }}">

                        <button type="submit" class="text-gray-600 hover:text-black transition">
                            <svg class="w-8 h-8 rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>