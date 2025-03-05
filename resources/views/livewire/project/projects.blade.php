<div>
    <div class="px-8 py-4 flex-wrap gap-2 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <button x-on:click="$wire.createProject = true"
            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white rounded-md"
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
                            <td class="px-4 py-3">{{ $project->created_at }}</td>
                            <td class="text-center px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <x-tooltip message="Edit Project">
                                        <button class="px-2 py-1 hover:text-blue-500" type="button"
                                            wire:click="edit({{ $project->id }})">
                                            <i wire:loading.remove wire:target="edit({{ $project->id }})"
                                                class="fa-solid fa-pen-to-square"></i>
                                            <i wire:loading wire:target="edit({{ $project->id }})"
                                                class="fa-solid fa-spinner fa-spin"></i>
                                        </button>
                                    </x-tooltip>
                                    <x-confirmation-modal title="Archive Project"
                                        message="Are you sure you want to archive this project?"
                                        method="archive"
                                        param="{{ $project->id }}" type="archive"
                                        >
                                        <x-tooltip message="Archive Project">
                                            <button class="px-2 py-1 hover:text-red-500" type="button">
                                                <i wire:loading.remove wire:target="archive({{ $project->id }})"
                                                    class="fa-solid fa-box-archive"></i>
                                                <i wire:loading wire:target="archive({{ $project->id }})"
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
        <div class="mt-4">{{ $projects->links() }}</div>
    </div>

    {{-- Project Form --}}
    <div x-show="$wire.createProject || $wire.editProject"
        class="absolute top-0 left-0 w-full h-full bg-gray-900/50 dark:bg-gray-100/50" id="form">
        <div x-transition:enter="transition ease-out duration-1000 transform"
            x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-1000 transform"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full"
            class="absolute w-full h-full sm:w-auto sm:w-[640px] md:w-[720px] top-0 right-0 bg-white dark:bg-gray-900 overflow-auto">
            <div class="px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg" x-text='$wire.createProject ? "Create new project" : "Edit project"'></h3>
                <button wire:click='resetForm' class="text-xl"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-8">
                <form wire:submit.prevent='save'>
                    <div class="grid sm:grid-cols-2 gap-4">
                        {{-- Project Name --}}
                        <x-input-field label='Name' model='name' type='text' required='true' autocomplete='project-name' />

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
                                                        class="fa-solid fa-xmark"></i>
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
                                <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute z-10 mt-2 w-full shadow-lg bg-gray-100 dark:bg-gray-800 max-h-72 overflow-auto">

                                    <div>
                                        <button id="" type="button" wire:click = 'addType("Web")'
                                            @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                            Web
                                        </button>
                                        <button id="" type="button"
                                            wire:click = 'addType("Responsive Web")' @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                            Responsive Web
                                        </button>
                                        <button id="" type="button"
                                            wire:click = 'addType("Native Mobile App")' @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                            Native Mobile App
                                        </button>
                                        <button id="" type="button" wire:click = 'addType("Desktop")'
                                            @click = 'open_model = false'
                                            class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
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
                        <div class="flex flex-col gap-1">
                            <label>Status</label>
                            <div class="relative flex items-center">
                                <select wire:model='status' name="status" id="status"
                                    class="w-full appearance-none rounded-md px-4 py-2 border dark:bg-gray-900 dark:border-gray-700 text-sm">
                                    <option value="In Progress">In Progress</option>
                                    <option value="On Hold">On Hold</option>
                                    <option value="Completed">Completed</option>
                                </select>
                                <span class="absolute right-0 pr-4 py-2"><i class="fa-solid fa-angle-down"></i></span>
                            </div>
                            @error('status')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    {{-- Additional Details --}}
                    <div x-data="{ open: false }" class="mt-4">
                        <div @click="open = !open"
                            class="flex items-center justify-between bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-600 dark:hover:bg-blue-500 px-4 py-2 cursor-pointer">
                            <h4 class="text-md font-bold">Additional Details</h4>
                            <span class="px-2 py-1 bg-white font-bold text-gray-900"
                                x-text='open ? "-" : "+"'>+</span>
                        </div>
                        <div x-show="open" class="grid grid-cols-2 gap-4 mt-4">
                            {{-- OS --}}
                            <div class="flex flex-col gap-1">
                                <label>OS</label>
                                <div x-data='{open_model : false}' class="relative w-full"
                                    @click.outside="open_model = false" @close.stop="open_model = false">
                                    <div @click.stop="open_model = !open_model"
                                        class="w-full h-10 flex items-center rounded-md border dark:border-gray-700 px-4 py-1 cursor-pointer">
                                        <div class="w-full flex items-center justify-start gap-2 flex-wrap">
                                            @forelse ($os as $index => $os_type)
                                                <div class="bg-gray-200 dark:bg-gray-800 rounded-sm py-1 ">
                                                    <span
                                                        class="pr-1 border-r dark:border-gray-700 px-2">{{ $os_type }}</span>
                                                    <button wire:click='removeOs({{ $index }})'
                                                        class="px-1 pr-2" type="button">
                                                        <i wire:loading.remove
                                                            wire:target='removeOs({{ $index }})'
                                                            class="fa-solid fa-xmark"></i>
                                                        <i wire:loading wire:target='removeOs({{ $index }})'
                                                            class="fa-solid fa-spinner fa-spin"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <span class="text-gray-700 dark:text-gray-300 py-1">Select
                                                    OS</span>
                                            @endforelse
                                        </div>
                                        <i wire:loading.remove wire:target='addOs'
                                            class="fa-solid fa-angle-down ml-2 text-gray-500"></i>
                                        <i wire:loading wire:target='addOs'
                                            class="fa-solid fa-spinner fa-spin ml-2 text-gray-500"></i>
                                    </div>
                                    <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute z-10 mt-2 w-full shadow-lg bg-gray-100 dark:bg-gray-800 max-h-72 overflow-auto">

                                        <div>
                                            <button id="" type="button" wire:click = 'addOs("Android")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Android
                                            </button>
                                            <button id="" type="button" wire:click = 'addOs("IOS")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                IOS
                                            </button>
                                            <button id="" type="button" wire:click = 'addOs("Linux")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Linux
                                            </button>
                                            <button id="" type="button" wire:click = 'addOs("Mac")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Mac
                                            </button>
                                            <button id="" type="button" wire:click = 'addOs("Ubunto")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Ubunto
                                            </button>
                                            <button id="" type="button" wire:click = 'addOs("Windows")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Windows
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('os')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- Devices --}}
                            <div class="flex flex-col gap-1">
                                <label>Devices</label>
                                <div x-data='{open_model : false}' class="relative w-full"
                                    @click.outside="open_model = false" @close.stop="open_model = false">
                                    <div @click.stop="open_model = !open_model"
                                        class="w-full h-10 flex items-center rounded-md border dark:border-gray-700 px-4 py-1 cursor-pointer">
                                        <div class="w-full flex items-center justify-start gap-2 flex-wrap">
                                            @forelse ($devices as $index => $device)
                                                <div class="bg-gray-200 dark:bg-gray-800 rounded-sm py-1 ">
                                                    <span
                                                        class="pr-1 border-r dark:border-gray-700 px-2">{{ $device }}</span>
                                                    <button wire:click='removeDevice({{ $index }})'
                                                        class="px-1 pr-2" type="button">
                                                        <i wire:loading.remove
                                                            wire:target='removeDevice({{ $index }})'
                                                            class="fa-solid fa-xmark"></i>
                                                        <i wire:loading
                                                            wire:target='removeDevice({{ $index }})'
                                                            class="fa-solid fa-spinner fa-spin"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <span class="text-gray-700 dark:text-gray-300 py-1">Select
                                                    device</span>
                                            @endforelse
                                        </div>
                                        <i wire:loading.remove wire:target='addDevice'
                                            class="fa-solid fa-angle-down ml-2 text-gray-500"></i>
                                        <i wire:loading wire:target='addDevice'
                                            class="fa-solid fa-spinner fa-spin ml-2 text-gray-500"></i>
                                    </div>
                                    <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute z-10 mt-2 w-full shadow-lg bg-gray-100 dark:bg-gray-800 max-h-72 overflow-auto">

                                        <div>
                                            <button id="" type="button" wire:click = 'addDevice("Iphone")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Iphone
                                            </button>
                                            <button id="" type="button" wire:click = 'addDevice("Oppo")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Oppo
                                            </button>
                                            <button id="" type="button" wire:click = 'addDevice("Samsung")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Samsung
                                            </button>
                                            <button id="" type="button" wire:click = 'addDevice("Vivo")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Vivo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('devices')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- Browsers --}}
                            <div class="flex flex-col gap-1">
                                <label>Browsers</label>
                                <div x-data='{open_model : false}' class="relative w-full"
                                    @click.outside="open_model = false" @close.stop="open_model = false">
                                    <div @click.stop="open_model = !open_model"
                                        class="w-full h-10 flex items-center rounded-md border dark:border-gray-700 px-4 py-1 cursor-pointer">
                                        <div class="w-full flex items-center justify-start gap-2 flex-wrap">
                                            @forelse ($browsers as $index => $browser)
                                                <div class="bg-gray-200 dark:bg-gray-800 rounded-sm py-1 ">
                                                    <span
                                                        class="pr-1 border-r dark:border-gray-700 px-2">{{ $browser }}</span>
                                                    <button wire:click='removeBrowser({{ $index }})'
                                                        class="px-1 pr-2" type="button">
                                                        <i wire:loading.remove
                                                            wire:target='removeBrowser({{ $index }})'
                                                            class="fa-solid fa-xmark"></i>
                                                        <i wire:loading
                                                            wire:target='removeBrowser({{ $index }})'
                                                            class="fa-solid fa-spinner fa-spin"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <span class="text-gray-700 dark:text-gray-300 py-1">Select
                                                    device</span>
                                            @endforelse
                                        </div>
                                        <i wire:loading.remove wire:target='addBrowser'
                                            class="fa-solid fa-angle-down ml-2 text-gray-500"></i>
                                        <i wire:loading wire:target='addBrowser'
                                            class="fa-solid fa-spinner fa-spin ml-2 text-gray-500"></i>
                                    </div>
                                    <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute z-10 mt-2 w-full shadow-lg bg-gray-100 dark:bg-gray-800 max-h-72 overflow-auto">

                                        <div>
                                            <button id="" type="button" wire:click = 'addBrowser("Chrome")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Chrome
                                            </button>
                                            <button id="" type="button"
                                                wire:click = 'addBrowser("Microsoft Edge")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Microsoft Edge
                                            </button>
                                            <button id="" type="button" wire:click = 'addBrowser("Opera")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Opera
                                            </button>
                                            <button id="" type="button" wire:click = 'addBrowser("Safari")'
                                                @click = 'open_model = false'
                                                class="flex items-center justify-between py-3 px-4 bg-white dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-left w-full">
                                                Safari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('browsers')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- Project Description --}}
                            <div class="flex flex-col col-span-2 gap-1">
                                <label>Description</label>
                                <textarea wire:model='description' name="description" id="description" rows="5"
                                    class="rounded-md border dark:border-gray-700 px-4 py-2">
                                </textarea>
                                @error('description')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-4">
                        <button type="submit"
                            class="px-4 py-2 rounded-md bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-800 dark:hover:bg-blue-900 dark:text-gray-300">Save
                            <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i></button>
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-gray-100">Cancel
                            <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
