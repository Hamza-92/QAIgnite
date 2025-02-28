<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmationModal extends Component
{
public $title;
public $message;
public $method;
public $param;
public $type;
    public function __construct($title, $message, $method, $param = null, $type)
    {
        $this->title = $title;
        $this->message = $message;
        $this->method = $method;
        $this->param = $param;
        $this->type = $type;
    }

    public function render(): View|Closure|string
    {
        return view('components.confirmation-modal');
    }
}
