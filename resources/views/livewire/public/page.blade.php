<div class="w-full max-w-md min-h-screen bg-white shadow-xl flex flex-col justify-between relative border-x border-slate-200/50 mx-auto">

    @foreach($sections as $section)

        @if($section->type === 'text')
            @include('livewire.admin.landing-page.components.text-preview', ['section' => $section])
        @endif

        @if($section->type === 'image')
            @include('livewire.admin.landing-page.components.image-preview', ['section' => $section])
        @endif

        @if($section->type === 'button')
            @include('livewire.admin.landing-page.components.button-preview', ['section' => $section])
        @endif
       
        @if($section->type === 'button_checkout')
            @include('livewire.admin.landing-page.components.button-checkout-preview', ['section' => $section, 'isPreview' => false])
        @endif

        @if($section->type === 'script')
            @include('livewire.admin.landing-page.components.script-preview', ['section' => $section])
        @endif
        
        @if($section->type === 'product')
            @include('livewire.admin.landing-page.components.product-preview', ['section' => $section])
        @endif
        
        @if($section->type === 'product2')
            @include('livewire.admin.landing-page.components.product2-preview', ['section' => $section])
        @endif
        
        @if($section->type === 'program')
            @include('livewire.admin.landing-page.components.program-preview', ['section' => $section])
        @endif
        
        @if($section->type === 'program2')
            @include('livewire.admin.landing-page.components.program2-preview', ['section' => $section])
        @endif
        
       

    @endforeach

    @if($landingPage->blog)
        @include('blog.footer')
    @endif
    
    @if($landingPage->cart)
        <div class="h-24" ></div>
    @endif
</div>