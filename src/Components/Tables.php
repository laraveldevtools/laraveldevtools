<?php

namespace Laraveldevtools\Database\Components;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Tables extends Component
{
    public $tables = [];
    public $table;

    public function mount(){
       $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
       $this->tables = collect($tables)->pluck('name');
       
        $this->table = 'users';
    }


    public function render()
    {
        return view('laraveldevtools-database::components.tables')
            ->layout('laraveldevtools-database::components.layouts.app');
    }
}
