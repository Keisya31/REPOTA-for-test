<x-auth-layout>
    <!-- Session Status -->
    
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ $message }}',
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!!!',
                text: '{{ $errors->first() }}',
            });
        </script>
    @endif
    <div class="min-h-20 flex items-center justify-center mb-7">
        <div class=" w-full max-w-sm  bg-white rounded-xl p-4 shadow dark:border dark:bg-gray-800/80 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
            <h1 class="text-center font-bold text-slate-600 dark:text-white text-[clamp(2.5rem,2.2vw,2rem)] pt-4">
                REPOTA
            </h1>
            <x-auth-session-status class="pb-15 pt-10" :status="session('status')" />
            <div class="w-full rounded-lg p-7 text-xl flex flex-col justify-center">
                <form class="md:space-y-2 " method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Input Username-->
                    <div class=" max-w-sm space-y-3">
                        <label for="username" class="block mb-2.5 text-sm font-medium text-heading">Username</label>
                        <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            
                        </div>
                        <input type="text" name="username" id="username" class="p-[clamp(0.6rem,1vw,0.75rem)] text-[clamp(0.9rem,1vw,1rem)] bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="username" :value="old('username')" required autofocus autocomplete="username">
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>
                        
                        <!-- Input Password-->
                        <label for="password" class="block mb-2.5 text-sm font-medium text-heading">Password</label>
                        <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            
                        </div>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bp-[clamp(0.6rem,1vw,0.75rem)] text-[clamp(0.9rem,1vw,1rem)] bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-start mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('password.request') }}">
                                    {{ __('Lupa kata sandi?') }}
                                </a>
                            @endif
                        
                        {{-- Tombol login --}}
                        <button type="submit" class="w-60 rounded-lg text-base py-3 ml-10 bg-orange-500 hover:bg-orange-700 text-white ease-out active:scale-95 transition-all duration-100">
                            {{ __('LOGIN') }}
                        </button>
                        </div>
                    </div>
                </form>
                <button type="button" class="text-sm w-auto px-5 py-5 mt-7 font-medium text-gray-600 rounded-lg ease-out duration-200">
                        {{  __('Belum memiliki akun?') }}
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Daftar di sini</a>
                </button>
            </div>
           
            
        </div>
    </div>

</x-auth-layout>