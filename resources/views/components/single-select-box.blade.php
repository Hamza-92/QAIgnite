<div class="flex flex-col gap-1 w-full {{$class}}">
    <label>{{$label}}
        @if ($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    <div class="relative">
        <select wire:model='{{$model}}' name="{{$model}}" id="{{$model}}"
            class="appearance-none px-4 py-2 w-full rounded-md border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            {{$slot}}
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
            </svg>
        </div>
    </div>
    @error($model)
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>
