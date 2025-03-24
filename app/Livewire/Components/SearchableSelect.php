<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SearchableSelect extends Component
{
    public $class;
    public $label;
    public $required;
    public $options;
    public $selectedOption;
    public $search;
    public $model;

    public function mount($class = "", $label = "Select Option", $required = false, $options = [], $selectedOption = null, $model = null)
    {
        $this->class = $class;
        $this->label = $label;
        $this->required = $required;
        $this->options = $options;
        $this->selectedOption = $selectedOption;
        $this->search = "";
        $this->model = $model;
    }

    public function updatedSearch()
    {
        $this->options = array_filter($this->options, function ($option) {
            return stripos($option['name'], $this->search) !== false;
        });
    }

    public function selectOption($optionId)
    {
        $selected = collect($this->options)->firstWhere('id', $optionId);
        $this->selectedOption = $selected['name'] ?? null;
        $this->emitUp('optionSelected', $this->model, $optionId);
    }

    public function render()
    {
        return view('livewire.components.searchable-select');
    }
}
