<div class="p-4 max-w-7xl mx-auto space-y-4">

    {{-- HEADER --}}
    <h1 class="text-sm font-semibold text-gray-800">{{ $landingPage->title }}</h1>

    <div class="grid grid-cols-12 gap-4">

        {{-- LEFT PANEL --}}
        <div class="col-span-4 space-y-2">

            {{-- ADD SECTION --}}
            <button wire:click="showSectionModal"
                    class="w-full flex items-center justify-center gap-1.5 py-2.5 rounded-xl border border-dashed border-gray-300 text-xs text-gray-500 hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add Section
            </button>

            {{-- SECTION LIST --}}
            <div id="section-list" class="space-y-2">

                @foreach($landingPage->sections as $section)
                <div class="border border-gray-200 rounded-xl bg-white overflow-hidden" data-id="{{ $section->id }}">

                    {{-- Section Head --}}
                    <div class="flex items-center justify-between px-2.5 py-2 bg-gray-50 border-b border-gray-100">
                        <div class="flex items-center gap-1.5 min-w-0">
                            {{-- Drag Handle --}}
                            <svg class="w-3.5 h-3.5 text-gray-300 cursor-move drag-handle flex-shrink-0"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h8M8 12h8M8 18h8"/>
                            </svg>
                            <div class="min-w-0">
                                <p class="text-xs font-medium text-gray-700 truncate">{{ $section->name }}</p>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-500">
                                    {{ $section->layout }}
                                </span>
                            </div>
                        </div>
                        <button wire:click="deleteSection({{ $section->id }})"
                                class="p-1 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg>
                        </button>
                    </div>

                    {{-- Component List --}}
                    <div
                        class="p-1.5 space-y-1 component-list"
                        data-section="{{ $section->id }}"
                    >
                        @foreach($section->components as $component)
                        <div class="flex items-center justify-between px-2 py-1.5 rounded-lg border border-gray-100 hover:bg-gray-50 transition group" data-id="{{ $component->id }}">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <svg class="w-3 h-3 text-gray-300 cursor-move component-handle"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 6h8M8 12h8M8 18h8"/>
                                </svg>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium
                                    {{ $component->is_visible ? 'bg-indigo-50 text-indigo-600' : 'bg-gray-100 text-gray-400 line-through' }}">
                                    {{ $component->type }}
                                </span>
                            </div>
                            <div class="flex items-center gap-0.5 opacity-0 group-hover:opacity-100 transition">
                                <button wire:click="editComponent({{ $component->id }})"
                                        class="p-1 rounded text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition"
                                        title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <button wire:click="toggleComponent({{ $component->id }})"
                                        class="p-1 rounded transition
                                            {{ $component->is_visible ? 'text-gray-400 hover:text-amber-500 hover:bg-amber-50' : 'text-gray-300 hover:text-gray-500 hover:bg-gray-100' }}"
                                        title="{{ $component->is_visible ? 'Hide' : 'Show' }}">
                                    @if($component->is_visible)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    @endif
                                </button>
                                <button wire:click="deleteComponent({{ $component->id }})"
                                        class="p-1 rounded text-gray-300 hover:text-red-500 hover:bg-red-50 transition"
                                        title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Add Component --}}
                    <button wire:click="showComponentModal({{ $section->id }})"
                            class="w-full flex items-center justify-center gap-1 py-2 border-t border-gray-100 text-[11px] text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                        Add Component
                    </button>

                </div>
                @endforeach

            </div>
        </div>

        {{-- RIGHT PREVIEW --}}
        <div class="col-span-8">
            <div class="sticky top-4 flex justify-center">

                {{-- Phone Frame --}}
                <div class="w-[390px] h-[820px] bg-slate-900 rounded-[40px] p-3 shadow-2xl">
                    <div class="w-full h-full bg-slate-100 rounded-[32px] overflow-y-auto">
                        <div class="p-2 w-full max-w-md min-h-full bg-white mx-auto relative flex flex-col" style="min-height:100%;">

                            {{-- CONTENT --}}
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
                                    <div style="
                                        display:grid;
                                        gap:{{ $section->gap ?? 8 }}px;
                                        {{ $section->layout == 'col-1' ? 'grid-template-columns:repeat(1,minmax(0,1fr));' : '' }}
                                        {{ $section->layout == 'col-2' ? 'grid-template-columns:repeat(2,minmax(0,1fr));' : '' }}
                                        {{ $section->layout == 'col-3' ? 'grid-template-columns:repeat(3,minmax(0,1fr));' : '' }}
                                    ">
                                        @foreach($section->components as $component)
                                            @if($component->is_visible)
                                                @includeIf(
                                                    'livewire.admin.landing-page.components.' . $component->type . '-preview',
                                                    ['component' => $component, 'section' => $section, 'isPreview' => false]
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
        </div>

    </div>


    {{-- ================= EDIT PANEL (SLIDE-IN) ================= --}}
    @if($openEditPanel)
        <div class="fixed inset-0 bg-black/30 z-40" wire:click="$set('openEditPanel', false)"></div>

        <div class="fixed right-0 top-0 h-full w-[380px] bg-white border-l border-gray-100 shadow-2xl z-50 flex flex-col">

            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider">Editing</p>
                    <h2 class="text-sm font-semibold text-gray-900">{{ ucfirst($editingType) }}</h2>
                </div>
                <button wire:click="$set('openEditPanel', false)"
                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-4">
                @includeIf(
                    'livewire.admin.landing-page.components.' . $editingType . '-form',
                    [
                        'editingContent' => $editingContent,
                        'editingSectionId' => $selectedComponentId,
                        'currentType' => $editingType,
                        'mediaMethod' => $mediaMethod ?? 'upload',
                    ]
                )
            </div>

            <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                <button wire:click="saveComponent"
                        class="w-full py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 active:bg-indigo-800 transition">
                    Save changes
                </button>
            </div>

        </div>
    @endif


    {{-- ================= SECTION MODAL ================= --}}
    @if($openSectionModal)
        <div class="fixed inset-0 bg-black/40 flex items-end sm:items-center justify-center z-50">
            <div class="bg-white rounded-t-2xl sm:rounded-2xl border border-gray-200 w-full sm:w-80 overflow-hidden shadow-xl">

                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Pilih Layout</h2>
                    <button wire:click="$set('openSectionModal', false)"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-4 pb-6">
                    <div class="grid grid-cols-3 gap-3">
                        @foreach([['col-1','1 col'], ['col-2','2 col'], ['col-3','3 col']] as [$val, $label])
                        <button wire:click="createSection('{{ $val }}')"
                                class="flex flex-col items-center gap-2 py-4 px-2 rounded-xl border border-gray-200 text-gray-500 hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-600 active:bg-indigo-100 transition">
                            @if($val === 'col-1')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                            @elseif($val === 'col-2')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="8" height="18" rx="1"/><rect x="13" y="3" width="8" height="18" rx="1"/></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="6" height="18" rx="1"/><rect x="9" y="3" width="6" height="18" rx="1"/><rect x="16" y="3" width="6" height="18" rx="1"/></svg>
                            @endif
                            <span class="text-xs font-medium">{{ $label }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    @endif


    {{-- ================= COMPONENT MODAL ================= --}}
    @if($openComponentModal)
        <div class="fixed inset-0 bg-black/40 flex items-end sm:items-center justify-center z-50">
            <div class="bg-white rounded-t-2xl sm:rounded-2xl border border-gray-200 w-full sm:w-[480px] overflow-hidden shadow-xl">

                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Add Component</h2>
                    <button wire:click="$set('openComponentModal', false)"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-4 max-h-[60vh] overflow-y-auto">
                    @include('livewire.admin.landing-page.components.modal.components')
                </div>

            </div>
        </div>
    @endif

</div>