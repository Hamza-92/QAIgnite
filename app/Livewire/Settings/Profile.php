<?php

namespace App\Livewire\Settings;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $organization = '';
    public $avatar = '';
    public $avatar_preview = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->organization = Organization::find($user->organization_id)->name;
        $this->avatar = $user->avatar;
        $this->avatar_preview = $this->avatar ? asset('storage/' . $this->avatar) : asset('storage/images/avatar/default.jpg');
    }

    public function updatedAvatar() {
        $this->validate([
            'avatar' => 'image|max:2048', // Only images, max 2MB
        ]);

        if ($this->avatar instanceof \Illuminate\Http\UploadedFile) {
            $this->avatar_preview = $this->avatar->temporaryUrl();
        }
    }

    public function updateProfileInformation(): void {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'organization' => ['required', 'string', 'max:255', Rule::unique(Organization::class, 'name')->ignore($user->organization_id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', function ($attribute, $value, $fail) {
                if (!($value instanceof \Illuminate\Http\UploadedFile) && !is_string($value)) {
                    $fail('The ' . $attribute . ' must be an image.');
                }
            }],
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

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
