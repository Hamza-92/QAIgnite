<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SingleSelectBox extends Component
{
    public $class;
    public $name;
    public $label;
    public $type;
    public $model;
    public $live;
    public $placeholder;
    public $required;
    public $disabled;
    public $readonly;

    public function __construct($class = '', $name = '', $label = '', $type = 'text', $model='', $live=false, $placeholder = '', $required = false, $disabled = false, $readonly = false)
    {
        $this->class = $class;
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->model = $model;
        $this->live = $live;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
    }

    public function render(): View|Closure|string
    {
        return view('components.single-select-box');
    }
}
