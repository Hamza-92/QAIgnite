<div x-data="{ isLoading: true }" x-init="window.addEventListener('load', () => isLoading = false);
    $nextTick(() => {
        if (window.livewire) {
            window.livewire.hook('component.initialized', () => isLoading = false);
        } else {
            isLoading = false;
        }
    })" x-show="isLoading"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-white dark:bg-gray-900">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-blue-500"></div>
    </div>
