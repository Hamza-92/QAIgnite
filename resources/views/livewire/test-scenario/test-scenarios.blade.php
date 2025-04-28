<div>
    <div
        class="px-8 py-4 flex items-center flex-wrap gap-4 justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg">Test Scenarios</h2>
        <button x-on:click="$wire.create = true"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer"
            type="button"><i class="fa-solid fa-plus"></i> Test Scenario</button>
    </div>

    {{-- Table --}}
    <livewire:test-scenario.ts-data-table wire:listen="refreshTable" />

    {{-- Form --}}
    <div x-data x-show="$wire.create || $wire.edit" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-end bg-gray-900/50 dark:bg-gray-100/50"
        x-cloak>

        <!-- Modal panel -->
        <div x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="relative h-full max-h-screen w-full max-w-3xl ml-auto bg-white dark:bg-gray-900 shadow-xl overflow-y-auto">

            <!-- Modal header -->
            <div
                class="sticky top-0 z-10 px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <h3 class="text-lg" x-text="$wire.create ? 'Create new Test Scenario' : 'Edit Test Scenario'">
                </h3>
                <button wire:click='resetForm'
                    class="p-2 -mr-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors cursor-pointer"
                    aria-label="Close">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Modal content -->
            <div class="p-8">
                <form wire:submit.prevent='save'>
                    {{-- Test Scenario Name --}}
                    <x-input-field label='Test Scenario Name' model='ts_name' type='text' required='true' />

                    {{-- Test Scenario Description --}}
                    <x-textarea class="mt-4" label='Description' model='ts_description' required='true'
                        rows='5' />

                    {{-- Status --}}


                    {{-- Additional Details --}}
                    <div x-data="{ open: false }" class="mt-4">
                        <div @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-lg"
                            :class="{ 'rounded-lg': !open }">
                            <h3 class="text-lg font-medium">Additional Details</h3>
                            <span
                                class="px-2 py-1 bg-white text-gray-900 font-bold rounded transition-transform duration-300"
                                :class="{ 'rotate-180': open }" x-text="open ? '−' : '+'"></span>
                        </div>

                        <div x-show="open" class="mt-4" x-collapse.duration.300ms
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95">
                            <div class="grid sm:grid-cols-2 gap-4">

                                {{-- Build ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Build ID</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center gap-2 px-4 py-2 rounded-md border dark:border-gray-700"
                                            :class="open_model ? 'outline-2' : ''">
                                            <div class="w-full flex items-center justify-between gap-2 overflow-hidden">
                                                <span @click="open_model = !open_model"
                                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                                    x-text="$wire.build_id ? $wire.form_selected_build_name : 'Select build id'"></span>
                                                <button x-show='$wire.build_id' wire:click='resetBuildID'
                                                    class="cursor-pointer" type="button">
                                                    <i wire:loading.remove wire:target='resetBuildID'
                                                        class="fa-solid fa-xmark"></i>
                                                    <i wire:loading wire:target='resetBuildID'
                                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </button>
                                            </div>
                                            <div class="text-gray-500">
                                                <i @click="open_model = !open_model" wire:loading.remove
                                                    wire:target='assignBuildID' class="fa-solid"
                                                    :class="open_model ? 'fa-angle-up' : 'fa-angle-down'"></i>
                                                <i wire:loading wire:target='assignBuildID'
                                                    class="fa-solid fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                        <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute z-10 mt-2 w-full shadow-lg rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 max-h-72 overflow-auto">
                                            <div class="border-b dark:border-gray-700 flex items-center px-4 py-3">
                                                <input wire:model.live.debounce.300='form_search_build' type="text"
                                                    name="search"
                                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                                    placeholder="Type to search">
                                                <div wire:loading wire:target="form_search_build" class="ml-2">
                                                    <i class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </div>
                                            </div>
                                            <div>
                                                @forelse ($form_builds as $build)
                                                    <button id="{{ $build->id }}" type="button"
                                                        wire:click = 'assignBuildID({{ $build }})'
                                                        @click = 'open_model = false'
                                                        class="flex items-center justify-between py-2 px-4 hover:bg-gray-800 hover:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-900 text-left w-full">
                                                        {{ $build->name }}
                                                    </button>
                                                @empty
                                                    <p class="py-2 px-4 text-left w-full">
                                                        No records found</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    @error('build_id')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Module ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Module ID</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center gap-2 px-4 py-2 rounded-md border dark:border-gray-700 "
                                            :class="open_model ? 'outline-2' : ''">
                                            <div class="w-full flex items-center justify-between gap-2 overflow-hidden">
                                                <span @click="open_model = !open_model"
                                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                                    x-text="$wire.module_id ? $wire.form_selected_module_name : 'Select module id'"></span>
                                                <button x-show='$wire.module_id' wire:click='resetModuleID'
                                                    class="cursor-pointer" type="button">
                                                    <i wire:loading.remove wire:target='resetModuleID'
                                                        class="fa-solid fa-xmark"></i>
                                                    <i wire:loading wire:target='resetModuleID'
                                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </button>
                                            </div>
                                            <div class="text-gray-500">
                                                <i @click="open_model = !open_model" wire:loading.remove
                                                    wire:target='assignModuleID' class="fa-solid"
                                                    :class="open_model ? 'fa-angle-up' : 'fa-angle-down'"></i>
                                                <i wire:loading wire:target='assignModuleID'
                                                    class="fa-solid fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                        <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute z-10 mt-2 w-full shadow-lg rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 max-h-72 overflow-auto">
                                            <div class="border-b dark:border-gray-700 flex items-center px-4 py-2">
                                                <input wire:model.live.debounce.300='form_search_module'
                                                    type="text" name="search"
                                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                                    placeholder="Type to search">
                                                <div wire:loading wire:target="form_search_module" class="ml-2">
                                                    <i class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </div>
                                            </div>
                                            <div>
                                                @forelse ($form_modules as $module)
                                                    <button wire:key='{{ $module->id }}' type="button"
                                                        wire:click = 'assignModuleID({{ $module }})'
                                                        @click = 'open_model = false'
                                                        class="flex items-center justify-between py-2 px-4 hover:bg-gray-800 hover:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-900 text-left w-full">
                                                        {{ $module->module_name }}
                                                    </button>
                                                @empty
                                                    <p class="py-2 px-4 text-left w-full">
                                                        No records found</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    @error('module_id')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Requirement ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Requirement ID</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center gap-2 px-4 py-2 rounded-md border dark:border-gray-700 "
                                            :class="open_model ? 'outline-2' : ''">
                                            <div class="w-full flex items-center justify-between gap-2 overflow-hidden">
                                                <span @click="open_model = !open_model"
                                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                                    x-text="$wire.requirement_id ? $wire.form_selected_requirement_name : 'Select requirement id'"></span>
                                                <button x-show='$wire.requirement_id' wire:click='resetRequirementID'
                                                    class="cursor-pointer" type="button">
                                                    <i wire:loading.remove wire:target='resetRequirementID'
                                                        class="fa-solid fa-xmark"></i>
                                                    <i wire:loading wire:target='resetRequirementID'
                                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </button>
                                            </div>
                                            <div class="text-gray-500">
                                                <i @click="open_model = !open_model" wire:loading.remove
                                                    wire:target='assignRequirementID' class="fa-solid"
                                                    :class="open_model ? 'fa-angle-up' : 'fa-angle-down'"></i>
                                                <i wire:loading wire:target='assignRequirementID'
                                                    class="fa-solid fa-spinner fa-spin"></i>
                                            </div>
                                        </div>
                                        <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 scale-100"
                                            x-transition:leave-end="opacity-0 scale-95"
                                            class="absolute z-10 mt-2 w-full shadow-lg rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 max-h-72 overflow-auto">
                                            <div class="border-b dark:border-gray-700 flex items-center px-4 py-2">
                                                <input wire:model.live.debounce.300='form_search_requirement'
                                                    type="text" name="search"
                                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                                    placeholder="Type to search">
                                                <div wire:loading wire:target="form_search_requirement"
                                                    class="ml-2">
                                                    <i class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </div>
                                            </div>
                                            <div>
                                                @forelse ($form_requirements as $requirement)
                                                    <button wire:key='{{ $requirement->id }}' type="button"
                                                        wire:click = 'assignRequirementID({{ $requirement }})'
                                                        @click = 'open_model = false'
                                                        class="flex items-center justify-between py-2 px-4 hover:bg-gray-800 hover:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-900 text-left w-full">
                                                        {{ $requirement->requirement_title }}
                                                    </button>
                                                @empty
                                                    <p class="py-2 px-4 text-left w-full">
                                                        No records found</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    @error('requirement_id')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Footer --}}
                    <div class="flex items-center justify-center gap-4 mt-12">
                        <button type="submit" wire:loading.attr='disabled'
                            class="px-8 py-3 sm:w-42 transition duration-200 rounded-md bg-blue-500 hover:bg-blue-600 text-xl text-white dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">Save
                            <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i></button>
                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-8 py-3 text-xl sm:w-42 transition duration-200 rounded-md bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 cursor-pointer">
                            <span>Cancel</span>
                            <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
