// import ClassicEditor from '../../clients/commons/ckeditor';
let configCkeditor = {
    toolbar: {
        items: [
            'bold',
            'italic',
            'bulletedList',
            'undo',
            'redo',
        ]
    },
    toolbarLocation: 'bottom',
    language: 'ja',
};

ClassicEditor.create(document.querySelector('#bodyNotification'), configCkeditor);