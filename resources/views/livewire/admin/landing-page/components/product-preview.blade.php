@php
    $content = $component->content ?? [];

    $style = $content['product_style'] ?? 'card';
@endphp


<div class="@container w-full">

    @includeIf(
        'livewire.admin.landing-page.components.product.' . $style,
        [
            'component' => $component,
            'content' => $content,
        ]
    )

</div>