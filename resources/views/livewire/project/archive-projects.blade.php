<div x-data="{ showRestoreModel: false, showDeleteModel: false, project_id: null }">
    <div class="px-8 py-4 space-y-4 border-b dark:border-gray-700">
        <a href="{{ route('projects') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                class="fa-solid fa-arrow-left"></i> Projects</a>
        <h2 class="text-lg font-medium mt-2">Archived Projects</h2>
        <p><span class="text-red-500">Note:</span> All of the archived projects will be permanently deleted after <span
                class="text-red-500">30 days</span>.</p>
    </div>

    <div class="px-8 py-4">
        <div class="flex items-center justify-between">
            <x-table-entries entries="perPage" />
            <x-search-field search='search' resetMethod='resetSearch'></x-search-field>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="name" displayName="Name" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="updated_at" displayName="Deleted Date" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                        <x-sortable-th name="status" displayName="Status" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr wire:key='{{ $project->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">{{ $project->name }}</td>
                            <td class="px-4 py-3">{{ $project->updated_at }}</td>
                            <td class="px-4 py-3">{{ $project->status }}</td>
                            <td class="px-4 py-3 flex justify-center whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="px-4 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 cursor-pointer">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center gap-2 before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                        <!-- Restore Button -->
                                        <button type="button"
                                            @click='showRestoreModel = true; project_id = {{ $project->id }}'
                                            wire:loading.attr="disabled"
                                            class="px-2 py-1 text-green-500 hover:text-green-600 dark:text-green-400 dark:hover:text-green-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="Restore Project">
                                            <i class="fa-solid fa-retweet"></i>
                                        </button>

                                        {{-- Delete Project Button --}}
                                        <button @click='showDeleteModel = true; project_id = {{ $project->id }}'
                                            class="px-2 py-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            type="button" title="Delete Project">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="w-full p-4 text-center" colspan="5">No Records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>{{ $projects->links() }}</div>
    </div>

    {{-- Restore Confirmation Model --}}
    <div x-show="showRestoreModel" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @keydown.escape.window="showRestoreModel = false; project_id = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 dark:bg-gray-100/50"
        style="display: none;">
        <div
            class="flex flex-col items-center bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md mx-auto shadow-lg">
            <div class="text-green-500 mb-2 text-3xl">
                <i class="fa-solid fa-rotate-left"></i>

            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Restore Project</h3>
            <p class="mb-1">Are you sure you want to restore this project?</p>

            <div class="mt-6 space-x-3">
                <button type="button" @click="$wire.restore(project_id); showRestoreModel = false; project_id = null"
                    class="px-5 py-2 rounded-md text-white bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-500 focus:ring-2 focus:ring-green-400">
                    Restore
                </button>
                <button type="button" @click="showRestoreModel = false; project_id = null"
                    class="px-5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- Delete Project Modal --}}
    <div x-show="showDeleteModel" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @keydown.escape.window="showDeleteModel = false; project_id = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 dark:bg-gray-100/50"
        style="display: none;">
        <div
            class="flex flex-col items-center bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md mx-auto shadow-lg">
            <div class="text-red-600 dark:text-red-400 mb-2 text-3xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Project</h3>
            <p class="mb-1">Are you sure you want to delete this project?</p>
            <p>Remember this action cannot be undone.</p>

            <div class="mt-6 space-x-3">
                <button type="button" @click="$wire.delete(project_id); showDeleteModel = false; project_id = null"
                    class="px-5 py-2 rounded-md text-white bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 focus:ring-2 focus:ring-red-400">
                    Delete
                </button>
                <button type="button" @click="showDeleteModel = false; project_id = null"
                    class="px-5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
