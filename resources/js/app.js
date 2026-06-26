import './bootstrap';
import './image-cropper';
import { initQuillEditor } from './quill';

document.addEventListener('livewire:init', () => {
    // Panggil fungsi editor di sini
    initQuillEditor();
});