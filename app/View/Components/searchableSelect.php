<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class searchableSelect extends Component
{
    public $class;
    public $attributes;
    public $option_attributes;
    public $label;
    public $required;
    public $search;
    public $options;
    public $selected_option;
    public $model;
    public $assign_value_method;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $class = "",
        $attributes = [],
        $option_attributes = [],
        $label = "",
        $required = false,
        $search = "",
        $options = [],
        $selected_option = "",
        $model = null,
        $assign_value_method = null
    ) {
        $this->class = $class;
        $this->attributes = $attributes;
        $this->option_attributes = $option_attributes;
        $this->label = $label;
        $this->required = $required;
        $this->search = $search;
        $this->options = $options;
        $this->selected_option = $selected_option;
        $this->model = $model;
        $this->assign_value_method = $assign_value_method;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.searchable-select');
    }
}
