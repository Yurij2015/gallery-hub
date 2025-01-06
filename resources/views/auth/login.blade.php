<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }}</label>
            <input type="email" name="email" id="email"
                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                   placeholder="Type your email" required>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>
        <div>

            <label for="password"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
            <input type="password" name="password" id="password" placeholder="••••••••"
                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                   required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="remember_me" aria-describedby="remember" name="remember" type="checkbox"
                       class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div class="ml-3 text-sm">
                <label for="remember" class="font-medium text-gray-900 dark:text-white">{{ __('Remember me') }}</label>
            </div>

            @if (Route::has('password.request'))
                <a class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500"
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

        </div>
        <button type="submit"
                class="w-full px-5 py-2.5 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            {{ __('Login to your account') }}
        </button>

        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ __('Not registered?') }} <a
                class="text-primary-700 hover:underline dark:text-primary-500">{{ __('Create account')  }}</a>
        </div>
    </form>

</x-guest-layout>
