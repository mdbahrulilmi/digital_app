<div class="flex h-screen bg-gray-50/50">

    <div class="w-[420px] flex-shrink-0 h-screen overflow-y-auto p-6 space-y-5">

        <div class="flex items-center justify-between">
            <div>
                <p class="text-[11px] font-medium text-indigo-500 uppercase tracking-wider mb-0.5">Landing Page Builder</p>
                <h1 class="text-lg font-bold text-gray-900">{{ $landingPage->title }}</h1>
            </div>
        </div>

        <div class="space-y-3">

            <button wire:click="showSectionModal"
                    class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-dashed border-gray-200 text-xs font-medium text-gray-400 hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50/50 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Section
            </button>

            <div id="section-list" class="space-y-3">

                @foreach($landingPage->sections as $section)
                <div class="border border-gray-200/80 rounded-2xl bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200" data-id="{{ $section->id }}">

                    <div class="flex items-center justify-between px-3 py-2.5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-100">
                        <div class="flex items-center gap-2 min-w-0">
                            <svg class="w-4 h-4 text-gray-300 cursor-move drag-handle flex-shrink-0 hover:text-gray-500 transition"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h8M8 12h8M8 18h8"/>
                            </svg>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-800 truncate">{{ $section->name }}</p>
                                <span class="inline-flex items-center gap-1 mt-0.5 px-1.5 py-0.5 rounded-md text-[10px] font-medium bg-indigo-50 text-indigo-500">
                                    <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="3"/></svg>
                                    {{ $section->layout }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-0.5">

                            <button
                                wire:click="editSection({{ $section->id }})"
                                class="p-1.5 rounded-lg text-gray-300 hover:text-indigo-600 hover:bg-indigo-50 transition-colors"
                                title="Edit Section">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3.5 h-3.5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>

                            </button>

                            <button wire:click="deleteSection({{ $section->id }})"
                                    class="p-1.5 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg>
                            </button>
                        </div>
                    </div>

                    <div
                        class="p-2 space-y-1 component-list min-h-[8px]"
                        data-section="{{ $section->id }}"
                    >
                        @foreach($section->components as $component)
                        <div class="flex items-center justify-between px-2.5 py-2 rounded-xl border border-gray-100 hover:border-gray-200 hover:bg-gray-50/80 transition-colors group" data-id="{{ $component->id }}">
                            <div class="flex items-center gap-2 min-w-0">
                                <svg class="w-3.5 h-3.5 text-gray-300 cursor-move component-handle flex-shrink-0 hover:text-gray-500 transition"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 6h8M8 12h8M8 18h8"/>
                                </svg>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold
                                    {{ $component->is_visible ? 'bg-indigo-50 text-indigo-600' : 'bg-gray-100 text-gray-400 line-through' }}">
                                    {{ $component->type }}
                                </span>
                            </div>
                            <div class="flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button wire:click="editComponent({{ $component->id }})"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors"
                                        title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <button wire:click="toggleComponent({{ $component->id }})"
                                        class="p-1.5 rounded-lg transition-colors
                                            {{ $component->is_visible ? 'text-gray-400 hover:text-amber-500 hover:bg-amber-50' : 'text-gray-300 hover:text-gray-500 hover:bg-gray-100' }}"
                                        title="{{ $component->is_visible ? 'Hide' : 'Show' }}">
                                    @if($component->is_visible)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    @endif
                                </button>
                                <button wire:click="deleteComponent({{ $component->id }})"
                                        class="p-1.5 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors"
                                        title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button wire:click="showComponentModal({{ $section->id }})"
                            class="w-full flex items-center justify-center gap-1.5 py-2.5 border-t border-gray-100 text-[11px] font-medium text-gray-400 hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                        Tambah Component
                    </button>

                </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="flex-1 h-screen flex items-center justify-center bg-gray-100/60 border-l border-gray-200">

        <div class="w-[390px] h-[92vh] max-h-[820px] bg-gradient-to-b from-slate-800 to-slate-900 rounded-[44px] p-3 shadow-2xl ring-1 ring-black/10 flex flex-col">
            <div class="relative">
                <div class="absolute top-1.5 left-1/2 -translate-x-1/2 w-24 h-5 bg-slate-900 rounded-full z-10"></div>
            </div>
            <div class="flex-1 min-h-0 w-full bg-slate-100 rounded-[34px] overflow-y-auto custom-scrollbar">
                <div class="p-2 w-full max-w-md min-h-full bg-white mx-auto relative flex flex-col" style="min-height:100%;">

                    <div class="flex-1">
                        @foreach($landingPage->sections as $section)
                        <div style="
                            margin-bottom:24px;
                            padding:
                                {{ $section->padding_top ?? 0 }}px
                                {{ $section->padding_right ?? 0 }}px
                                {{ $section->padding_bottom ?? 0 }}px
                                {{ $section->padding_left ?? 0 }}px;
                        ">
                            <div 
                                class="grid gap-2"
                                style="
                                    {{ $section->layout == 'col-1' ? 'grid-template-columns:repeat(1,minmax(0,1fr));' : '' }}
                                    {{ $section->layout == 'col-2' ? 'grid-template-columns:repeat(2,minmax(0,1fr));' : '' }}
                                    {{ $section->layout == 'col-3' ? 'grid-template-columns:repeat(3,minmax(0,1fr));' : '' }}
                                "
                            >
                                @foreach($section->components as $component)
                                    @if($component->is_visible)
                                        @includeIf(
                                            'livewire.admin.landing-page.components.' . $component->type . '-preview',
                                            ['component' => $component, 'section' => $section, 'isPreview' => true]
                                        )
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($landingPage->blog)
                        @include('blog.footer')
                            @endif
                            @if($landingPage->cart)
                                <div style="height:96px;"></div>
                            @endif

                        </div>
                    </div>
                </div>

    </div>

    @if($openEditPanel)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-[2px] z-40" wire:click="$set('openEditPanel', false)"></div>

        <div class="fixed right-0 top-0 h-full bg-white border-l border-gray-100 shadow-2xl z-50 flex flex-col
        {{ $editingType === 'product' ? 'w-[720px]' : 'w-[380px]' }}">

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <p class="text-[10px] font-semibold text-indigo-500 uppercase tracking-wider">Editing</p>
                    <h2 class="text-base font-bold text-gray-900">{{ ucfirst($editingType) }}</h2>
                </div>
                <button wire:click="$set('openEditPanel', false)"
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-5 py-4">
                @if($editingType === 'section')

                    @include('livewire.admin.landing-page.section-form')

                @else
                @includeIf(
                    'livewire.admin.landing-page.components.' . $editingType . '-form',
                    [
                        'editingContent' => $editingContent,
                        'editingSectionId' => $selectedComponentId,
                        'currentType' => $editingType,
                        'mediaMethod' => $mediaMethod ?? 'upload',
                    ]
                )
                @endif
            </div>

            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/80">
                <button wire:click="saveComponent"
                        class="w-full py-3 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-sm shadow-indigo-200 hover:bg-indigo-700 active:bg-indigo-800 transition-colors">
                    Save changes
                </button>
            </div>

        </div>
    @endif

    @if($openSectionModal)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px] flex items-end sm:items-center justify-center z-50">
            <div class="bg-white rounded-t-3xl sm:rounded-2xl border border-gray-200 w-full sm:w-80 overflow-hidden shadow-2xl">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-900">Pilih Layout</h2>
                    <button wire:click="$set('openSectionModal', false)"
                            class="p-2 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-5 pb-6">
                    <div class="grid grid-cols-3 gap-3">
                        @foreach([['col-1','1 col'], ['col-2','2 col'], ['col-3','3 col']] as [$val, $label])
                        <button wire:click="createSection('{{ $val }}')"
                                class="flex flex-col items-center gap-2 py-5 px-2 rounded-2xl border border-gray-200 text-gray-500 hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition-all duration-150">
                            @if($val === 'col-1')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                            @elseif($val === 'col-2')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="8" height="18" rx="1"/><rect x="13" y="3" width="8" height="18" rx="1"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="6" height="18" rx="1"/><rect x="9" y="3" width="6" height="18" rx="1"/><rect x="16" y="3" width="6" height="18" rx="1"/></svg>
                            @endif
                            <span class="text-xs font-semibold">{{ $label }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    @endif

    @if($openComponentModal)
        <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px] flex items-end sm:items-center justify-center z-50">
            <div class="bg-white rounded-t-3xl sm:rounded-2xl border border-gray-200 w-full sm:w-[480px] overflow-hidden shadow-2xl">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-bold text-gray-900">Add Component</h2>
                    <button wire:click="$set('openComponentModal', false)"
                            class="p-2 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-5 max-h-[60vh] overflow-y-auto">
                    @include('livewire.admin.landing-page.components.modal.components')
                </div>

            </div>
        </div>
    @endif

</div>