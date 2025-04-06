<div>
    <div class="flex items-center justify-between flex-wrap gap-4 px-8 py-4 border-b dark:border-gray-700">
        <div class="flex flex-col items-start">
            <a href="{{ route('test-scenarios') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                    class="fa-solid fa-arrow-left"></i> Test Scenarios</a>
            <h2 class="text-lg font-medium mt-2">{{ $test_scenario->ts_name }}</h2>
        </div>
        {{-- <x-primary-button type="button" model="edit">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit
            </x-primary-button> --}}
    </div>

    {{-- Detail --}}
    <div class="px-8 py-4 w-full">
        <div class="flex flex-row items-center space-x-2">
            <span class="text-sm text-gray-500">Created by</span>
            <span class="text-sm text-gray-500">{{ $test_scenario->createdBy->username }}</span>
            <span class="text-sm text-gray-500">on</span>
            <span class="text-sm text-gray-500">{{ $test_scenario->created_at->format('d M Y') }}</span>
            <span class="text-sm text-gray-500">at</span>
            <span class="text-sm text-gray-500">{{ $test_scenario->created_at->format('h:i A') }}</span>
        </div>
        <div class="mt-4 border dark:border-gray-700">
            <table>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Build
                        ID
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_scenario->build->name ?? '' }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Module
                    </th>
                    <td class="w-full px-4 py-3">{{ $test_scenario->module->module_name ?? '' }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Requirement</th>
                    <td class="w-full px-4 py-3">
                        @if ($test_scenario->requirement)
                            <a href="{{ route('requirement.detail', $test_scenario->requirement->id) }}"
                                class="underline">{{ $test_scenario->requirement->requirement_title }}</a>
                        @endif
                    </td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Test Scenario</th>
                    <td class="w-full px-4 py-3">{{ $test_scenario->ts_name }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">
                        Description</th>
                    <td class="w-full px-4 py-3">{{ $test_scenario->ts_description }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Test
                        Cases</th>
                    <td class="w-full px-4 py-3">
                        <ul>
                            @forelse ($test_scenario->test_cases as $test_case)
                                <li>
                                    <a href="{{ route('test-case.detail', $test_case->id) }}" class="underline"
                                        wire:navigate>
                                        {{ $test_case->tc_name }}
                                    </a>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </td>
                </tr>
                <tr class="">
                    <th class="px-4 py-3 border-r dark:border-gray-700 bg-gray-100 dark:bg-gray-800 font-medium">Defects
                    </th>
                    <td class="w-full px-4 py-3"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
