{{-- Lazy-loading File Viewer Component --}}
<div x-data="{
    previewOpen: false,
    loaded: false,
    loadContent() {
        if (!this.loaded) {
            this.loaded = true;
            // Additional loading logic can go here if needed
        }
    }
}" class="w-full">
    <!-- File Card -->
    <div class="flex items-center justify-between dark:bg-gray-800">
        <div class="flex items-center gap-3 min-w-0 flex-1">
            <!-- File Icon -->
            <div class="p-2 rounded-lg bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>

            <!-- File Info -->
            <div class="min-w-0 flex-1">
                <p class="font-medium text-gray-900 dark:text-gray-100 truncate" title="{{ $fileName }}">
                    {{ $fileName }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ strtoupper($fileType) }}
                </p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2">
            @if(in_array($fileType, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'docx', 'ppt', 'xls', 'csv', 'mp4', 'webm']))
                <button @click="previewOpen = !previewOpen; loadContent()" type="button"
                        class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            @endif

            <a href="{{ $filePath }}"
               download="{{ $fileName }}"
               class="p-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Preview Panel - Content loads only when opened -->
    <div x-show="previewOpen"
         x-collapse.duration.300ms
         class="mt-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        <div class="p-3 flex justify-between items-center bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
            <h4 class="font-medium text-gray-900 dark:text-white">Preview</h4>
            <button @click="previewOpen = false" type="button" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-4">
            <!-- Loading State -->
            <template x-if="!loaded">
                <div class="flex justify-center items-center h-64">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
                </div>
            </template>

            <!-- Loaded Content -->
            <template x-if="loaded">
                <div>
                    @if(in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']))
                        <!-- Image Viewer -->
                        <img x-data x-intersect.once="$el.src = '{{ $filePath }}'"
                             alt="{{ $fileName }}"
                             class="max-w-full max-h-[400px] mx-auto rounded"
                             loading="lazy">

                    @elseif($fileType === 'pdf')
                        <!-- PDF Viewer -->
                        <iframe x-data x-intersect.once="$el.src = '{{ $filePath }}#toolbar=0'"
                                class="w-full h-[400px] border-0"
                                title="PDF Preview"
                                loading="lazy"></iframe>

                    @elseif(in_array($fileType, ['docx', 'ppt', 'xls', 'csv']))
                        <!-- Office Files Viewer -->
                        @if(filter_var($filePath, FILTER_VALIDATE_URL))
                            <iframe x-data x-intersect.once="$el.src = 'https://docs.google.com/gview?url={{ urlencode($filePath) }}&embedded=true'"
                                    class="w-full h-[400px] border-0"
                                    title="Document Preview"
                                    loading="lazy"></iframe>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">Preview not available for local office files</p>
                        @endif

                    @elseif(in_array($fileType, ['mp4', 'webm']))
                        <!-- Video Player -->
                        <video x-data x-intersect.once="$el.querySelector('source').src = '{{ $filePath }}'; $el.load()"
                               controls class="w-full max-h-[400px] mx-auto">
                            <source type="video/{{ $fileType }}">
                            Your browser does not support the video tag.
                        </video>

                    @else
                        <!-- Unsupported File Type -->
                        <div class="text-center py-6 text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2">Preview not available for {{ strtoupper($fileType) }} files</p>
                        </div>
                    @endif

                    <div class="mt-4 flex justify-end">
                        <a href="{{ $filePath }}"
                           download="{{ $fileName }}"
                           class="px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors">
                            Download
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
