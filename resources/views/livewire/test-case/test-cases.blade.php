<div>
    <div
        class="px-8 py-4 flex items-center flex-wrap gap-4 justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg">Test Cases</h2>
        <button x-on:click="$wire.create = true"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer"
            type="button"><i class="fa-solid fa-plus"></i> Test Case</button>
    </div>

    {{-- Data Table --}}
    <livewire:test-case.data-table wire:listen="refreshTable" />

    {{-- Test Case Form --}}
    <div x-data @keydown.escape.window="$wire.create = false; $wire.edit = false" x-show="$wire.create || $wire.edit"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-end" x-cloak>

        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900/50 dark:bg-gray-100/50 backdrop-blur-sm" x-transition.opacity></div>

        <!-- Modal panel -->
        <div x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-full opacity-0"
            class="relative h-full max-h-screen w-full max-w-3xl ml-auto bg-white dark:bg-gray-900 shadow-xl overflow-y-auto">

            <!-- Modal header -->
            <div
                class="sticky top-0 z-10 px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <h3 class="text-lg" x-text="$wire.create ? 'Create new Test Case' : 'Edit Test Case'">
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
                    {{-- Test Case Name --}}
                    <x-input-field label='Test Case Name' model='tc_name' type='text' required='true' />

                    {{-- Test Case Description --}}
                    <x-textarea class="mt-4" label='Description' model='tc_description' required='true'
                        rows='5'></x-textarea>

                    <div class="mt-4 grid md:grid-cols-2 gap-4">
                        {{-- Status --}}
                        <x-single-select-box label='Status' model='tc_status'>
                            <option value="pending">Pending Approval</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </x-single-select-box>

                        {{-- Approval Request --}}
                        <x-single-select-box label='Aproval from' model='tc_approval_from'>
                            <option value="">Select</option>
                            <option value="">User 1</option>
                            <option value="">User 2</option>
                        </x-single-select-box>
                    </div>

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

                        <div x-show="open" class="mt-4" x-collapse.duration.300ms>
                            <div class="grid md:grid-cols-2 gap-4">
                                {{-- Build ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Build</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center gap-2 px-4 py-2 rounded-md border dark:border-gray-700"
                                            :class="open_model ? 'outline-2' : ''">
                                            <div class="w-full flex items-center justify-between gap-2 overflow-hidden">
                                                <span @click="open_model = !open_model"
                                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                                    x-text="$wire.tc_build_id ? $wire.form_selected_build_name : 'Select build'"></span>
                                                <button x-show='$wire.tc_build_id' wire:click='resetBuildID'
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
                                    @error('tc_build_id')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Module ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Module</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center gap-2 px-4 py-2 rounded-md border dark:border-gray-700 "
                                            :class="open_model ? 'outline-2' : ''">
                                            <div
                                                class="w-full flex items-center justify-between gap-2 overflow-hidden">
                                                <span @click="open_model = !open_model"
                                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                                    x-text="$wire.tc_module_id ? $wire.form_selected_module_name : 'Select module'"></span>
                                                <button x-show='$wire.tc_module_id' wire:click='resetModuleID'
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
                                    @error('tc_module_id')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Requirement ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Requirement</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center gap-2 px-4 py-2 rounded-md border dark:border-gray-700 "
                                            :class="open_model ? 'outline-2' : ''">
                                            <div
                                                class="w-full flex items-center justify-between gap-2 overflow-hidden">
                                                <span @click="open_model = !open_model"
                                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                                    x-text="$wire.tc_requirement_id ? $wire.form_selected_requirement_name : 'Select requirement'"></span>
                                                <button x-show='$wire.tc_requirement_id'
                                                    wire:click='resetRequirementID' class="cursor-pointer"
                                                    type="button">
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
                                    @error('tc_requirement_id')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Test Scenario ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Test Scenario</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center gap-2 px-4 py-2 rounded-md border dark:border-gray-700 "
                                            :class="open_model ? 'outline-2' : ''">
                                            <div
                                                class="w-full flex items-center justify-between gap-2 overflow-hidden">
                                                <span @click="open_model = !open_model"
                                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                                    x-text="$wire.tc_test_scenario_id ? $wire.form_selected_test_scenario_name : 'Select test scenario'"></span>
                                                <button x-show='$wire.tc_test_scenario_id'
                                                    wire:click='resetTestScenarioID' class="cursor-pointer"
                                                    type="button">
                                                    <i wire:loading.remove wire:target='resetTestScenarioID'
                                                        class="fa-solid fa-xmark"></i>
                                                    <i wire:loading wire:target='resetTestScenarioID'
                                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </button>
                                            </div>
                                            <div class="text-gray-500 ml-3">
                                                <i @click="open_model = !open_model" wire:loading.remove
                                                    wire:target='assignTestScenarioID' class="fa-solid"
                                                    :class="open_model ? 'fa-angle-up' : 'fa-angle-down'"></i>
                                                <i wire:loading wire:target='assignTestScenarioID'
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
                                                <input wire:model.live.debounce.300='form_search_test_scenario'
                                                    type="text" name="search"
                                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                                    placeholder="Type to search">
                                                <div wire:loading wire:target="form_search_test_scenario"
                                                    class="ml-2">
                                                    <i class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                                </div>
                                            </div>
                                            <div>
                                                @forelse ($form_test_scenarios as $test_scenario)
                                                    <button wire:key='{{ $test_scenario->id }}' type="button"
                                                        wire:click = 'assignTestScenarioID({{ $test_scenario }})'
                                                        @click = 'open_model = false'
                                                        class="flex items-center justify-between py-2 px-4 hover:bg-gray-800 hover:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-900 text-left w-full">
                                                        {{ $test_scenario->ts_name }}
                                                    </button>
                                                @empty
                                                    <p class="py-2 px-4 text-left w-full">
                                                        No records found</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    @error('tc_test_scenario_id')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Testing Type --}}
                                <x-single-select-box label='Testing Type' model='tc_testing_type'>
                                    <option value="">Select</option>
                                    <option value="field-validation">Field Validation</option>
                                    <option value="content">Content</option>
                                    <option value="cross-browser/os">Cross Browser/OS</option>
                                    <option value="ui/ux">UI/UX</option>
                                    <option value="security">Security</option>
                                    <option value="performance">Performance</option>
                                    <option value="functional">Functional</option>
                                </x-single-select-box>

                                {{-- Estimate Time --}}
                                <div class="flex flex-col gap-1">
                                    <label class="flex items-end justify-between" for="tc_estimate_time">Estimate Time
                                        <span class="text-xs">(HH:MM)</span></label>
                                    {{-- input component here --}}
                                    @error('tc_estimate_time')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Pre Conditions --}}
                                <x-textarea label='Pre Conditions' model='tc_pre_conditions' rows='5'
                                    class="col-span-full"></x-textarea>

                                {{-- Detailed Steps --}}
                                <x-textarea label='Detailed Steps' model='tc_detailed_steps' rows='5'
                                    class="col-span-full"></x-textarea>

                                {{-- Expected Result --}}
                                <x-textarea label='Expected Result' model='tc_expected_result' rows='5'
                                    class="col-span-full"></x-textarea>

                                {{-- Post Conditions --}}
                                <x-textarea label='Post Conditions' model='tc_post_conditions' rows='5'
                                    class="col-span-full"></x-textarea>

                                {{-- Execution Type --}}
                                <x-single-select-box label='Execution Type' model='tc_execution_type'>
                                    <option value="">Select</option>
                                    <option value="cypress">Cypres</option>
                                    <option value="automated">Automated</option>
                                    <option value="manual">Manual</option>
                                </x-single-select-box>

                                {{-- Priority --}}
                                <x-single-select-box label='Priority' model='tc_priority'>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </x-single-select-box>

                                {{-- Assign To --}}
                                <x-single-select-box label='Assign To' model='tc_assigned_to'>
                                    <option value="">Select</option>
                                </x-single-select-box>

                                {{-- Comments --}}
                                <x-textarea label='Comment' model='tc_comment' rows='5'
                                    class="col-span-full"></x-textarea>

                                {{-- Attachments --}}
                                <div class="flex flex-col gap-1 col-span-full">
                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <label for="">Attachments</label>
                                        <div class="flex items-center justify-center w-full mt-1">
                                            <label for="attachments"
                                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:hover:bg-gray-800 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                                                @drop.prevent="$wire.uploadMultiple('attachments', $event.dataTransfer.files)"
                                                @dragover.prevent>
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                            class="font-semibold">Click to upload</span>
                                                        or drag and drop</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 text-xs">
                                                        only
                                                        gif |
                                                        jpg | png | jpeg | pdf | docx | csv |
                                                        xls | ppt | mp4 | webm | msg | eml files are allowed.
                                                    </p>
                                                </div>
                                                <input wire:model.live="tempAttachments" id="attachments"
                                                    type="file" class="hidden" multiple
                                                    accept=".gif,.jpg,.jpeg,.png,.pdf,.docx,.csv,.xls,.ppt,.mp4,.webm,.msg,.eml">
                                            </label>
                                        </div>
                                        @if ($edit)
                                            <span>Please visit the test case detail page to view and edit previous
                                                attachments.</span>
                                        @endif
                                        @error('tempAttachments.*')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <div x-show="isUploading" class="mt-4">
                                            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                                    x-bind:style="{ width: progress + '%' }">
                                                    <span x-text="progress + '%'"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        @if (!empty($uploadedAttachments))
                                            <div class="">
                                                @foreach ($uploadedAttachments as $index => $attachment)
                                                    <div wire:key='index'
                                                        class="flex items-center justify-between gap-4 mt-2 w-full px-4 p-2 rounded-md bg-gray-100 dark:bg-gray-800">
                                                        @if (in_array($attachment->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img class="h-10 w-10 rounded-sm"
                                                                src="{{ $attachment->temporaryUrl() }}"
                                                                alt="">
                                                        @elseif (in_array($attachment->getClientOriginalExtension(), ['pdf']))
                                                            <i class="fa-solid fa-file-pdf text-3xl text-red-500"></i>
                                                        @elseif (in_array($attachment->getClientOriginalExtension(), ['doc', 'docx']))
                                                            <i
                                                                class="fa-solid fa-file-word text-3xl text-blue-500"></i>
                                                        @elseif (in_array($attachment->getClientOriginalExtension(), ['xls', 'xlsx']))
                                                            <i
                                                                class="fa-solid fa-file-excel text-3xl text-green-500"></i>
                                                        @elseif (in_array($attachment->getClientOriginalExtension(), ['ppt', 'pptx']))
                                                            <i
                                                                class="fa-solid fa-file-powerpoint text-3xl text-orange-500"></i>
                                                        @elseif (in_array($attachment->getClientOriginalExtension(), ['mp4', 'webm']))
                                                            <i
                                                                class="fa-solid fa-file-video text-3xl text-purple-500"></i>
                                                        @elseif (in_array($attachment->getClientOriginalExtension(), ['csv']))
                                                            <i
                                                                class="fa-solid fa-file-csv text-3xl text-light-blue-500"></i>
                                                        @elseif (in_array($attachment->getClientOriginalExtension(), ['msg', 'eml']))
                                                            <i
                                                                class="fa-solid fa-envelope text-3xl text-yellow-500"></i>
                                                        @else
                                                            <i class="fa-solid fa-file text-3xl text-gray-500"></i>
                                                        @endif
                                                        <p class="w-full text-left text-ellipsis">
                                                            {{ $attachment->getClientOriginalName() }}</p>
                                                        <button wire:click="removeAttachment({{ $index }})"
                                                            type="button" class="text-red-500 cursor-pointer"><i
                                                                class="fa-solid fa-xmark"></i></button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div> {{-- Attachment end --}}
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
