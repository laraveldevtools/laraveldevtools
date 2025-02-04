<?php

namespace Laraveldevtools\Laraveldevtools\Components;

use Livewire\Component;
use Livewire\Attributes\Url;

class Main extends Component
{
    public $section = 'database';

    #[Url] 
    public $file = null;

    public $file_contents = null;

    public function mount(){
        if($this->file != null){
            $this->file_contents = file_get_contents($this->file);
        }
    }
    

    public function saveFileContents($contents)
    {
        if ($this->file && is_writable($this->file)) {
            file_put_contents($this->file, $contents);
            $this->file_contents = $contents;
            session()->flash('message', 'File saved successfully!');
        } else {
            session()->flash('error', 'Unable to save file. Check file permissions.');
        }

        $this->file_contents = file_get_contents($this->file);
    }

    public function render()
    {
        return view('laraveldevtools::components.main')
            ->layout('laraveldevtools::components.layouts.app');
    }
}
