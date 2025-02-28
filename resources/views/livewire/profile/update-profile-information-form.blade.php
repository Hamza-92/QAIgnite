<?php

use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $organization = '';
    public $avatar;
    public $avatarPreview;

    public function mount(): void {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->organization = Organization::find($user->organization_id)->name;
        $this->avatar = $user->avatar;
        $this->avatarPreview = $this->avatar ? asset('storage/' . $this->avatar) : asset('storage/images/avatar/default.jpg');
    }

    public function updatedAvatar() {
        $this->validate([
            'avatar' => 'image|max:2048', // Only images, max 2MB
        ]);

        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function updateProfileInformation(): void {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'organization' => ['required', 'string', 'max:255', Rule::unique(Organization::class, 'name')->ignore($user->organization_id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($this->avatar instanceof \Illuminate\Http\UploadedFile) {
            $path = $this->avatar->store('avatars', 'public');
            $validated['avatar'] = $path;
        } else {
            unset($validated['avatar']);
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Organization::find($user->organization_id)->update(['name' => $validated['organization']]);

        $this->dispatch('profile-updated', name: $user->name);
        Toaster::success('Profile updated');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <div class="relative group w-32 h-32">
                <input type="file" wire:model="avatar" id="avatar" name="avatar" class="hidden" accept="image/*">

                @if ($avatarPreview)
                    <img class="w-32 h-32 object-cover object-center rounded-full border-4 border-gray-200 dark:border-gray-700 shadow-sm" src="{{ $avatarPreview }}" alt="Uploaded Avatar">
                @else
                    <img class="w-32 h-32 object-cover object-center rounded-full" src="{{ asset('storage/images/avatar/default.jpg') }}" alt="Default Avatar">
                @endif

                <label for="avatar" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <i class="fa-solid fa-edit text-white"></i>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input wire:model="username" id="username" name="username" type="text" class="mt-1 block w-full"
                required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full"
                required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if (auth()->user()->role_id === 1)
        <div>
            <x-input-label for="organization" :value="__('Organization')" />
            <x-text-input wire:model="organization" id="organization" name="organization" type="text"
                class="mt-1 block w-full" required autofocus autocomplete="organization" />
            <x-input-error class="mt-2" :messages="$errors->get('organization')" />
        </div>
        @endif


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
