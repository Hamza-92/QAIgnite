<div>
    <div class="px-8 py-4 flex items-center justify-between gap-4 border-b dark:border-gray-700">
        <h2 class="text-lg font-medium">Create New Test Case</h2>
        {{-- <a href="{{ route('test-cycles') }}" class="px-4 py-2 rounded-md bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 hover:dark:bg-blue-500 text-white">Cancel</a> --}}
    </div>

    {{-- form --}}
    <div class="p-8 space-y-6">
        <form wire:submit.prevent='save' class="space-y-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                {{-- Test Cycle Name --}}
                <x-input-field label='Test Cycle' model='name' type='text' required='true' />

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
                                    x-text="$wire.build_id ? $wire.form_selected_build_name : 'Select build'"></span>
                                <button x-show='$wire.build_id' wire:click='resetBuildID' class="cursor-pointer"
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
                    @error('build_id')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Assigne To --}}
                <div class="flex flex-col gap-1 w-full">
                    <label class="flex items-center gap-2">Assign To <i class="fa-solid fa-circle-info" title="Assign the execution cycle to your team members."></i></label>
                    <div x-data='{open_model : false}' class="relative w-full" @click.outside="open_model = false"
                        @close.stop="open_model = false">
                        <div class="relative px-4 py-2 rounded-md border dark:border-gray-700"
                            :class="open_model ? 'outline-2' : ''">
                            <div class="w-full flex flex-wrap items-center justify-start gap-2">
                                @forelse ($form_selected_users as $user)
                                    <div wire:key='{{ $user["id"] }}' class="flex gap-2 bg-gray-100 dark:bg-gray-800 py-1 px-2 rounded-sm">
                                        <span class="border-r dark:border-gray-700">{{$user['username']}}</span>
                                        <button type="button" wire:click='removeUser({{ $user["id"] }})'>
                                            <i wire:loading.remove wire:target='removeUser({{ $user["id"] }})' class="fa-solid fa-xmark"></i>
                                            <i wire:loading wire:target='removeUser({{ $user["id"] }})' class="fa-solid fa-spinner fa-spin"></i>
                                        </button>
                                    </div>
                                @empty
                                    <span @click="open_model = !open_model">Select users</span>
                                @endforelse
                                <span class="flex-1 py-2" @click="open_model = !open_model"></span>
                            </div>
                            <div class="absolute right-3 top-2 text-gray-500">
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
                                <input wire:model.live.debounce.300='form_search_user' type="text" name="search"
                                    class="w-full text-sm outline-none focus:outline-none border-none focus:border-none focus:ring-none"
                                    placeholder="Type to search">
                                <div wire:loading wire:target="form_search_user" class="ml-2">
                                    <i class="fa-solid fa-spinner fa-spin text-gray-500"></i>
                                </div>
                            </div>
                            <div>
                                @forelse ($form_users as $user)
                                    <button wire:key='{{ $user->id }}' id="{{ $user->id }}" type="button"
                                        wire:click = "assignUser({{ $user }})"

                                        class="flex items-center justify-between py-2 px-4 hover:bg-gray-800 hover:text-gray-200 dark:hover:bg-gray-300 dark:hover:text-gray-900 text-left w-full">
                                        {{ $user->username }}
                                        @if(in_array($user->id, $assigned_to))
                                            <i class="fa-solid fa-check text-green-500"></i>
                                        @endif
                                    </button>
                                @empty
                                    <p class="py-2 px-4 text-left w-full">
                                        No records found</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @error('assigned_to')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div wire:ignore x-data x-init="flatpickr($refs.startDate, {
                    altInput: true,
                    altFormat: 'F j, Y',
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    onChange: function(selectedDates, dateStr) {
                        $dispatch('start-date-changed', dateStr)
                    }
                })">
                    <label for="start_date">Start Date</label>
                    <div class="relative">
                        <input x-ref="startDate" type="text"
                            class="mt-1 px-4 py-2 block w-full rounded-md border dark:border-gray-700"
                            wire:model.defer="start_date" />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fa-regular fa-calendar-days text-gray-500"></i>
                            </div>
                    </div>
                    @error('start_date')
                        <span class="text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div wire:ignore x-data="{ endPicker: null, minDate: @entangle('start_date') }" x-init="endPicker = flatpickr($refs.endDate, {
                    altInput: true,
                    altFormat: 'F j, Y',
                    dateFormat: 'Y-m-d',
                    minDate: minDate,
                    onChange: function(selectedDates, dateStr) {
                        $dispatch('input', dateStr)
                    }
                });

                $watch('minDate', value => {
                    endPicker.set('minDate', value);
                });

                $el.addEventListener('start-date-changed', e => {
                    minDate = e.detail;
                });">
                    <label for="end_date">End Date</label>
                    <div class="relative">
                        <input x-ref="endDate" type="text"
                            class="mt-1 px-4 py-2 block w-full rounded-md border dark:border-gray-700 pr-10"
                            wire:model.defer="end_date" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fa-regular fa-calendar-days text-gray-500"></i>
                        </div>
                    </div>
                    @error('end_date')
                        <span class="text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="flex gap-2 items-center">Cycle Visibility <i class="fa-solid fa-circle-info" title="By checking this, only the tester role will be able to view and execute the test cases assigned in that cycle."></i></label>
                    <div class="mt-1 py-2 flex gap-2 items-center">
                        <input type="checkbox" name="visibility" id="visibility" wire:model='visibility'>
                        <label for="visibility">Make this cycle only visible to assignees</label>
                    </div>
                    @error('visibility')
                        <span class="text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <x-textarea label='Description' class="col-span-full" model='description' rows='7'></x-textarea>
            </div>

            <div class="py-16 flex items-center justify-center gap-4">
                <button type="submit" wire:loading.attr='disabled'
                class="px-6 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 text-white text-lg font-medium cursor-pointer rounded-md">
                    <i class="fa-solid fa-plus"></i>  Save <i wire:loading wire:target='save' class="fa-solid fa-spinner fa-spin"></i>
                </button>
                <a href="{{ route('test-cycles') }}" wire:navigate
                class="px-6 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 text-lg font-medium cursor-pointer rounded-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
