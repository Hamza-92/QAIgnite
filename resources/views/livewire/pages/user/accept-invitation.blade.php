<div class="w-full flex flex-col items-center justify-center bg-gray-300 dark:bg-gray-800 min-h-screen">
    <div class="w-96 p-8 flex flex-col gap-4 items-center justify-center bg-white dark:bg-gray-900 rounded-xl shadow-lg">
        <div>
            <x-application-logo />
        </div>
        @if (Session::has('error_message'))
            <div class="p-4 bg-red-100 dark:bg-red-900 text-red-500 dark:text-red-300 rounded-md border-2 border-red-500 dark:border-red-700">
                <p>{{ Session::get('error_message') }}</p>
            </div>
        @endif
        <div>
            <p class="text-gray-900 dark:text-gray-100">Welcome <strong>{{ $name }}</strong>! Please set your username and password.</p>
        </div>
        <div class="w-full">
            <form wire:submit.prevent="register">

                <!-- Username -->
                <div class="">
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input wire:model="username" id="username" class="block mt-1 w-full" type="text" name="username" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4 gap-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-md">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
