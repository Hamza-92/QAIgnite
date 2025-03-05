@props(['class' => ''])
{{-- Action Buttons --}}
<div x-data="{ openModel: false }" @click.outside="openModel = false" @close.stop="openModel = false"
class="flex relative rounded-md bg-blue-500 dark:bg-blue-800 text-white dark:tex-gray-300 text-sm {{$class}}">
<a href="{{ url('projects?createProject=true') }}" wire:navigate
    class="flex gap-2 items-center p-2 px-4 border-r border-gray-300 dark:border-gray-500"><i class="fa-solid fa-plus"></i> New Project</a>
<button @click='openModel = !openModel' class="p-2 px-3"><i class="fa-solid fa-angle-down"></i></button>

<div x-show='openModel' x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="absolute w-full z-50 mt-10 shadow-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300">
    <div class="flex flex-col">
        {{-- <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Project</a> --}}
        <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Module</a>
        <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Build</a>
        <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Requirement</a>
        {{-- <a href=""><i class="fa-solid fa-plus"></i> Test Plan</a> --}}
        {{-- <a href=""><i class="fa-solid fa-plus"></i> Test Suite</a>
                <a href=""><i class="fa-solid fa-plus"></i> Test Run</a> --}}
        <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Test Scenario</a>
        <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Test Case</a>
        <a class="flex gap-2 items-center text-sm px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" href=""><i class="fa-solid fa-plus"></i> Defect</a>
    </div>
</div>
</div>
