<div x-data="{ showModal: false, methodName: '', methodParam: null, actionType: '' }">
    <!-- Trigger Button -->
    <span @click="showModal = true; methodName = '{{ $method }}'; methodParam = '{{ $param }}'; actionType = '{{ $type ?? 'confirm' }}'"
        role="button" tabindex="0" @keydown.enter="showModal = true; methodName = '{{ $method }}'; actionType = '{{ $type ?? 'confirm' }}'">
        {{ $slot }}
    </span>

    <!-- Modal -->
    <div x-show="showModal" @keydown.escape.window="showModal = false"
        class="fixed inset-0 flex items-center justify-center bg-gray-900/50 z-50 transition-opacity duration-300"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $message }}</p>

            <div class="mt-4 flex items-center justify-center space-x-2">
                <!-- Confirm Button (Runs Passed Method) -->
                <button @click="$wire.call(methodName, methodParam); showModal = false"
                    :class="{
                        'bg-red-600 hover:bg-red-700 focus:ring-red-500': actionType === 'delete',
                        'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500': actionType === 'archive',
                        'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500': actionType === 'update',
                        'bg-green-600 hover:bg-green-700 focus:ring-green-500': actionType === 'confirm'
                    }"
                    class="px-4 py-2 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-opacity-50">
                    <span x-text="{
                        delete: 'Delete',
                        archive: 'Archive',
                        update: 'Update',
                        confirm: 'Confirm'
                    }[actionType]"></span>
                </button>

                <!-- Cancel Button -->
                <button @click="showModal = false"
                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
