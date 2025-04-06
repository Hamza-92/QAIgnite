<div>
    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('test-cases') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                    class="fa-solid fa-arrow-left"></i> Test Cases</a>
            <h2 class="text-lg font-medium mt-2">Edit Test Case</h2>
        </div>
    </div>

    <div class="p-8 space-y-6">
        <form wire:submit.prevent='save' class="space-y-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
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
                                    x-text="$wire.tc_build_id ? $wire.form_selected_build_name : 'Select build'"></span>
                                <button x-show='$wire.tc_build_id' wire:click='resetBuildID' class="cursor-pointer"
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
                    @error('tc_build_id')
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
                                    x-text="$wire.tc_module_id ? $wire.form_selected_module_name : 'Select module'"></span>
                                <button x-show='$wire.tc_module_id' wire:click='resetModuleID' class="cursor-pointer"
                                    type="button">
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
                    @error('tc_module_id')
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
                                    x-text="$wire.tc_requirement_id ? $wire.form_selected_requirement_name : 'Select requirement'"></span>
                                <button x-show='$wire.tc_requirement_id' wire:click='resetRequirementID'
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
                    @error('tc_requirement_id')
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
                                    x-text="$wire.tc_test_scenario_id ? $wire.form_selected_test_scenario_name : 'Select test scenario'"></span>
                                <button x-show='$wire.tc_test_scenario_id' wire:click='resetTestScenarioID'
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
                    @error('tc_test_scenario_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- Test Case Name --}}
            <x-input-field label='Test Case' model='tc_name' type='text' required='true' />
            {{-- Test Case Description --}}
            <x-textarea label='Summary' model='tc_description' required='true' rows='5'></x-textarea>
            <div class="mt-4 grid md:grid-cols-2 gap-6">
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
                    <div class="grid md:grid-cols-2 gap-6">
                        {{-- Pre Conditions --}}
                        <x-textarea label='Pre Conditions' model='tc_pre_conditions' rows='5'
                            class="col-span-2"></x-textarea>
                        {{-- Detailed Steps --}}
                        <x-textarea label='Detailed Steps' model='tc_detailed_steps' rows='5'
                            class="col-span-2"></x-textarea>
                        {{-- Expected Result --}}
                        <x-textarea label='Expected Result' model='tc_expected_result' rows='5'
                            class="col-span-2"></x-textarea>
                        {{-- Post Conditions --}}
                        <x-textarea label='Post Conditions' model='tc_post_conditions' rows='5'
                            class="col-span-2"></x-textarea>
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
                            <input type="text" name="tc_estimate_time" id="tc_estimate_time"
                                class="px-4 py-2 rounded-md border dark:border-gray-700" x-data="{
                                    displayValue: '00:00',
                                    init() {
                                        // Convert backend minutes to HH:MM on init
                                        const backendMinutes = {{ $tc_estimate_time ?? 0 }};
                                        const hours = Math.floor(backendMinutes / 60).toString().padStart(2, '0');
                                        const minutes = (backendMinutes % 60).toString().padStart(2, '0');
                                        this.displayValue = `${hours}:${minutes}`;
                                        this.$el.value = this.displayValue;
                                    }
                                }"
                                x-model="displayValue"
                                x-on:input="
                // Filter non-digit characters
                let value = $event.target.value.replace(/[^\d]/g, '');

                // Auto-insert colon after 2 digits
                if (value.length > 2 && !value.includes(':')) {
            value = value.substring(0, 2) + ':' + value.substring(2);
                }

                // Limit to 5 characters (HH:MM)
                value = value.substring(0, 5);

                // Update display value
                this.displayValue = value;
                $event.target.value = value;
            "
                                x-on:blur="
                // Validate and format on blur
                const [hoursStr = '0', minutesStr = '0'] = this.displayValue.split(':');
                const hours = Math.min(parseInt(hoursStr) || 0, 23);
                const minutes = Math.min(parseInt(minutesStr) || 0, 59);

                // Format display value
                this.displayValue =
            hours.toString().padStart(2, '0') + ':' +
            minutes.toString().padStart(2, '0');
                $event.target.value = this.displayValue;

                // Convert to minutes and update backend
                const totalMinutes = (hours * 60) + minutes;
                $wire.set('tc_estimate_time', totalMinutes, false);
            "
                                placeholder="00:00">
                            @error('tc_estimate_time')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
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
                            class="col-span-2"></x-textarea>
                        {{-- Attachments --}}
                        <div class="flex flex-col gap-1 col-span-2">
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


            <div x-data="{ activeTab: 'attachments' }" class="w-full mt-8">
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
                            @foreach ($test_case->comments as $comment)
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
                            @foreach ($test_case_versions as $index => $version)
                                @if ($index === 0)
                                    @continue
                                @endif

                                @php
                                    $previousVersion = $index > 0 ? $test_case_versions[$index - 1] : null;
                                @endphp

                                <div class="bg-gray-100 dark:bg-gray-800 shadow-sm rounded-md px-4 py-3 transition-all duration-300"
                                    x-data="{ showDetails: {{ $index === 1 ? 'true' : 'false' }} }">
                                    <!-- Version Header -->
                                    <div class="flex items-center justify-between text-gray-500 mb-3 cursor-pointer"
                                        @click="showDetails = !showDetails">
                                        <p>Modified by {{ $version->created_by->name }}</p>
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
                                        <!-- Build ID -->
                                        @if ($version->build?->id !== $previousVersion->build?->id)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Build ID',
                                                'current' => $version->build->name ?? 'None',
                                                'previous' => $previousVersion->build->name ?? 'None',
                                            ])
                                        @endif

                                        <!-- Module ID -->
                                        @if ($version->module?->id !== $previousVersion->module?->id)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Module ID',
                                                'current' => $version->module->module_name ?? 'None',
                                                'previous' => $previousVersion->module->module_name ?? 'None',
                                            ])
                                        @endif

                                        <!-- Requirement ID -->
                                        @if ($version->requirement?->id !== $previousVersion->requirement?->id)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Requirement ID',
                                                'current' => $version->requirement->requirement_title ?? 'None',
                                                'previous' =>
                                                    $previousVersion->requirement->requirement_title ?? 'None',
                                            ])
                                        @endif
                                        <!-- Test Scenario ID -->
                                        @if ($version->test_scenario?->id !== $previousVersion->test_scenario?->id)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Test Scenario ID',
                                                'current' => $version->test_scenario->ts_name ?? 'None',
                                                'previous' => $previousVersion->test_scenario->ts_name ?? 'None',
                                            ])
                                        @endif
                                        <!-- Test Scenario Summary -->
                                        @if ($version->test_scenario?->ts_description !== $previousVersion->test_scenario?->ts_description)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Test Scenario Summary',
                                                'current' => $version->test_scenario->ts_description ?? 'None',
                                                'previous' =>
                                                    $previousVersion->test_scenario->ts_description ?? 'None',
                                            ])
                                        @endif
                                        <!-- Test Case Description -->
                                        @if ($version->tc_description !== $previousVersion->tc_description)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Test Case Description',
                                                'current' => $version->tc_description ?? 'None',
                                                'previous' => $previousVersion->tc_description ?? 'None',
                                            ])
                                        @endif
                                        <!-- Pre Conditions -->
                                        @if ($version->tc_preconditions !== $previousVersion->tc_preconditions)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Pre Conditions',
                                                'current' => $version->tc_preconditions ?? 'None',
                                                'previous' => $previousVersion->tc_preconditions ?? 'None',
                                            ])
                                        @endif
                                        <!-- Detailed Steps -->
                                        @if ($version->tc_detailed_steps !== $previousVersion->tc_detailed_steps)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Detailed Steps',
                                                'current' => $version->tc_detailed_steps ?? 'None',
                                                'previous' => $previousVersion->tc_detailed_steps ?? 'None',
                                            ])
                                        @endif
                                        <!-- Expected Result -->
                                        @if ($version->tc_expected_results !== $previousVersion->tc_expected_results)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Expected Result',
                                                'current' => $version->tc_expected_results ?? 'None',
                                                'previous' => $previousVersion->tc_expected_results ?? 'None',
                                            ])
                                        @endif
                                        <!-- Post Conditions -->
                                        @if ($version->tc_post_conditions !== $previousVersion->tc_post_conditions)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Post Conditions',
                                                'current' => $version->tc_post_conditions ?? 'None',
                                                'previous' => $previousVersion->tc_post_conditions ?? 'None',
                                            ])
                                        @endif
                                        <!-- Estimate Time -->
                                        @if ($version->tc_estimated_time !== $previousVersion->tc_estimated_time)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Estimate Time',
                                                'current' => $version->tc_estimated_time ?? 'None',
                                                'previous' => $previousVersion->tc_estimated_time ?? 'None',
                                            ])
                                        @endif
                                        <!-- Testing Type -->
                                        @if ($version->tc_testing_type !== $previousVersion->tc_testing_type)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Testing Type',
                                                'current' => $version->tc_testing_type ?? 'None',
                                                'previous' => $previousVersion->tc_testing_type ?? 'None',
                                            ])
                                        @endif
                                        <!-- Execution Type -->
                                        @if ($version->tc_execution_type !== $previousVersion->tc_execution_type)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Execution Type',
                                                'current' => $version->tc_execution_type ?? 'None',
                                                'previous' => $previousVersion->tc_execution_type ?? 'None',
                                            ])
                                        @endif
                                        <!-- Status -->
                                        @if ($version->tc_status !== $previousVersion->tc_status)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Status',
                                                'current' => $version->tc_status ?? 'None',
                                                'previous' => $previousVersion->tc_status ?? 'None',
                                            ])
                                        @endif
                                        <!-- Priority -->
                                        @if ($version->tc_priority !== $previousVersion->tc_priority)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Priority',
                                                'current' => $version->tc_priority ?? 'None',
                                                'previous' => $previousVersion->tc_priority ?? 'None',
                                            ])
                                        @endif
                                        <!-- Assigned To -->
                                        @if ($version->assigned_to?->id !== $previousVersion->assigned_to?->id)
                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Assigned To',
                                                'current' => $version->assigned_to->username ?? 'None',
                                                'previous' => $previousVersion->assigned_to->username ?? 'None',
                                            ])
                                        @endif

                                        <!-- Attachments -->
                                        @if ($version->attachments != $previousVersion->attachments)
                                            @php
                                                // Format attachments for display
                                                $currentAttachments = is_array($version->attachments)
                                                    ? $version->attachments
                                                    : json_decode($version->attachments, true);
                                                $previousAttachments = $previousVersion
                                                    ? (is_array($previousVersion->attachments)
                                                        ? $previousVersion->attachments
                                                        : json_decode($previousVersion->attachments, true))
                                                    : [];

                                                // Create display strings
                                                $currentDisplay = !empty($currentAttachments)
                                                    ? implode(', ', $currentAttachments)
                                                    : 'None';
                                                $previousDisplay = !empty($previousAttachments)
                                                    ? implode(', ', $previousAttachments)
                                                    : 'None';
                                            @endphp

                                            @include('livewire.test-case.partials.version-diff', [
                                                'field' => 'Attachments',
                                                'current' => $currentDisplay,
                                                'previous' => $previousDisplay,
                                                'isAttachment' => true,
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
                <a
                    class="px-4 py-2 text-lg font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 text-lg font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500">
                    Update Test Case
                </button>
            </div>
        </form>
    </div>
</div>
