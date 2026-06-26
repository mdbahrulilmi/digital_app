<div class="w-full max-w-md min-h-screen bg-white shadow-xl flex flex-col justify-between relative border-x border-slate-200/50 mx-auto">

    @foreach($sections as $section)
        <div wire:key="section-{{ $section->id }}">
            @php
                $viewName = 'livewire.admin.landing-page.components.' . $section->type . '-preview';
            @endphp

            @includeIf($viewName, ['section' => $section, 'isPreview' => false,])
        </div>
    @endforeach

    @if($landingPage->blog)
        @include('blog.footer')
    @endif
    
    @if($landingPage->cart)
        <div class="h-24"></div>
    @endif
</div>