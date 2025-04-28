<div x-data="{ showModel: false, showDetailsModel: false, project_id: null }">

    @if (session('error'))
        <div class="px-8 py-2">
            <x-alert type="error" :message="session('error')" />
        </div>
    @endif


    <div
        class="px-8 py-4 flex-wrap gap-2 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <button x-on:click="$wire.createProject = true"
            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md cursor-pointer"
            type="button">Create Project</button>
        <a href="{{ route('projects.archive') }}"
            class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 dark:bg-indigo-600 dark:hover:bg-indigo-500 text-white rounded-md cursor-pointer"
            wire:navigate>Archived Projects</a>
    </div>

    {{-- Data Table --}}
    <div class="px-8 py-4">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <x-table-entries entries="perPage" />
            <x-search-field search='search' resetMethod='resetSearch'></x-search-field>
        </div>
        <div class="mt-4 border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 font-medium">
                    <tr>
                        <x-sortable-th name="name" displayName="Name" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="user_name" displayName="Created By" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="status" displayName="Status" :sortBy="$sortBy" :sortDir="$sortDir" />
                        <x-sortable-th name="created_at" displayName="Created Date" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                        <th class="px-4 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm ">
                    @forelse ($projects as $project)
                        <tr wire:key='{{ $project->id }}' class="hover:bg-gray-100 dark:hover:bg-gray-800">
                            <td class="px-4 py-3">{{ $project->name }}</td>
                            <td class="px-4 py-3">{{ $project->user->name }}</td>
                            <td class="px-4 py-3">{{ $project->status }}</td>
                            <td class="px-4 py-3">{{ $project->created_at->format('M j, Y g:i A') }}</td>
                            <td class="px-4 py-3 flex justify-center whitespace-nowrap">
                                <div class="relative" x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="px-4 py-1 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 cursor-pointer">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" x-transition
                                        class="absolute top-1/2 right-full mr-3 transform -translate-y-1/2 p-1 text-md bg-white dark:bg-gray-800 rounded-md border dark:border-gray-700 shadow-lg z-10 flex items-center justify-center gap-2 before:absolute before:top-1/2 before:left-full before:-translate-y-1/2 before:w-0 before:h-0 before:border-[6px] before:border-t-transparent before:border-b-transparent before:border-l-white dark:before:border-l-gray-800 before:border-r-transparent">
                                        <!-- View Button -->
                                        <button type="button" @click='showDetailsModel = true'
                                            wire:click='loadProject({{ $project->id }})' wire:loading.attr="disabled"
                                            class="px-2 py-1 text-green-600 hover:text-blue-800 dark:text-green-400 dark:hover:text-green-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="View Project">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Edit Button -->
                                        <button type="button" wire:click="edit({{ $project->id }})"
                                            {{-- wire:loading.attr="disabled" --}}
                                            class="px-2 py-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors border-r dark:border-gray-700 cursor-pointer"
                                            title="Edit Project">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        {{-- Archive Project Button --}}
                                        <button @click='showModel = true; project_id = {{ $project->id }}'
                                            class="px-2 py-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            type="button" title="Archive Project">
                                            <i class="fa-solid fa-box-archive"></i>
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
        <div class="mt-4">{{ $projects->links() }}</div>
    </div>

    {{-- Archive Confirmation Modal --}}
    <div x-show="showModel" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @keydown.escape.window="showModel = false; project_id = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 dark:bg-gray-100/50"
        style="display: none;">
        <div
            class="flex flex-col items-center bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md mx-auto shadow-lg">
            <div class="text-yellow-600 dark:text-yellow-400 mb-2 text-3xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Archive Project</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300">Are you sure you want to archive this project?</p>

            <div class="mt-6 space-x-3">
                <button type="button" @click="$wire.archiveProject(project_id); showModel = false; project_id = null"
                    class="px-5 py-2 rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-2 focus:ring-yellow-400">
                    Archive
                </button>
                <button type="button" @click="showModel = false; project_id = null"
                    class="px-5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- Project Detail Modal --}}
    <div x-show="showDetailsModel" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 flex items-center justify-center bg-gray-500/50 backdrop-blur-sm z-50" x-cloak>
        {{-- Modal Box --}}
        <div class="w-full mx-4 md:w-[700px] lg:w-[800px] max-h-[90vh] bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden flex flex-col"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            @keydown.escape.window="showDetailsModel=false; $wire.project=null">
            {{-- Modal Header --}}
            <div
                class="p-5 flex justify-between items-center border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-900 sticky top-0 z-10">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 truncate max-w-[80%]">
                    Project Details: <span
                        class="text-blue-600 dark:text-blue-400">{{ $project_detail->name ?? 'N/A' }}</span>
                </h2>
                <button @click='showDetailsModel=false; $wire.project_detail=null' type="button"
                    class="px-2 py-1  text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xl transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                    aria-label="Close modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            {{-- Modal Content --}}
            <div class="flex-1 overflow-y-auto p-5 md:p-6">
                <div class="space-y-6">
                    @if ($project_detail)
                        {{-- Project Status --}}
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Project Status</h3>
                            <div class="text-gray-600 dark:text-gray-400">
                                {{ $project_detail->status ?? '' }}
                            </div>
                        </div>
                        {{-- Project Type --}}
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Project Type</h3>
                            <div class="text-gray-600 dark:text-gray-400">
                                @if (is_array($project_detail->type))
                                    @if (count($project_detail->type))
                                        {{ implode(', ', $project_detail->type) }}
                                    @else
                                        Not Set
                                    @endif
                                @elseif(!empty($project_detail->type))
                                    {{ $project_detail->type }}
                                @else
                                    Not Set
                                @endif
                            </div>
                        </div>
                        {{-- Project Descripion --}}
                        <div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Project Descripion</h3>
                            <div class="text-gray-600 dark:text-gray-400">
                                {{ $project_detail->description ?? 'N/A' }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Modal Footer --}}
            <div
                class="p-4 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-end items-center gap-3 sticky bottom-0">
                <button @click='showDetailsModel = false; $wire.project_detail = null' type="button"
                    class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 rounded-md transition-colors w-full sm:w-auto order-2 sm:order-1">
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- Project Form --}}
    <div x-show="$wire.createProject || $wire.editProject" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto" x-cloak>

        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900/50 dark:bg-gray-100/50" x-transition.opacity></div>

        <div class="absolute w-full h-full max-w-3xl top-0 right-0 bg-white dark:bg-gray-900 overflow-auto">
            <div
                class="sticky top-0 z-10 px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <h3 class="text-lg" x-text="$wire.createProject ? 'Create new Project' : 'Edit Project'"></h3>
                <button wire:click='resetForm' type="button"
                    class="p-2 -mr-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors cursor-pointer"
                    aria-label="Close">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-8">
                <form wire:submit.prevent='save'>
                    <div class="grid sm:grid-cols-2 gap-4">
                        {{-- Project Name --}}
                        <x-input-field label='Name' model='name' type='text' required='true'
                            autocomplete='project-name' />

                        {{-- Project Types --}}
                        <div class="flex flex-col gap-1">
                            <label>Type</label>
                            <div x-data='{open_model : false}' class="relative w-full"
                                @click.outside="open_model = false" @close.stop="open_model = false">
                                <div @click.stop="open_model = !open_model"
                                    class="w-full flex items-center rounded-md border border-gray-200 dark:border-gray-700 px-4 py-1">
                                    <div class="w-full flex items-center justify-start gap-2 flex-wrap">
                                        @forelse ($types as $index => $type)
                                            <div class="bg-gray-200 dark:bg-gray-800 rounded-sm py-1 ">
                                                <span
                                                    class="pr-1 border-r dark:border-gray-700 px-2">{{ $type }}</span>
                                                <button wire:click='removeType({{ $index }})'
                                                    class="px-1 pr-2" type="button">
                                                    <i wire:loading.remove
                                                        wire:target='removeType({{ $index }})'
                                                        class="fa-solid fa-xmark cursor-pointer"></i>
                                                    <i wire:loading wire:target='removeType({{ $index }})'
                                                        class="fa-solid fa-spinner fa-spin"></i>
                                                </button>
                                            </div>
                                        @empty
                                            <span class="text-gray-700 dark:text-gray-300 py-1">Select project
                                                type</span>
                                        @endforelse
                                    </div>
                                    <i wire:loading.remove wire:target='addType'
                                        class="fa-solid fa-angle-down ml-2 text-gray-500"></i>
                                    <i wire:loading wire:target='addType'
                                        class="fa-solid fa-spinner fa-spin ml-2 text-gray-500"></i>
                                </div>
                                <div x-show='open_model'
                                    class="absolute z-10 mt-2 w-full shadow-lg bg-gray-100 max-h-72 overflow-auto">

                                    <div>
                                        <button id="" type="button" wire:click = 'addType("Web")'
                                            @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                            Web
                                        </button>
                                        <button id="" type="button"
                                            wire:click = 'addType("Responsive Web")' @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                            Responsive Web
                                        </button>
                                        <button id="" type="button"
                                            wire:click = 'addType("Native Mobile App")' @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                            Native Mobile App
                                        </button>
                                        <button id="" type="button" wire:click = 'addType("Desktop")'
                                            @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                            Desktop
                                        </button>

                                    </div>
                                </div>
                            </div>
                            @error('type')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Project Status --}}
                        @if ($editProject)
                        <x-single-select-box label='Status' model='status' required='true'>
                            <option value="In Progress">In Progress</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Completed">Completed</option>
                        </x-single-select-box>
                        @endif

                        {{-- Project Description --}}
                        <x-textarea model='description' label='Description' rows='5' class="col-span-full" />
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-8">
                        <button type="submit" wire:loading.attr='disabled'
                            class="px-8 py-3 w-42 transition duration-200 rounded-md bg-blue-500 hover:bg-blue-600 text-xl text-white dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">Save
                            <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i></button>
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-8 py-3 text-xl w-42 transition duration-200 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 cursor-pointer">
                            <span>Cancel</span>
                            <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
