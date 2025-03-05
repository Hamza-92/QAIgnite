<div>
    <div class="px-8 py-4 space-y-4 border-b dark:border-gray-700">
        <a href="{{ route('roles') }}" wire:navigate class="text-blue-500 py-1 rounded-md space-x-2"><i
                class="fa-solid fa-arrow-left"></i> Roles</a>
        <h2 class="text-lg font-medium mt-2">Edit Role</h2>
    </div>

    <div class="p-4 md:p-8 grid md:grid-cols-2 w-full">
        <div class="md:border-r dark:border-gray-700 md:pr-8">
            <form wire:submit.prevent='saveRole'>
                {{-- Role Name Field --}}
                <x-input-field label='Role' model='name' type='text' required='true' autocomplete='role-name' />

                {{-- Descrption Field --}}
                <div class="flex flex-col gap-1 mt-4">
                    <x-textarea label='Description' model='description' required='true' />
                </div>

                {{-- Deletable Role Checkbox --}}
                <label class="flex text-red-500 mt-4 items-center gap-2" for="deletable"><input wire:model='deletable' type="checkbox" name="deletable" id="deletable" >  Is this role deletable?</label>

                {{-- Save Button --}}
                <x-primary-button type='submit' model='saveRole' class="mt-4"> Save </x-primary-button>
            </form>
        </div>
        <div class="flex flex-col gap-4 md:pl-8">
            <p>Select all permissions that apply</p>

            {{-- Project Management --}}
            <div x-data="{ open: false }" class="">
                <div @click="open = !open" class="flex justify-between items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">
                    <h4 class="text-md text-white">Project Management</h4>
                    <button type="button" class="bg-white text-gray-900 font-bold text-lg px-2 rounded-sm" x-text="open ? '-' : '+'">+</button>
                </div>
                <div x-show="open">
                    {{-- Project --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Project</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createProject" value="createProject" wire:model.differ='permissions'>
                            <label for="createProject">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewProject" value="viewProject" wire:model.differ='permissions'>
                            <label for="viewProject">View</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editProject" value="editProject" wire:model.differ='permissions'>
                            <label for="editProject">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteProject" value="deleteProject" wire:model.differ='permissions'>
                            <label for="deleteProject">Delete</label>
                        </div>
                    </div>

                    {{-- Team --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Team</h4>
                    <div class="grid grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewTeam" value="viewTeam" wire:model.differ='permissions'>
                            <label for="viewTeam">View</label>
                        </div>
                    </div>

                    {{-- Build --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Build</h4>
                    <div class="grid grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createBuild" value="createBuild" wire:model.differ='permissions'>
                            <label for="createBuild">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewBuild" value="viewBuild" wire:model.differ='permissions'>
                            <label for="viewBuild">Build</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editBuild" value="editBuild" wire:model.differ='permissions'>
                            <label for="editBuild">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteBuild" value="deleteBuild" wire:model.differ='permissions'>
                            <label for="deleteBuild">Delete</label>
                        </div>
                    </div>

                    {{-- Module --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Module</h4>
                    <div class="grid grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createModule" value="createModule" wire:model.differ='permissions'>
                            <label for="createModule">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewModule" value="viewModule" wire:model.differ='permissions'>
                            <label for="viewModule">Build</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editModule" value="editModule" wire:model.differ='permissions'>
                            <label for="editModule">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteModule" value="deleteModule" wire:model.differ='permissions'>
                            <label for="deleteModule">Delete</label>
                        </div>
                    </div>

                    {{-- Requirement --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Requirement</h4>
                    <div class="grid grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createRequirement" value="createRequirement" wire:model.differ='permissions'>
                            <label for="createRequirement">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewRequirement" value="viewRequirement" wire:model.differ='permissions'>
                            <label for="viewRequirement">Build</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editRequirement" value="editRequirement" wire:model.differ='permissions'>
                            <label for="editRequirement">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteRequirement" value="deleteRequirement" wire:model.differ='permissions'>
                            <label for="deleteRequirement">Delete</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Test Management --}}
            <div x-data="{open : false}">
                <div @click="open = !open" class="flex justify-between items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">
                    <h4 class="text-md text-white font-medium">Test Management</h4>
                    <button type="button" class="bg-white text-gray-900 font-bold text-lg px-2 rounded-sm" x-text="open ? '-' : '+'">+</button>
                </div>
                <div x-show="open">
                    {{-- Test Scenario --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Test Scenario</h4>
                    <div class="grid grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createTestScenario" value="createTestScenario" wire:model.differ='permissions'>
                            <label for="createTestScenario">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewTestScenario" value="viewTestScenario" wire:model.differ='permissions'>
                            <label for="viewTestScenario">View</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editTestScenario" value="editTestScenario" wire:model.differ='permissions'>
                            <label for="editTestScenario">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteTestScenario" value="deleteTestScenario" wire:model.differ='permissions'>
                            <label for="deleteTestScenario">Delete</label>
                        </div>
                    </div>

                    {{-- Test Case --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Test Case</h4>
                    <div class="grid grid-cols-4 gap-1 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createTestCase" value="createTestCase" wire:model.differ='permissions'>
                            <label for="createTestCase">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewTestCase" value="viewTestCase" wire:model.differ='permissions'>
                            <label for="viewTestCase">View</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editTestCase" value="editTestCase" wire:model.differ='permissions'>
                            <label for="editTestCase">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteTestCase" value="deleteTestCase" wire:model.differ='permissions'>
                            <label for="deleteTestCase">Delete</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Test Lab --}}
            <div x-data="{ open : false }">
                <div @click="open = !open" class="flex justify-between items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-500 cursor-pointer">
                    <h4 class="text-md text-white font-medium">Test Lab</h4>
                    <button type="button" class="bg-white text-gray-900 font-bold text-lg px-2 rounded-sm" x-text="open ? '-' : '+'">+</button>
                </div>
                <div x-show="open">
                    {{-- Test Cycle --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Test Cycle</h4>
                    <div class="grid grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createTestCycle" value="createTestCycle" wire:model.differ='permissions'>
                            <label for="createTestCycle">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewTestCycle" value="viewTestCycle" wire:model.differ='permissions'>
                            <label for="viewTestCycle">View</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editTestCycle" value="editTestCycle" wire:model.differ='permissions'>
                            <label for="editTestCycle">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteTestCycle" value="deleteTestCycle" wire:model.differ='permissions'>
                            <label for="deleteTestCycle">Delete</label>
                        </div>
                    </div>

                    {{-- Test Case Execution --}}
                    <h4 class="px-4 py-2 bg-gray-100 dark:bg-gray-800">Test Case Execution</h4>
                    <div class="grid grid-cols-4 p-4">
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="createTestCaseExecution" value="createTestCaseExecution" wire:model.differ='permissions'>
                            <label for="createTestCaseExecution">Create</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="viewTestCaseExecution" value="viewTestCaseExecution" wire:model.differ='permissions'>
                            <label for="viewTestCaseExecution">View</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="editTestCaseExecution" value="editTestCaseExecution" wire:model.differ='permissions'>
                            <label for="editTestCaseExecution">Edit</label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <input type="checkbox" id="deleteTestCaseExecution" value="deleteTestCaseExecution" wire:model.differ='permissions'>
                            <label for="deleteTestCaseExecution">Delete</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
