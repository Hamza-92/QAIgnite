<?php

namespace App\Livewire\Layouts;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class Sidebar extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
    public function render()
    {
        return view('livewire.layouts.sidebar');
    }
}
