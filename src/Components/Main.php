<?php

namespace Laraveldevtools\Laraveldevtools\Components;

use Livewire\Component;

class Main extends Component
{
    public $section = 'database';

    

    public function render()
    {
        return view('laraveldevtools::components.main')
            ->layout('laraveldevtools::components.layouts.app');
    }
}
