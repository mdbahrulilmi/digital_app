<div
    class="p-4 w-full max-w-md min-h-screen bg-white shadow-xl relative border-x border-slate-200/50 mx-auto"
    style="display:flex;flex-direction:column;"
>

    
    <div style="flex:1;">

        @foreach($sections as $section)

            <div style="margin-bottom:24px;">

                <div
                    style="
                        display:grid;
                        gap:8px;

                        {{ $section->layout == 'col-1' ? 'grid-template-columns:repeat(1,minmax(0,1fr));' : '' }}
                        {{ $section->layout == 'col-2' ? 'grid-template-columns:repeat(2,minmax(0,1fr));' : '' }}
                        {{ $section->layout == 'col-3' ? 'grid-template-columns:repeat(3,minmax(0,1fr));' : '' }}
                    "
                >

                    @foreach($section->components as $component)

                        @if($component->is_visible)

                            <div>

                                @includeIf(
                                    'livewire.admin.landing-page.components.' . $component->type . '-preview',
                                    [
                                        'component' => $component,
                                        'section' => $section,
                                        'isPreview' => false,
                                    ]
                                )

                            </div>

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