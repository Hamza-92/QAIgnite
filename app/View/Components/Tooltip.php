<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tooltip extends Component
{
    public string $message;
    public string $position;

    public function __construct(string $message, string $position = 'top')
    {
        $this->message = $message;
        $this->position = $position;
    }

    public function render(): View|Closure|string
    {
        return view('components.tooltip');
    }
}
