<div>
    <div class="px-8 py-4 flex items-center flex-wrap gap-4 justify-between border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg">Requirement Management</h2>
        <button x-on:click="$wire.create = true"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer"
            type="button">Create Requirement</button>
    </div>

    {{-- Data Table --}}
    <livewire:requirement.data-table wire:listen="refreshTable">

    {{-- Requirement Form --}}
    <div x-show='$wire.create || $wire.edit'
        class="absolute top-0 left-0 w-full h-full bg-gray-900/50 dark:bg-gray-100/50">
        <div
            class="absolute w-full h-full sm:w-auto sm:w-[640px] md:w-[720px] top-0 right-0 bg-white dark:bg-gray-900 overflow-auto">
            <div class="px-8 py-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg" x-text='$wire.create ? "Create new Requirement" : "Edit Requirement"'></h3>
                <button wire:click='resetForm' class="text-xl cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="flex flex-col p-8">
                <form wire:submit.prevent='save'>
                    {{-- Requirement Title --}}
                    <x-input-field label='Requirement Title' model='requirement_title' type='text' required='true'
                        autocomplete='requirement-title' />

                    {{-- Requirement Summary --}}
                    <x-textarea class="mt-4" label='Requirement Summary' model='requirement_summary'
                        required='true' />

                    {{-- Additional Details --}}
                    <div x-data="{ open: false }" class="mt-4">
                        <div @click="open = !open"
                            class="flex items-center justify-between bg-blue-500 hover:bg-blue-600 text-white dark:bg-blue-600 dark:hover:bg-blue-500 px-4 py-2 cursor-pointer">
                            <h4 class="text-md font-bold">Additional Details</h4>
                            <span class="px-2 py-1 bg-white font-bold text-gray-900" x-text='open ? "-" : "+"'>+</span>
                        </div>

                        <div x-show="open" class="mt-4">
                            <div class="grid grid-cols-2 gap-4">
                                {{-- Build ID --}}
                                <div class="flex flex-col gap-1 w-full">
                                    <label>Build ID</label>
                                    <div x-data='{open_model : false}' class="relative w-full"
                                        @click.outside="open_model = false" @close.stop="open_model = false">
                                        <div class="w-full flex items-center px-4 py-2 rounded-md border dark:border-gray-700"
                                            :class="open_model ? 'outline-2' : ''">
                                            <div class="w-full flex items-center justify-between gap-2">
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
                                            <div class="text-gray-500 ml-3">
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
                                        <div class="w-full flex items-center px-4 py-2 rounded-md border dark:border-gray-700 "
                                            :class="open_model ? 'outline-2' : ''">
                                            <div class="w-full flex items-center justify-between gap-2">
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
                                            <div class="text-gray-500 ml-3">
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

                                {{-- Requirement Type --}}
                                <x-single-select-box label='Requirement Type' model='requirement_type'>
                                    <option value="">Select type</option>
                                    <option value="Functional">Functional</option>
                                    <option value="UX/UI">UX/UI</option>
                                </x-single-select-box>

                                {{-- Requirement Source --}}
                                <x-input-field label='Requirement Source' model='requirement_source'
                                    placeholder='Source' />

                                {{-- Status --}}
                                <x-single-select-box label='Status' model='status'>
                                    <option value="">Select status</option>
                                    <option value="Backlog">Backlog</option>
                                    <option value="To Do">To Do</option>
                                    <option value="Design">Design</option>
                                    <option value="Development">Development</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Ready for Testing">Ready for Testing</option>
                                    <option value="Testing">Testing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Done">Done</option>
                                </x-single-select-box>

                                {{-- Assigned To --}}
                                <x-single-select-box label='Assigned To' model='assigned_to'>
                                    <option value="">Select viewer</option>
                                </x-single-select-box>

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
                                        @error('tempAttachments.*')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                        <div x-show="isUploading" class="mt-4">
                                            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" x-bind:style="{ width: progress + '%' }">
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
                                                            <i
                                                                class="fa-solid fa-file-pdf text-3xl text-red-500"></i>
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

                                {{-- Comments --}}
                                <x-textarea class="col-span-2" label='Comments' model='comment' rows='3' />
                            </div>
                        </div>
                    </div>

                    {{-- Form Footer --}}
                    <div class="flex items-center justify-center gap-4 mt-8">
                        <x-primary-button type='submit'>
                            Save <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i>
                        </x-primary-button>

                        <button wire:click='resetForm' type="button" id="cancelButton"
                            class="px-4 py-2 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-900 dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-gray-100">
                            Cancel <i wire:loading wire:target='resetForm' class="fa-solid fa-spinner fa-spin"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
