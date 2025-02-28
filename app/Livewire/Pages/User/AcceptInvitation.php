<?php

namespace App\Livewire\Pages\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Invitation;
use Livewire\Component;

class AcceptInvitation extends Component
{
    public $invitation_id;
    public $name;
    public $username;
    public $email;
    public $organization_id;
    public $role_id;
    public $password;
    public $password_confirmation;

    public function mount($token) {
        $data = Invitation::where('token', $token)->first();
        if (!isset($data)) {
            abort(403, 'Sorry you cannot perform this action');
        } elseif ($data->created_at < now()->subDays(7)) {
            abort(403, 'Sorry the link is expired');
        }
        $this->invitation_id = $data->id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->organization_id = $data->organization_id;
        $this->role_id = $data->role_id;
    }

    protected function rules() {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function register(): void {
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $this->name,
            'username' => $validated['username'],
            'email' => $this->email,
            'organization_id' => $this->organization_id,
            'password' => $validated['password'],
            'role_id' => $this->role_id,
            'email_verified_at' => now(),
        ]);

        Invitation::find($this->invitation_id)->delete();

        Auth::login($user);

        $this->redirect(route('dashboard'), navigate: true);
    }

    public function render() {
        return view('livewire.pages.user.accept-invitation')->layout('layouts.common');
    }
}
