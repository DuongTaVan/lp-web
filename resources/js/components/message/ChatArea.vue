<template>
  <main>
      <input class="test" style="position: absolute;top: -100px;">
      <div id="editor"></div>
  </main>
</template>

<script>
// import ClassicEditor from "../../clients/commons/ckeditor";
import MyUploadAdapter from "./uploadFile";

function SpecialCharactersEmoji( editor ) {
    editor.plugins.get( 'SpecialCharacters' ).addItems( 'Emoji', [
        { title: 'smiley face', character: '😊' },
        { title: 'rocket', character: '🚀' },
        { title: 'wind blowing face', character: '🌬️' },
        { title: 'floppy disk', character: '💾' },
        { title: 'heart', character: '❤️' }
    ] );
}

export default {
  mounted() {
    $('.test').focus();
    let self = this;
    let csrf = null;
    ClassicEditor
        .create(document.querySelector('#editor'), {
          toolbar: {
            items: [
              'bold',
              'italic',
              'strikethrough',
              'specialcharacters',
              'imageUpload'
            ]
          },
          placeholder: '返信する...',
          image: {
            toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight'],

            styles: [
              // This option is equal to a situation where no style is applied.
              'full',

              // This represents an image aligned to the left.
              'alignLeft',

              // This represents an image aligned to the right.
              'alignRight'
            ]
          },
          toolbarLocation: 'bottom',
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
        })
        .then(editor => {
          editor.plugins.get( 'SpecialCharacters' ).addItems('Emoji', [
            { title: 'smiley face', character: '😊' },
            { title: 'rocket', character: '🚀' },
            { title: 'wind blowing face', character: '🌬️' },
            { title: 'floppy disk', character: '💾' },
            { title: 'heart', character: '❤️' }
          ]);
          editor.plugins.get("FileRepository").createUploadAdapter = loader => {
            return new MyUploadAdapter(loader);
          };
          // check all image upload in message
          editor.model.document.on('change:data', () => {
            if (!!editor.getData()) {
              document.getElementById('send-img').src = '/assets/img/icons/send.svg';
              self.sendAble = true;
            } else {
              document.getElementById('send-img').src = '/assets/img/icons/send1.svg';
              self.sendAble = false;
            }
            Array.from(new DOMParser().parseFromString(editor.getData(), 'text/html')
                .querySelectorAll('img'))
                .map(img => {
                  let t = img.getAttribute('src');
                  if (t) {
                    let image = t.slice(0, t.indexOf('?'));
                    if (!self.listImageUrl.includes(image)) {
                      this.listImageUrl.push(image);
                    }
                  }
                  return null;
                });
          });
          self.ckeditor = editor;
          let makeWhiteSpace = false;
          const blackListKeyCode = [8, 13];
          editor.editing.view.document.on('keydown', (evt, data) => {
            if (editor.getData()) return;
            $('#logs').html(data.keyCode);
            if (!blackListKeyCode.includes(data.keyCode)) {
              editor.data.set("<p>　　</p>");
              makeWhiteSpace = true;
            }
            // if (data.keyCode === 13 && !data.shiftKey) {
            //   self.sendMessage();
            // }
          });
          editor.editing.view.document.on( 'change:isFocused', ( evt, data, isFocused ) => {
            if (makeWhiteSpace) {
              editor.data.set(editor.getData().replace(/　　/, ""));
              makeWhiteSpace = false;
            }
            setTimeout(() => {
              function scrollTop() {
                $('html, body').stop().animate({
                  scrollTop: 0
                },100,function(){})
              }
              if (isFocused){
                $(window).off().on("touchend", scrollTop);
              } else {
                $(window).off('touchend');
              }
            },50)
            } );
          if (document.getElementsByClassName('ck-sticky-panel')[0]) {
            document.getElementsByClassName('ck-sticky-panel')[0].classList.add('chat-area-toolbar');
            document.getElementsByClassName('ck-sticky-panel')[0].insertAdjacentHTML('beforeend', '<button id="send-message"><img id="send-img" src="/assets/img/icons/send1.svg"/></button>');
            self.$nextTick(function () {
              document.getElementById('send-message').addEventListener('click', self.sendMessage);
            });
          }
        });
  },
  data() {
    return {
      ckeditor: null,
      message: null,
      listImageUrl: [],
      sendAble: false
    };
  },
  methods: {
    sendMessage() {
      // check img remove and delete in firebase
      let self = this;
      if (!self.sendAble) return;
      let imgs = Array.from(new DOMParser().parseFromString(this.ckeditor.getData(), 'text/html')
          .querySelectorAll('img'))
          .map(img => {
            let srcAttribute = img.getAttribute('src');
            if (srcAttribute) {
              return srcAttribute.slice(0, srcAttribute.indexOf('?'));
            }
            return null;
          })
          .filter(img => {
            return img !== null;
          });
      // remove from firebase
      this.listImageUrl.map(img => {
        if (!imgs.includes(img)) {
          self.removeImageFirebase(img);
        }
      });
      this.message = this.ckeditor.getData('text/html');
      this.$emit('submit-message', this.message.replace(/&nbsp;/g, ''));

      this.listImageUrl = [];
      this.ckeditor.setData('');
    },
    removeImageFirebase(imgUrl) {
      let fileRef = this.$storage.refFromURL(imgUrl);
      fileRef.delete();
    }
  }
}
</script>

<style lang="scss">

.ck.ck-editor__main > .ck-editor__editable:not(.ck-focused) {
  border-color: #E5E5E5;
  border-radius: 30px;
  max-height: 15vh;
  overflow: auto;
  padding-right: 43px;
  @media (max-width:414px) {
      padding-right: 0;
  }
}

.ck .ck-editor__editable:not(.ck-editor__nested-editable) .ck-focused {
  border-radius: 30px !important;
}

.ck.ck-editor__editable_inline {
  border-radius: 30px !important;
}

.ck.ck-editor__editable_inline > p {
  margin-bottom: 0;
}

.ck.ck-editor__editable_inline > *:last-child {
  margin-bottom: 10.5px;
}

.ck.ck-editor__editable_inline > *:first-child {
  margin-top: 10.5px;
}

.ck.ck-editor__editable:not(.ck-editor__nested-editable).ck-focused {
  border: 1px solid #E5E5E5;
  outline: none;
  box-shadow: none;
  max-height: 15vh;
  overflow: auto;
  padding-right: 43px;
  @media (max-width:414px) {
      padding-right: 0;
  }
}

.ck-rounded-corners .ck.ck-editor__top .ck-sticky-panel .ck-toolbar, .ck.ck-editor__top .ck-sticky-panel .ck-toolbar.ck-rounded-corners {
  background: #F1F4F6;
  border: none;
}

.ck.ck-editor {
  display: flex;
  flex-direction: column-reverse;
}

.ck.ck-reset_all, .ck.ck-reset_all * {
  color: #2a3242;
}

.ck-editor {
  height: 90px;

  .chat-area-toolbar {
    position: relative;
    height: 43px;
  }

  .ck-placeholder {
    margin: 0px !important;
    height: 45px;
    line-height: 45px;
    font-size: 14px;
  }

  #send-message {
    position: absolute;
    right: 18px;
    bottom: 55px;

    img {
      cursor: pointer;
    }
  }

  img {
    width: 100px;
    height: 100px;
  }

  @media only screen and (max-width: 768px) {
    .ck-content {
      border-radius: 0 !important;
      p {
        padding-right: 43px;
      }
    }
    .chat-area-toolbar {
      position: relative;
      height: auto;
    }
    .ck-toolbar {
      background: #F8F8F8 !important;
      border: 1.04297px solid #E6E6E6 !important;
    }
  }
  .image-inline.ck-widget{
    margin: 0 10px;
  }
}
</style>
