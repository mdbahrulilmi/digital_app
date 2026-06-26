export function initQuillEditor() {
    Livewire.on('init-quill', (data) => {
        const id = data.id;
        const editorEl = document.getElementById('editor-' + id);
        const inputEl  = document.getElementById('content-' + id);

        if (!editorEl || editorEl.__quill) return;

        const quill = new Quill(editorEl, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'font': [] }, { 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['blockquote', 'code-block'],
                    ['clean']
                ]
            }
        });

        editorEl.__quill = quill;

        if (inputEl.value) {
            quill.root.innerHTML = inputEl.value;
        }

        quill.on('text-change', () => {
            inputEl.value = quill.root.innerHTML;
            inputEl.dispatchEvent(new Event('input', { bubbles: true }));
        });
    });
}