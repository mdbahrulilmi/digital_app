@if($component->type === 'spacer')

<div
    style="height: {{ $component->content['height'] ?? 40 }}px;"
></div>

@endif