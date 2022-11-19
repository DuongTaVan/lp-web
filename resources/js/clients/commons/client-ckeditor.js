// import ClassicEditor from './ckeditor';
var csrf = document.querySelector('meta[name="csrf-token"]').content;
ClassicEditor
    .create( document.querySelector( '#editor' ), {
        image: {
            toolbar: [ 'imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight' ],

            styles: [
                // This option is equal to a situation where no style is applied.
                'full',

                // This represents an image aligned to the left.
                'alignLeft',

                // This represents an image aligned to the right.
                'alignRight'
            ]
        },
        simpleUpload: {
            // The URL that the images are uploaded to.
            uploadUrl: window.location.origin + '/ckeditor/upload',

            // Enable the XMLHttpRequest.withCredentials property.
            withCredentials: true,

            // Headers sent along with the XMLHttpRequest to the upload server.
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        },
        toolbarLocation: 'bottom'
    });
