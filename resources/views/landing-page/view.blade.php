@extends('layouts.public')

@section('content')

<div class="w-full max-w-md min-h-screen bg-white shadow-xl flex flex-col justify-between relative border-x border-slate-200/50">

        @foreach($sections as $section)

            @if($section->type === 'text')
                @include('livewire.landing-page.components.text-preview', [
                    'section' => $section
                ])
            @endif

            @if($section->type === 'image')
                @include('livewire.landing-page.components.image-preview', [
                    'section' => $section
                ])
            @endif

            @if($section->type === 'button')
                @include('livewire.landing-page.components.button-preview', [
                    'section' => $section
                ])
            @endif
            
            @if($section->type === 'product')
                @include('livewire.landing-page.components.product-preview', [
                    'section' => $section
                ])
            @endif
            
            @if($section->type === 'product2')
                @include('livewire.landing-page.components.product2-preview', [
                    'section' => $section
                ])
            @endif

        @endforeach
    @if($landingPage->blog)
        @include('blog.footer')
    @endif
</div>


@endsection