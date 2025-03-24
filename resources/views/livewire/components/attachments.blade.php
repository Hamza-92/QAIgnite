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
        @if (!empty($attachments))
            <div class="">
                @foreach ($attachments as $index => $attachment)
                    <div
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
                            type="button" class="text-red-500"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
