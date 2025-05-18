<th scope="col" class="px-4 py-3 font-medium cursor-pointer text-left" wire:click="setSortBy('{{ $name }}')">
    <button class="flex items-center relative">
        {{ $displayName }}


        <span class="ml-2" wire:loading.remove wire:target="setSortBy('{{ $name }}')">
            @if ($sortBy !== $name)
                <i class="fas fa-sort"></i>
            @elseif($sortDir === 'ASC')
                <i class="fas fa-sort-up"></i>
            @else
                <i class="fas fa-sort-down"></i>
            @endif
        </span>

        <!-- Spinner (Shown when sorting is in progress) -->
        <span class="ml-2" wire:loading wire:target="setSortBy('{{ $name }}')">
            <i class="fas fa-spinner fa-spin"></i>
        </span>
    </button>
</th>
