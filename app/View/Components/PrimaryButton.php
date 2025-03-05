<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PrimaryButton extends Component
{
    public $model;
    public $type;
    public $class;
    public $attributes;
    public function __construct($type, $model='', $class = '', $attributes = '')
    {
        $this->type = $type;
        $this->model = $model;
        $this->class = $class;
        $this->attributes = $attributes;
    }

    public function render(): View|Closure|string
    {
        return view('components.primary-button');
    }
}
