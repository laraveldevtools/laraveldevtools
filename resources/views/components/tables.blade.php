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
    <div class="px-2 w-full h-auto">
        <div class="flex items-center pl-2 mb-2 w-full">
            <p class="text-xs text-gray-500 uppercase">Tables</p>
            <div class="relative items-center px-2">
               

                <input @keydown.escape="search='';" x-ref="search" name="tables" type="text" size="sm" x-model="search" class="px-0 pl-3.5 w-full h-5 text-xs text-gray-500 bg-transparent border-0 -translate-y-0.5 outline-none focus:text-gray-600 peer focus:outline-none active:outline-none focus:ring-0" />
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute top-0 left-0 mt-1.5 ml-2 text-gray-900 opacity-50 peer-focus:opacity-90 size-3">
  <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
</svg>
                <button x-show="search!=''" @click="search=''; $refs.search.focus()" class="flex absolute top-0 right-0 justify-center items-center mt-2 mr-2 w-3 h-3 leading-none text-gray-500 bg-gray-200 rounded-full" x-cloak>
                    <svg class="w-2 h-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
        <ul class="text-sm">
            <template x-for="table in filteredTables">
                <li>
                    <button 
                        @click="selectTable(table)" 
                        :class="{ ' text-black' : selectedTable == table, 'hover:text-black text-gray-400' : selectedTable != table}"
                        class="flex justify-start items-center px-2 py-1 w-full duration-300 ease-out group">
                        <span class="relative">
                            <span x-text="tableCapitalized(table)"></span>
                            <span 
                                
                                :class="{'opacity-100 w-full left-0': selectedTable == table, 'opacity-0 w-0 left-0': selectedTable != table}"
                                class="block absolute bottom-0 h-0.5 rounded-full duration-200 ease-out translate-y-px bg-neutral-600"></span>
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