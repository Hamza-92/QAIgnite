<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class textarea extends Component
{
    public $class;
    public $name;
    public $label;
    public $model;
    public $placeholder;
    public $required;
    public $rows;
    public $cols;
    public $disabled;
    public $readonly;

    public function __construct($class = '', $name = '', $label = '', $model='', $placeholder = '', $rows = '3', $cols='', $required = false, $disabled = false, $readonly = false)
    {
        $this->class = $class;
        $this->name = $name;
        $this->label = $label;
        $this->model = $model;
        $this->placeholder = $placeholder;
        $this->rows = $rows;
        $this->cols = $cols;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
    }

    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}
