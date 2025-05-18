<section class="w-full">
    <div class="px-8 py-6 border-b dark:border-gray-700">
        <h2 class="text-xl font-medium">User Profile</h2>
    </div>
    <div class="px-8 py-6">
        <form wire:submit="updateProfileInformation" class="w-full space-y-6 max-w-md">
            <div>
                <div class="relative group w-32 h-32">
                    <input type="file" wire:model="avatar" id="avatar" name="avatar" class="hidden" accept="image/*">
                    @if ($avatar_preview)
                        <img class="w-32 h-32 object-cover object-center rounded-full border-4 border-gray-200 dark:border-gray-700 shadow-sm"
                            src="{{ $avatar_preview }}" alt="Uploaded Avatar">
                    @else
                        <img class="w-32 h-32 object-cover object-center rounded-full"
                            src="{{ asset('storage/images/avatar/default.jpg') }}" alt="Default Avatar">
                    @endif
                    <label for="avatar"
                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full cursor-pointer opacity-0 group-hover:opacity-75 transition-opacity duration-300">
                        <i class="fa-solid fa-edit text-white"></i>
                    </label>
                </div>
                @error('avatar')
                    <span class="text-red-500 mt-2">{{ $message }}</span>
                @enderror
            </div>
            <flux:input wire:model="name" :label="__('Name')" type="text" name="name" required autofocus
                autocomplete="name" />
            <flux:input wire:model="username" :label="__('Username')" type="text" name="username" required autofocus
                autocomplete="username" />
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" name="email" required
                    autocomplete="email" />
                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}
                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>
                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>
            <flux:input wire:model="organization" :label="__('Organization')" type="text" name="organization" required
                autofocus autocomplete="organization" />
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </div>

    <div class="px-8 mb-8 max-w-md">
        <livewire:settings.password />
    </div>
    <div class="px-8 mb-8">
        <livewire:settings.delete-user-form />
    </div>
</section>
