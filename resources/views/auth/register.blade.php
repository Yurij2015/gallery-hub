<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
        @csrf
        <div>
            <label for="name"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Name") }}</label>
            <input type="text" name="name" id="name" value="{{ old("name") }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                   placeholder="Type your name" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <div>
            <label for="email"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Your email') }} </label>
            <input type="email" name="email" id="email" value="{{ old("email") }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                   placeholder="Type your email" required autocomplete="email">
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>
        <div>
            <label for="password"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Your password") }}</label>
            <input type="password" name="password" id="password" placeholder="••••••••"
                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>
        <div>
            <label for="confirm-password"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Confirm your password") }}</label>
            <input type="password" name="password_confirmation" id="confirm-password" placeholder="••••••••"
                   class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <button type="submit"
                class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            {{ __("Create account") }}
        </button>
        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ __("Already have an account?") }}
            <a href="{{ route('login') }}" class="text-primary-700 hover:underline dark:text-primary-500">
                {{ __('Login here') }}
            </a>
        </div>
    </form>
</x-guest-layout>
