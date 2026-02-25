<x-auth-layout>
    <x-auth-session-status class="pb-10" :status="session('status')" />
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
            const errorMessages = {!! json_encode($errors->all()) !!};
            const errorList = '<ul style="text-align: center;">' + errorMessages.map(e => '<li>' + e + '</li>').join('') + '</ul>';
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: errorList,
            });
        </script>
    @endif

    <div class="min-h-48 flex items-center justify-center mb-7">
        <div class=" w-full max-w-sm  bg-white rounded-xl p-4 shadow dark:border dark:bg-gray-800/80 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
            <h1 class="text-center font-bold text-slate-600 dark:text-white text-[clamp(2.5rem,2.2vw,2rem)] pt-6">
                DAFTAR AKUN
            </h1>
            <div class="w-full rounded-lg p-10 text-xl flex flex-col justify-center">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- NIM -->
                    <div class="mt-4">
                        <x-input-label for="nim" :value="__('NIM')" />
                        <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" required autocomplete="nim" placeholder="nim" />
                        <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                    </div>

                    <!-- Username -->
                    <div class="mt-4">
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"  required autocomplete="username" placeholder="username"/>
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4 bg-[#0F172A] hover:bg-[#3b3c51] active:scale-95 transition-all duration-100">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
         {{-- Link untuk kembali ke halama login --}}
        <div class="mt-4 pb-6 text-center">
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Login</a>
            </p>
        </div>
    </div>
       
</x-auth-layout>
