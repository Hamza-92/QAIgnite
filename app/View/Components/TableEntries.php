<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableEntries extends Component
{
    public $entries;
    public $class;


    public function __construct($entries, $class = '')
    {
        $this->entries = $entries;
        $this->class = $class;
    }


    public function render(): View|Closure|string
    {
        return view('components.table-entries');
    }
}
