<div class="flex-shrink-0 w-full h-full opacity-0 duration-300 ease-out" wire:ignore.self
    x-data="{ 
        tables: @entangle('tables').live,
        selectedTable: @entangle('table').live,
        search: '',
        get filteredTables() {
            if(this.search != ''){
                return this.tables.filter(
                    i => i.toLowerCase().startsWith(this.search.toLowerCase())
                )
            }
            return this.tables;
        },
        tableCapitalized(table) {
            
            return table.charAt(0).toUpperCase() + table.slice(1);
        },
        selectTable(table) {
            this.selectedTable = table;
            Livewire.dispatch('selectTable', {'table' : table});
            //@this.selectTable(table);
        }
    }"
    x-init="setTimeout(function(){ $el.classList.remove('opacity-0'); }, 10);">

    <div class="w-full h-auto">
        <div class="hidden relative items-center pb-1">
            <input placeholder="Search tables" @keydown.escape="search='';" x-ref="search" name="tables" type="text" size="sm" x-model="search" class="px-0 w-full bg-transparent border-0 border-b-2 border-transparent outline-none focus:border-b-2 hover:border-gray-900 active:border-gray-900 focus-within:border-gray-900 focus:outline-none active:outline-none focus:ring-0" />
            <button x-show="search!=''" @click="search=''; $refs.search.focus()" class="flex absolute right-0 justify-center items-center mr-0.5 w-5 h-5 leading-none text-gray-500 bg-gray-200 rounded-full" x-cloak>
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <ul class="p-2 space-y-1 text-sm">
            <template x-for="table in filteredTables">
                <li>
                    <button 
                        @click="selectTable(table)" 
                        :class="{ 'bg-neutral-200 text-neutral-900/90 pl-3' : selectedTable == table, 'hover:bg-neutral-200 pl-2 hover:text-neutral-900 text-neutral-900/60' : selectedTable != table}"
                        class="flex justify-start items-center py-1 pr-2 w-full rounded-md duration-300 ease-out hover:pl-3 group">
                        <span class="relative">
                            <span x-text="tableCapitalized(table)"></span>
                            
                        </span>

                    </button>
                </li>
            </template>
            <template x-if="!filteredTables.length">
                <li class="w-full text-xs text-center text-gray-500">No results found.
                    <button @click="search=''" class="text-blue-500 underline">Clear Search?</button>
                </li>
            </template>
        </ul>
    </div>
</div>