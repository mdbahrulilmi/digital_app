<input
    type="range"
    min="0"
    max="200"
    wire:model.live="editingContent.height"
    class="w-full"
/>

<p class="mt-2 text-sm text-gray-600">
    {{ $editingContent['height'] ?? 40 }} px
</p>