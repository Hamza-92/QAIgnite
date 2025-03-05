<div class="flex flex-col gap-1 w-full {{$class}}">
    <label>{{$label}}
        @if ($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    <textarea wire:model='{{ $model }}' name="{{$model}}" id="{{$model}}" rows="{{$rows}}" cols="{{$cols}}"
        class="px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700">
        {{$slot}}
    </textarea>
    @error($model)
        <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>
