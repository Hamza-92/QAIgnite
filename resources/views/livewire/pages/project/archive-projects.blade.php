<div>
    <div class="px-8 py-4 space-y-4 border-b dark:border-gray-700">
        <a href="{{ route('projects') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                class="fa-solid fa-arrow-left"></i> Projects</a>
        <h2 class="text-lg font-medium">Archived Projects</h2>
        <p><span class="text-red-500">Note:</span> All of the archived projects will be permanently deleted after <span
                class="text-red-500">30 days</span>.</p>
    </div>

    <div class="px-8 py-4">
        <div class="flex items-center justify-between">
            <x-table-entries entries="perPage" />
            <x-search-field search='search' resetMethod='resetSearch'></x-search-field>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700">
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
                            <td class="text-center px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <x-confirmation-modal title="Restore Project"
                                        message="Are you sure you want to restore this project?"
                                        method="restore"
                                        param="{{ $project->id }}" type="confirm"
                                        >
                                        <x-tooltip message="Restore Project">
                                            <button class="px-2 py-1 hover:text-blue-500" type="button">
                                                <i wire:loading.remove wire:target="restore({{ $project->id }})"
                                                    class="fa-solid fa-retweet"></i>
                                                <i wire:loading wire:target="restore({{ $project->id }})"
                                                    class="fa-solid fa-spinner fa-spin"></i>
                                            </button>
                                        </x-tooltip>
                                    </x-confirmation-modal>
                                    <x-confirmation-modal title="Delete Project"
                                        message="Are you sure you want to delete this project?"
                                        method="delete"
                                        param="{{ $project->id }}" type="delete"
                                        >
                                        <x-tooltip message="Delete Project">
                                            <button class="px-2 py-1 hover:text-red-500" type="button">
                                                <i wire:loading.remove wire:target="delete({{ $project->id }})"
                                                    class="fa-solid fa-trash"></i>
                                                <i wire:loading wire:target="delete({{ $project->id }})"
                                                    class="fa-solid fa-spinner fa-spin"></i>
                                            </button>
                                        </x-tooltip>
                                    </x-confirmation-modal>
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
</div>
