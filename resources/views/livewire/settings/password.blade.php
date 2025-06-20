<section class="w-full">
    <h3 class="text-lg font-medium">Manage Password</h3>
    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <flux:input wire:model="current_password" id="update_password_current_passwordpassword"
            :label="__('Current password')" type="password" name="current_password" required
            autocomplete="current-password" />
        <flux:input wire:model="password" id="update_password_password" :label="__('New password')" type="password"
            name="password" required autocomplete="new-password" />
        <flux:input wire:model="password_confirmation" id="update_password_password_confirmation"
            :label="__('Confirm Password')" type="password" name="password_confirmation" required
            autocomplete="new-password" />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
            </div>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
