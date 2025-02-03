<?php

namespace Laraveldevtools\Database\Components;

use Livewire\Component;

class DatabaseDevTools extends Component
{
    public function render()
    {
        return view('laraveldevtools-database::components.database-dev-tools')
            ->layout('laraveldevtools-database::components.layouts.app');
    }
}
