import Editor from '@toast-ui/editor';
const AIDocument = new Editor({
    el: document.querySelector('#ai-document'),
    height: 'calc(100vh - 220px)',
    initialEditType: 'wysiwyg',
    previewStyle: 'tab',
    usageStatistics: true,
});

window.AIDocument = AIDocument;
