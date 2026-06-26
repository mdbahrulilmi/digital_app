<div wire:ignore class="quill-wrapper">
    <div id="editor-{{ $editingSectionId }}"></div>
</div>

<input type="hidden" id="content-{{ $editingSectionId }}" wire:model="editingContent.text">