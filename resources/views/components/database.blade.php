<div 
    x-data="{
        entryLoading: true,
        entryEditor: false,
        openEntryEditor: function(primaryKeyValue) {
            Livewire.dispatch('loadEntry', { 'value' : primaryKeyValue });
            this.entryEditor = true;
        }
    }"
    x-init="
        $watch('entryEditor', value => {
            if(!value) {
                $wire.set('primaryKeyValue', null);
            }
        })
    "
    @hide-entry-editor="entryEditor = false"
    class="overflow-auto relative px-3 w-full h-full">
    <div class="relative mb-3 w-full">
        <svg class="absolute mt-2.5 ml-3.5 w-5 h-5 text-gray-400 peer-focused:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
        <input type="text" wire:model.live.debounce.300ms="search" class="pl-10 w-full h-10 text-sm bg-gray-100 rounded-lg border-0 peer focus:ring-0 focus:outline-none focus-within:outline-none" placeholder="Search" />
    </div>
    <div class="flex overflow-hidden relative items-start pr-10 w-full h-auto rounded-md border border-gray-200">
        <div class="overflow-x-auto w-full h-full" style="font-size:0px;">
            <div class="inline-block min-w-full">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead class="bg-neutral-50">
                            <tr class="text-neutral-500">
                                @foreach($this->tableColumns as $column)

                                    <th wire:click="sortBy('{{ $column }}')" class="table-cell px-4 h-10 text-xs font-medium text-left uppercase align-middle cursor-pointer select-none group hover:underline">
                                        <span class="flex items-center space-x-0.5">
                                            <span>{{ $column }}</span>
                                            @if($sortDirection == 'desc' && $sortColumn == $column)
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 @if($sortColumn != $column){{ 'opacity-0 group-hover:opacity-100 ease-out duration-150' }}@endif"><path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" /></svg>
                                            @endif
                                        </span>
                                    </th>
                                @endforeach
                                <th class="absolute right-0 inline-flex cursor-pointer items-center justify-center text-xs h-10 w-10 shadow-[-3px_0_5px_0_rgba(0,0,0,0.06)] bg-neutral-50 border-l border-gray-100 group-hover:bg-gray-100">
                                    <span class="flex justify-center items-center w-6 h-6 rounded hover:bg-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                            @foreach($tableData as $data)
                                <tr @click="openEntryEditor('{{ $data->id }}')" class="overflow-hidden text-gray-900 duration-100 ease-out cursor-pointer group hover:bg-gray-100" wire:key="{{ $this->table }}-{{ $data->id }}">
                                    @foreach($this->tableColumns as $column)
                                        <td class="table-cell flex-shrink-0 px-4 h-10 text-sm align-middle whitespace-nowrap">{{ $data->{$column} }}</td>
                                    @endforeach
                                    <td class="absolute right-0 inline-flex items-center h-10 w-10 justify-center shadow-[-3px_0_5px_0_rgba(0,0,0,0.06)] bg-white border-l border-gray-100 group-hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" /></svg>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
            <div 
                x-show="entryEditor"
                @keydown.window.escape="entryEditor=false"
                class="relative z-[99]">
                <div x-show="entryEditor" x-transition.opacity.duration.600ms @click="entryEditor = false" class="fixed inset-0 bg-black bg-opacity-10"></div>
                <div class="overflow-hidden fixed inset-0">
                    <div class="overflow-hidden absolute inset-0">
                        <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full">
                            <div 
                                x-show="entryEditor" 
                                @click.away="entryEditor = false"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                                x-transition:enter-start="translate-x-full" 
                                x-transition:enter-end="translate-x-0" 
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                                x-transition:leave-start="translate-x-0" 
                                x-transition:leave-end="translate-x-full" 
                                class="w-screen max-w-xl">
                                <div class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
                                    <div class="flex overflow-y-scroll flex-col flex-1 py-2 min-h-0">
                                        <div class="px-4">
                                        <div class="flex justify-between items-center">
                                            <h2 class="text-base font-light leading-6 text-gray-900" id="slide-over-title">Edit <span class="font-semibold">{{ $this->table }}</span> record</h2>
                                            <div class="flex items-center ml-3 h-auto">
                                                <button @click="entryEditor=false" class="relative top-0 right-0 z-30 flex items-center justify-center px-3 mt-0 space-x-1 text-[0.7rem] font-medium leading-none py-1.5 rounded-md text-neutral-600 group hover:text-gray-700 hover:bg-neutral-100">
                                                    <span class="text-gray-400 translate-x-px -translate-y-px group-hover:text-gray-700">esc</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="relative flex-1 px-4 mt-3">
                                            @if($primaryKeyValue ?? false)
                                                <div class="flex justify-start items-start w-full h-full">
                                                    <div class="space-y-3 w-full">
                                                        @foreach($this->entry as $column => $value)
                                                            <div class="relative w-full">
                                                                <input type="text" wire:model="entryArray.{{ $column }}" placeholder="{{ ucwords(str_replace('_', ' ', $column)) }}" class="flex px-2 pt-[26px] pb-1.5 w-full h-auto text-sm bg-gray-100 rounded-lg border-0 transition-colors duration-200 ease-out peer focus:bg-gray-200 focus:ring-0 focus-within:ring-0 placeholder:text-neutral-500 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50" />
                                                                <label class="block flex absolute top-0 items-center px-2 h-7 text-xs font-semibold leading-6 text-gray-400 peer-focus-within:text-gray-900">
                                                                    @if($column == 'id')
                                                                        <svg class="mr-1 w-5 h-5" viewBox="0 0 21 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.273 8.76a3.9 3.9 0 1 1-5.516-5.516A3.9 3.9 0 0 1 8.273 8.76ZM19.55 5.996l-10.142.006M18.087 8.922v-2.92M15.563 8.922l-.072-2.92" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                                    @endif
                                                                    <span>{{ $column }}</span>
                                                                </label>
                                                                
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex justify-center items-center w-full h-full">
                                                    <svg class="w-5 h-5 text-gray-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-shrink-0 justify-end px-4 py-3">
                                        <button type="button" @click="entryEditor=false" class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded ring-1 ring-inset ring-gray-300 shadow-sm hover:ring-gray-400" @click="open = false">Cancel</button>
                                        <button type="submit" wire:click="saveEntry" class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-gray-800 rounded shadow-sm hover:bg-gray-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800">Save</button>
                                    </div>
                                </div>

                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    <div class="flex justify-between items-center mt-5 w-full">
        {{-- {{ $tableData->links('foundation_views::partials.pagination') }} --}}
    </div>

</div>