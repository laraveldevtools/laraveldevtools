<?php

namespace Laraveldevtools\Laraveldevtools\Components;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Filament\Notifications\Notification; 

class Database extends Component
{
    use WithPagination;

    public $table;
    public $search = '';

    public $searchable = [
        'users' => ['name', 'email'],
        'posts' => ['title'],
    ];

    public $paginate = 15;
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    

    public $primaryKeyValue = null;
    public $primaryKey = 'id';

    private $entryObject = null;
    public $entryArray = null;

    protected $queryString = [];

    protected $listeners = ['updateTableColumn'];

    public function mount()
    {
        $this->table = 'users';
    }

    public function sortBy($column){
        // If the sort column is already the one we're clicking, then just toggle the sort direction
        if($this->sortColumn == $column){
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
            return;
        }

        // Otherwise set the sort column to the new column and reset the sort direction
        $this->sortColumn = $column;
        $this->sortDirection = 'asc';
    }

    #[On('selectTable')]
    public function selectTable($table){
        $this->primaryKeyValue = null;
        $this->table = $table;
    }

    #[On('loadEntry')]
    public function loadEntry($value){
        $this->primaryKeyValue = $value;
    }

    public function getEntryProperty(){
        if(is_null($this->primaryKeyValue)){
            return null;
        }

        $record = $this->getEntryRecord();
        foreach($record as $column => $item){
            $this->entryArray[$column] = $item;
        }
        return $this->entryArray;
    }

    private function getEntryRecord(){
        return DB::table($this->table)->where($this->primaryKey, $this->primaryKeyValue)->first();
    }

    public function saveEntry(){
        $record = $this->getEntryRecord();
        foreach($record as $column => $item){
            if($record->{$column} != $this->entryArray[$column]){
                DB::table($this->table)->where($this->primaryKey, $this->primaryKeyValue)->update([$column => $this->entryArray[$column]]);
            }
        }
        
        $this->dispatch('hide-entry-editor');
        Notification::make() 
            ->title('Saved successfully')
            ->success()
            ->send(); 
    }

    public function getTableColumnsProperty(){
        // For Mysql we will use describe, for Sqlite we will use PRAGMA

        if(env('DB_CONNECTION') == 'sqlite'){
            return collect(\DB::select('PRAGMA table_info(' . $this->table . ')'))->pluck('name')->toArray();
        }else{
            return collect(\DB::select('describe ' . $this->table))->pluck('Field')->toArray();
        }
    }

    public function render()
    {
        
        $data = DB::table($this->table);

        if($this->search){
            foreach( $this->searchable[$this->table] as $searchable ) {
                $data = $data->orWhere($searchable, 'like', '%'.$this->search.'%');
            }
        }


        $data = $data->orderBy($this->sortColumn, $this->sortDirection)->select($this->tableColumns);

        return view('laraveldevtools::components.database', [
            'tableData' => $data->paginate($this->paginate)
        ])->layout('laraveldevtools::components.layouts.app');

    }
}