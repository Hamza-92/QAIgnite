<div>
    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('defects') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                    class="fa-solid fa-arrow-left"></i> Defects</a>
            <h2 class="text-lg font-medium mt-2">Edit Defect</h2>
        </div>

        <button type="button" wire:click='save' wire:loading.attr='disabled'
            wire:loading.class='cursor-not-allowed opacity-50'
            class="px-4 py-2 text-lg font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500">
            Update Defect
        </button>
    </div>

    <div class="p-8 space-y-6">
        <form wire:submit.prevent='save' class="space-y-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                {{-- Build ID --}}
                <div class="flex flex-col gap-1 w-full">
                    <label>Build</label>
                    <div x-data='{open_model : false}' class="relative w-full" @click.outside="open_model = false"
                        @close.stop="open_model = false">
                        <div class="w-full flex items-center px-4 py-2 rounded-md border dark:border-gray-700"
                            :class="open_model ? 'outline-2' : ''">
                            <div class="w-full flex items-center justify-between gap-2">
                                <span @click="open_model = !open_model"
                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                    x-text="$wire.defect_build_id ? $wire.form_selected_build_name : 'Select build'"></span>
                                <button x-show='$wire.defect_build_id' wire:click='resetBuildID' class="cursor-pointer"
                                    type="button">
                                    <i wire:loading.remove wire:target='resetBuildID' class="fa-solid fa-xmark"></i>
                                    <i wire:loading wire:target='resetBuildID'
                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                </button>
                            </div>
                            <div class="text-gray-500 ml-3">
                                <i @click="open_model = !open_model" wire:loading.remove wire:target='assignBuildID'
                                    class="fa-solid" :class="open_model ? 'fa-angle-up' : 'fa-angle-down'"></i>
                                <i wire:loading wire:target='assignBuildID' class="fa-solid fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-10 mt-2 w-full shadow-lg rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 max-h-72 overflow-auto">
                            <div class="border-b dark:border-gray-700 flex items-center px-4 py-3">
                                <input wire:model.live.debounce.300='form_search_build' type="text" name="search"
                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                    placeholder="Type to search">
                                <div wire:loading wire:target="form_search_build" class="ml-2">
                                    <i class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                </div>
                            </div>
                            <div>
                                @forelse ($form_builds as $build)
                                    <button id="{{ $build->id }}" type="button"
                                        wire:click = 'assignBuildID({{ $build }})' @click = 'open_model = false'
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
                    @error('defect_build_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Module ID --}}
                <div class="flex flex-col gap-1 w-full">
                    <label>Module</label>
                    <div x-data='{open_model : false}' class="relative w-full" @click.outside="open_model = false"
                        @close.stop="open_model = false">
                        <div class="w-full flex items-center px-4 py-2 rounded-md border dark:border-gray-700 "
                            :class="open_model ? 'outline-2' : ''">
                            <div class="w-full flex items-center justify-between gap-2">
                                <span @click="open_model = !open_model"
                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                    x-text="$wire.defect_module_id ? $wire.form_selected_module_name : 'Select module'"></span>
                                <button x-show='$wire.defect_module_id' wire:click='resetModuleID'
                                    class="cursor-pointer" type="button">
                                    <i wire:loading.remove wire:target='resetModuleID' class="fa-solid fa-xmark"></i>
                                    <i wire:loading wire:target='resetModuleID'
                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                </button>
                            </div>
                            <div class="text-gray-500 ml-3">
                                <i @click="open_model = !open_model" wire:loading.remove wire:target='assignModuleID'
                                    class="fa-solid" :class="open_model ? 'fa-angle-up' : 'fa-angle-down'"></i>
                                <i wire:loading wire:target='assignModuleID' class="fa-solid fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        <div x-show='open_model' x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-10 mt-2 w-full shadow-lg rounded-lg border dark:border-gray-700 bg-white dark:bg-gray-900 max-h-72 overflow-auto">
                            <div class="border-b dark:border-gray-700 flex items-center px-4 py-2">
                                <input wire:model.live.debounce.300='form_search_module' type="text" name="search"
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
                    @error('defect_module_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Requirement ID --}}
                <div class="flex flex-col gap-1 w-full">
                    <label>Requirement</label>
                    <div x-data='{open_model : false}' class="relative w-full" @click.outside="open_model = false"
                        @close.stop="open_model = false">
                        <div class="w-full flex items-center px-4 py-2 rounded-md border dark:border-gray-700 "
                            :class="open_model ? 'outline-2' : ''">
                            <div class="w-full flex items-center justify-between gap-2">
                                <span @click="open_model = !open_model"
                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                    x-text="$wire.defect_requirement_id ? $wire.form_selected_requirement_name : 'Select requirement'"></span>
                                <button x-show='$wire.defect_requirement_id' wire:click='resetRequirementID'
                                    class="cursor-pointer" type="button">
                                    <i wire:loading.remove wire:target='resetRequirementID'
                                        class="fa-solid fa-xmark"></i>
                                    <i wire:loading wire:target='resetRequirementID'
                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                </button>
                            </div>
                            <div class="text-gray-500 ml-3">
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
                                <input wire:model.live.debounce.300='form_search_requirement' type="text"
                                    name="search"
                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                    placeholder="Type to search">
                                <div wire:loading wire:target="form_search_requirement" class="ml-2">
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
                    @error('defect_requirement_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Test Scenario ID --}}
                <div class="flex flex-col gap-1 w-full">
                    <label>Test Scenario</label>
                    <div x-data='{open_model : false}' class="relative w-full" @click.outside="open_model = false"
                        @close.stop="open_model = false">
                        <div class="w-full flex items-center px-4 py-2 rounded-md border dark:border-gray-700 "
                            :class="open_model ? 'outline-2' : ''">
                            <div class="w-full flex items-center justify-between gap-2">
                                <span @click="open_model = !open_model"
                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                    x-text="$wire.defect_test_scenario_id ? $wire.form_selected_test_scenario_name : 'Select test scenario'"></span>
                                <button x-show='$wire.defect_test_scenario_id' wire:click='resetTestScenarioID'
                                    class="cursor-pointer" type="button">
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
                                <input wire:model.live.debounce.300='form_search_test_scenario' type="text"
                                    name="search"
                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                    placeholder="Type to search">
                                <div wire:loading wire:target="form_search_test_scenario" class="ml-2">
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
                    @error('defect_test_scenario_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Test Case ID --}}
                <div class="flex flex-col gap-1 w-full">
                    <label>Test Case</label>
                    <div x-data='{open_model : false}' class="relative w-full" @click.outside="open_model = false"
                        @close.stop="open_model = false">
                        <div class="w-full flex items-center px-4 py-2 rounded-md border dark:border-gray-700 "
                            :class="open_model ? 'outline-2' : ''">
                            <div class="w-full flex items-center justify-between gap-2">
                                <span @click="open_model = !open_model"
                                    class="w-full overflow-ellipsis whitespace-nowrap overflow-hidden"
                                    x-text="$wire.defect_test_case_id ? $wire.form_selected_test_case_name : 'Select test case'"></span>
                                <button x-show='$wire.defect_test_case_id' wire:click='resetTestCaseID'
                                    class="cursor-pointer" type="button">
                                    <i wire:loading.remove wire:target='resetTestCaseID'
                                        class="fa-solid fa-xmark"></i>
                                    <i wire:loading wire:target='resetTestCaseID'
                                        class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                </button>
                            </div>
                            <div class="text-gray-500 ml-3">
                                <i @click="open_model = !open_model" wire:loading.remove
                                    wire:target='assignTestCaseID' class="fa-solid"
                                    :class="open_model ? 'fa-angle-up' : 'fa-angle-down'"></i>
                                <i wire:loading wire:target='assignTestCaseID'
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
                                <input wire:model.live.debounce.300='form_search_test_case' type="text"
                                    name="search"
                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                    placeholder="Type to search">
                                <div wire:loading wire:target="form_search_test_case" class="ml-2">
                                    <i class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                </div>
                            </div>
                            <div>
                                @forelse ($form_test_cases as $test_case)
                                    <button wire:key='{{ $test_case->id }}' type="button"
                                        wire:click = 'assignTestCaseID({{ $test_case }})'
                                        @click = 'open_model = false'
                                        class="flex items-center justify-between py-2 px-4 hover:bg-gray-800 hover:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-900 text-left w-full">
                                        {{ $test_case->tc_name }}
                                    </button>
                                @empty
                                    <p class="py-2 px-4 text-left w-full">
                                        No records found</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @error('defect_test_case_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Defect Type --}}
                <x-single-select-box label='Defect Type' model='defect_type'>
                    <option value="">Select</option>
                    <option value="functional">Functional</option>
                    <option value="ui/ux">UI/UX</option>
                    <option value="cross-browser">Cross-Browser</option>
                    <option value="cross-platform">Cross-Platform</option>
                    <option value="field-validation">Field Validation</option>
                    <option value="performance">Performance</option>
                    <option value="security">Security</option>
                    <option value="usability">Usability</option>
                    <option value="compatibility">Compatibility</option>
                    <option value="integration">Integration</option>
                </x-single-select-box>

                {{-- Defect Status --}}
                <x-single-select-box label='Defect Status' model='defect_status'>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                    <option value="fixed">Fixed</option>
                    <option value="re-open">Re-Open</option>
                    <option value="not-a-bug">Not a Bug</option>
                    <option value="resolved">Resolved</option>
                    <option value="deffer">Deffer</option>
                    <option value="too-limitations">Too Limitations</option>
                    <option value="not-reproducible">Not Reproducible</option>
                    <option value="user-interface">User Interface</option>
                    <option value="beta">Beta</option>
                    <option value="in-progress">In Progress</option>
                    <option value="to-do">To Do</option>
                    <option value="in-review">In Review</option>
                </x-single-select-box>

                {{-- Defect Severity --}}
                <x-single-select-box label='Defect Severity' model='defect_severity'>
                    <option value="blocker">Blocker</option>
                    <option value="major">Major</option>
                    <option value="minor">Minor</option>
                </x-single-select-box>

                {{-- Defect Name --}}
                <x-input-field label='Defect ID' model='defect_name' type='text' required='true'
                    class="mt-4 col-span-full" />

                {{-- Defect Description --}}
                <x-textarea class="mt-4 col-span-full" label='Short Summary' model='defect_description'
                    required='true' rows='3'></x-textarea>

                {{-- Steps To Reproduce --}}
                <x-textarea class="mt-4 col-span-full" label='Steps to Reproduce' model='defect_steps_to_reproduce'
                    rows='5'></x-textarea>
            </div>
            {{-- Additional Details --}}
            <div x-data="{ open: false }" class="mt-4">
                <div @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-2 cursor-pointer text-white bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 transition-colors duration-300 rounded-t-lg"
                    :class="{ 'rounded-lg': !open }">
                    <h3 class="text-lg font-medium">Additional Details</h3>
                    <span class="px-2 py-1 bg-white text-gray-900 font-bold rounded transition-transform duration-300"
                        :class="{ 'rotate-180': open }" x-text="open ? '−' : '+'"></span>
                </div>

                <div x-show="open" class="mt-4" x-collapse.duration.300ms
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                        {{-- Defect Priority --}}
                        <x-single-select-box label='Defect Priority' model='defect_priority'>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </x-single-select-box>

                        {{-- Defect Environment --}}
                        <x-single-select-box label='Defect Environment' model='defect_environment'>
                            <option value="">Select</option>
                            <option value="production">Production</option>
                            <option value="staging">Staging</option>
                            <option value="development">Development</option>
                            <option value="testing">Testing</option>
                            <option value="qa">QA</option>
                        </x-single-select-box>

                        {{-- Assigned To --}}
                        <x-single-select-box label='Assigned To' model='defect_assigned_to'>
                            <option value="">Select</option>
                        </x-single-select-box>

                        {{-- Actual Result --}}
                        <x-textarea label='Actual Result' model='defect_actual_result' rows='5'
                            class="col-span-full" />

                        {{-- Expected Result --}}
                        <x-textarea label='Expected Result' model='defect_expected_result' rows='5'
                            class="col-span-full" />

                        {{-- Comment --}}
                        <x-textarea label='Comment' model='comment' rows='5' class="col-span-full" />

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
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 16">
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
                                        <input wire:model.live="tempAttachments" id="attachments" type="file"
                                            class="hidden" multiple
                                            accept=".gif,.jpg,.jpeg,.png,.pdf,.docx,.csv,.xls,.ppt,.mp4,.webm,.msg,.eml">
                                    </label>
                                </div>
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
                                                        src="{{ $attachment->temporaryUrl() }}" alt="">
                                                @elseif (in_array($attachment->getClientOriginalExtension(), ['pdf']))
                                                    <i class="fa-solid fa-file-pdf text-3xl text-red-500"></i>
                                                @elseif (in_array($attachment->getClientOriginalExtension(), ['doc', 'docx']))
                                                    <i class="fa-solid fa-file-word text-3xl text-blue-500"></i>
                                                @elseif (in_array($attachment->getClientOriginalExtension(), ['xls', 'xlsx']))
                                                    <i class="fa-solid fa-file-excel text-3xl text-green-500"></i>
                                                @elseif (in_array($attachment->getClientOriginalExtension(), ['ppt', 'pptx']))
                                                    <i
                                                        class="fa-solid fa-file-powerpoint text-3xl text-orange-500"></i>
                                                @elseif (in_array($attachment->getClientOriginalExtension(), ['mp4', 'webm']))
                                                    <i class="fa-solid fa-file-video text-3xl text-purple-500"></i>
                                                @elseif (in_array($attachment->getClientOriginalExtension(), ['csv']))
                                                    <i class="fa-solid fa-file-csv text-3xl text-light-blue-500"></i>
                                                @elseif (in_array($attachment->getClientOriginalExtension(), ['msg', 'eml']))
                                                    <i class="fa-solid fa-envelope text-3xl text-yellow-500"></i>
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

            <div x-data="{ activeTab: 'attachments' }" class="w-full mt-16">
                <!-- Tab Headers -->
                <div class="flex gap-1 border-b dark:border-gray-700">
                    <button @click="activeTab = 'attachments'" type="button"
                        :class="{ 'bg-blue-500 text-white': activeTab === 'attachments', 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300': activeTab !== 'attachments' }"
                        class="px-4 py-2 font-medium rounded-t-lg transition-colors duration-300">
                        Attachments
                    </button>
                    <button @click="activeTab = 'comments'" type="button"
                        :class="{ 'bg-blue-500 text-white': activeTab === 'comments', 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300': activeTab !== 'comments' }"
                        class="px-4 py-2 font-medium rounded-t-lg transition-colors duration-300">
                        Comments
                    </button>
                    <button @click="activeTab = 'history'" type="button"
                        :class="{ 'bg-blue-500 text-white': activeTab === 'history', 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300': activeTab !== 'history' }"
                        class="px-4 py-2 font-medium rounded-t-lg transition-colors duration-300">
                        Version History
                    </button>
                </div>

                <!-- Tab Contents -->
                <div class="border dark:border-gray-700 rounded-b-lg p-4">
                    <!-- Attachments Tab -->
                    <div x-show="activeTab === 'attachments'" x-transition>
                        <div class="p-4 space-y-3 overflow-y-auto">
                            @forelse ($attachments as $attachment)
                                <div class="bg-gray-100 dark:bg-gray-800 rounded-md p-3 transition-all duration-300 shadow-sm hover:shadow-md"
                                    x-data x-intersect="$el.classList.add('animate-fade-in')">
                                    <x-file-viewer :file="$attachment" :isPrivate="true" />
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 dark:text-gray-400 animate-fade-in">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <p>No attachments available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Comments Tab -->
                    <div x-show="activeTab === 'comments'" x-transition>
                        <div class="py-4 flex flex-col gap-3 max-h-[500px] overflow-y-auto pr-2">
                            @foreach ($defect->comments as $comment)
                                <div wire:key='{{ $comment->id }}'
                                    class="bg-gray-100 dark:bg-gray-800 rounded-md px-4 py-3 transition-all duration-300 shadow-sm hover:shadow-md"
                                    x-data x-intersect="$el.classList.add('animate-fade-in')">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <p class=" text-gray-700 dark:text-gray-300">
                                                {{ $comment->user->username }}</p>
                                            <span
                                                class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-500">
                                            {{ $comment->created_at->format('M j, Y, g:i a') }}
                                        </p>
                                    </div>
                                    <p class="mt-2 font-normal text-gray-800 dark:text-gray-200">
                                        {{ $comment->comment }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Version History Tab -->
                    <div x-show="activeTab === 'history'" x-transition>
                        <div class="flex flex-col gap-3 overflow-hidden mt-3">
                            <!-- Version History Items -->
                            @foreach ($defect_versions as $index => $previousVersion)
                                @if ($index === 0)
                                    @continue
                                @endif

                                @php
                                    $version = $index > 0 ? $defect_versions[intval($index) - 1] : null;
                                @endphp

                                <div class="bg-gray-100 dark:bg-gray-800 shadow-sm rounded-md px-4 py-3 transition-all duration-300"
                                    x-data="{ showDetails: {{ $index === 1 ? 'true' : 'false' }} }">
                                    <!-- Version Header -->
                                    <div class="flex items-center justify-between text-gray-500 mb-3 cursor-pointer"
                                        @click="showDetails = !showDetails">
                                        <p>Modified by {{ $version->createdBy->name }}</p>
                                        <div class="flex items-center gap-3">
                                            <span class="transition-transform duration-300"
                                                :class="{ 'rotate-180': showDetails }">▼</span>
                                        </div>
                                        <p>{{ $version->created_at->format('M j, Y, g:i a') }}</p>
                                    </div>

                                    <!-- Version Details -->
                                    <div x-show="showDetails" x-collapse.duration.300ms class="space-y-3"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 max-h-0"
                                        x-transition:enter-end="opacity-100 max-h-screen"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 max-h-screen"
                                        x-transition:leave-end="opacity-0 max-h-0">
                                        <!-- Defect ID -->
                                        @if ($version->def_name !== $previousVersion->def_name)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Dfect ID',
                                                'current' => $version->def_name ?? 'None',
                                                'previous' => $previousVersion->def_name ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Description -->
                                        @if ($version->def_description !== $previousVersion->def_description)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Description',
                                                'current' => $version->def_description ?? 'None',
                                                'previous' => $previousVersion->def_description ?? 'None',
                                            ])
                                        @endif
                                        <!-- Build ID -->
                                        @if ($version->build?->id !== $previousVersion->build?->id)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Build ID',
                                                'current' => $version->build->name ?? 'None',
                                                'previous' => $previousVersion->build->name ?? 'None',
                                            ])
                                        @endif
                                        <!-- Module ID -->
                                        @if ($version->module?->id !== $previousVersion->module?->id)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Module ID',
                                                'current' => $version->module->module_name ?? 'None',
                                                'previous' => $previousVersion->module->module_name ?? 'None',
                                            ])
                                        @endif

                                        <!-- Requirement ID -->
                                        @if ($version->requirement?->id !== $previousVersion->requirement?->id)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Requirement ID',
                                                'current' => $version->requirement->requirement_title ?? 'None',
                                                'previous' =>
                                                    $previousVersion->requirement->requirement_title ?? 'None',
                                            ])
                                        @endif
                                        <!-- Test Scenario ID -->
                                        @if ($version->testScenario?->id !== $previousVersion->testScenario?->id)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Test Scenario ID',
                                                'current' => $version->testScenario->ts_name ?? 'None',
                                                'previous' => $previousVersion->testScenario->ts_name ?? 'None',
                                            ])
                                        @endif
                                        <!-- Test Case ID -->
                                        @if ($version->testCase?->id !== $previousVersion->testCase?->id)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Test Case ID',
                                                'current' => $version->testCase->tc_name ?? 'None',
                                                'previous' => $previousVersion->testCase->tc_name ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Steps to Reproduce -->
                                        @if ($version->def_steps_to_reproduce !== $previousVersion->def_steps_to_reproduce)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Steps to Reproduce',
                                                'current' => $version->def_steps_to_reproduce ?? 'None',
                                                'previous' => $previousVersion->def_steps_to_reproduce ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Expected Result -->
                                        @if ($version->def_expected_result !== $previousVersion->def_expected_result)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Expected Result',
                                                'current' => $version->def_expected_result ?? 'None',
                                                'previous' => $previousVersion->def_expected_result ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Actual Result -->
                                        @if ($version->def_actual_result !== $previousVersion->def_actual_result)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Actual Result',
                                                'current' => $version->def_actual_result ?? 'None',
                                                'previous' => $previousVersion->def_actual_result ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Type -->
                                        @if ($version->def_type !== $previousVersion->def_type)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Defect Type',
                                                'current' => $version->def_type ?? 'None',
                                                'previous' => $previousVersion->def_type ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Status -->
                                        @if ($version->def_status !== $previousVersion->def_status)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Status',
                                                'current' => $version->def_status ?? 'None',
                                                'previous' => $previousVersion->def_status ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Severity -->
                                        @if ($version->def_severity !== $previousVersion->def_severity)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Severity',
                                                'current' => $version->def_severity ?? 'None',
                                                'previous' => $previousVersion->def_severity ?? 'None',
                                            ])
                                        @endif
                                        <!-- Defect Priority -->
                                        @if ($version->def_priority !== $previousVersion->def_priority)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Priority',
                                                'current' => $version->def_priority ?? 'None',
                                                'previous' => $previousVersion->def_priority ?? 'None',
                                            ])
                                        @endif
                                        <!-- Assigned To -->
                                        @if ($version->assignedTo?->id !== $previousVersion->assignedTo?->id)
                                            @include('livewire.defect.partials.version-diff', [
                                                'field' => 'Assigned To',
                                                'current' => $version->assignedTo->username ?? 'None',
                                                'previous' => $previousVersion->assignedTo->username ?? 'None',
                                            ])
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-4 mt-8">
                <a href="{{ route('defects') }}"
                    class="px-4 py-2 text-lg font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" wire:loading.attr='disabled'
            wire:loading.class='cursor-not-allowed opacity-50'
                    class="px-4 py-2 text-lg font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500">
                    Update Defect
                </button>
            </div>
        </form>
    </div>
</div>
