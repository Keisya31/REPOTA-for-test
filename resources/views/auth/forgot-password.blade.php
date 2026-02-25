<x-auth-layout>
    <div class="min-h-20 flex items-center justify-center mb-7">
        <div class=" w-full max-w-sm  bg-white rounded-xl p-4 shadow dark:border dark:bg-gray-800/80 dark:border-gray-700 transition-all duration-300 hover:shadow-2xl">
            <h1 class="text-center font-bold text-slate-600 dark:text-white text-lg pt-4">
                GANTI KATA SANDI
            </h1>
             <!-- Session Status -->
            <x-auth-session-status class="pb-6 pt-10" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
           
            <button type="button" class="text-sm w-auto px-5 py-5 mt-3 font-medium text-gray-600 rounded-lg ease-out duration-200">
                        {{  __('Sudah memiliki akun?') }}
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Masuk di sini</a>
            </button>
        </div>
    </div>

</x-auth-layout>