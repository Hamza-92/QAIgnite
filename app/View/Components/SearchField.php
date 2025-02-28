<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchField extends Component
{
    public $search;
    public $placeholder;
    public $resetMethod;

    public function __construct($search, $resetMethod, $placeholder = 'Search...')
    {
        $this->search = $search;
        $this->placeholder = $placeholder;
        $this->resetMethod = $resetMethod;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-field');
    }
}
