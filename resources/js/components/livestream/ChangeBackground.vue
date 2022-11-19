<template>
  <div class="background-body__background-block__change-image">
    <div class="background-body__background-block__change-image__title">
      <div class="d-flex">
        <div class="mr-auto background-body__background-block__change-image__title__name">
          背景
        </div>
        <div class="background-body__background-block__change-image__title__remove-image" @click="close">
          <img :src="'/assets/img/icons/close.svg'" alt="share">
        </div>
      </div>
    </div>
    <div class="background-body__background-block__change-image__img-preview">
      <img v-if="imageSelected" :src="imageSelected" alt="" class="img-fluid" id="test">
      <div v-if="!imageSelected" class="background-body__background-block__change-image__img-preview__none">
        <img :src="'/assets/img/common/background/default-bg.svg'" alt="">
      </div>
    </div>
    <div class="background-body__background-block__change-image__choose-image">
      <div class="row">
        <div class="col-4 col-md-4 background-body__background-block__change-image__choose-image__img-custom ">
          <div class="btn-custom-bg" @click="setBackground(null)">
            <img :src="'/assets/img/common/background/default-bg.svg'" alt="" class="img-fluid">
          </div>
        </div>
        <div class="col-4 col-md-4 background-body__background-block__change-image__choose-image__img-custom">
          <label for="upload-photo" class="btn-custom-bg">
            <img :src="'/assets/img/common/background/add-bg.svg'" alt="" class="img-fluid">
            <input type="file" name="photo" id="upload-photo" ref="file" @change="handleFileUpload()"/>
          </label>
        </div>
        <!-- PC -->
        <div
            v-for="(item, index) in listBackground"
            :key="index"
            class="col-4 col-md-4 background-body__background-block__change-image__choose-image__img-custom none-moblie"
            @click="setBackground(item, index)"
            @mouseover="hoverIndex = index"
            @mouseleave="hoverIndex = null"
        >
          <img
              :src="item"
              alt=""
              class="img-fluid img-background"
          >
          <div
              v-if="background[index] && hoverIndex === index"
              class="background-body__background-block__change-image__title__remove-image__icon"
              :style="{ opacity: indexSelected === index ? 0.5 : 1 }"
              @click.stop="removeImageBackground(index)"
          >
            <img :src="'/assets/img/icons/garbage.png'" alt="garbage">
          </div>
        </div>

        <!-- SP -->
        <div
            v-for="(item, index) in listBackground"
            :key="`${index}-mobile`"
            class="col-4 col-md-4 background-body__background-block__change-image__choose-image__img-custom moblie"
            @click="clickChangeBgOnMobile(item, index)"
        >
          <img
              :src="item"
              alt=""
              class="img-fluid img-background"
          >
          <div
              v-if="background[index] && hoverIndex === index"
              class="background-body__background-block__change-image__title__remove-image__icon"
              :style="{ opacity: indexSelected === index ? 0.5 : 1 }"
              @click.stop="removeImageBackground(index)"
          >
            <img :src="'/assets/img/icons/garbage.png'" alt="garbage">
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>

export default {
  name: "ChangeBackground",
  props: [
    'background',
    'listBackgroundRemove',
    'roleUser'
  ],
  data() {
    return {
      hoverIndex: null,
      imageSelected: null,
      indexSelected: null,
      listBackground: [],
      clicks: 0,
      delay: 700,
      timer: null
    };
  },
  mounted() {
    this.listBackground = [];

    this.background.forEach(el => {
      this.toDataURL(el, (base64) => {
        this.listBackground.unshift(base64);
      })
    });

    let defaultBackGround = [];
    if (this.roleUser === "teacher") {
      defaultBackGround = [
        '/assets/img/common/background/teacher/choi-sungwoo-Ju4OhQ1BT2o-unsplash.jpg',
        '/assets/img/common/background/teacher/domingo-alvarez-e-Niv2v0idsv0-unsplash.jpg',
        '/assets/img/common/background/teacher/frank-mckenna-OD9EOzfSOh0-unsplash.jpg',
        '/assets/img/common/background/teacher/jeb-buchman-NjrjrdJE8As-unsplash.jpg',
        '/assets/img/common/background/teacher/josefin-WS5yjFjycNY-unsplash (1).jpg',
        '/assets/img/common/background/teacher/luisa-brimble-1KYprL0KevE-unsplash.jpg',
        '/assets/img/common/background/teacher/pawel-czerwinski-BAiRfbt1HRE-unsplash.jpg',
        '/assets/img/common/background/teacher/rinck-content-studio-O8PjuNKatJ0-unsplash.jpg',
        '/assets/img/common/background/teacher/spacejoy-ml2RSaDME-k-unsplash.jpg',
        '/assets/img/common/background/teacher/imageedit_2_4190660094.jpg',
      ];
    } else {
      defaultBackGround = [
        '/assets/img/common/background/student/amy-tran-L2owAEPX0Vk-unsplash.jpg',
        '/assets/img/common/background/student/darius-bashar-mLAp01fMxr0-unsplash.jpg',
        '/assets/img/common/background/student/denise-bossarte-8rEJiVQk1Vw-unsplash.jpg',
        '/assets/img/common/background/student/evangelia-panteliadou-trKnwr2-I3A-unsplash.jpg',
        '/assets/img/common/background/student/maiar-shalaby-QJJyL8_XHCQ-unsplash.jpg',
        '/assets/img/common/background/student/nasa-yZygONrUBe8-unsplash.jpg',
        '/assets/img/common/background/student/ren-ran-Jy6luiLBsrk-unsplash (1).jpg',
        '/assets/img/common/background/student/spacejoy-8Y8U9fduILs-unsplash.jpg',
        '/assets/img/common/background/student/spacejoy-PyeXkOVmG1Y-unsplash.jpg',
        '/assets/img/common/background/student/spacejoy-q3Qd86sfaoU-unsplash (1).jpg',
      ];
    }

    if (this.listBackgroundRemove) {
      this.listBackgroundRemove.forEach(background => {
        const found = defaultBackGround.indexOf(background);
        if (found > -1) {
          defaultBackGround.splice(found, 1);
        }
      });
    }

    this.listBackground.push(...defaultBackGround);
  },
  methods: {
    clickChangeBgOnMobile(url, index) {
      this.clicks++;
      if (this.clicks === 1) {
        this.timer = setTimeout(() => {
          this.setBackground(url, index);
          this.clicks = 0;
        }, this.delay);
      } else {
        clearTimeout(this.timer);
        this.hoverIndex = index;
        this.clicks = 0;
      }
    },
    setBackground(url, index) {
      this.imageSelected = url;
      this.indexSelected = index ?? null;
      // if (/^http/.test(url)) {
      //   console.log(this.generateBase64(document.getElementById("test")));
      //   this.toDataURL(url, (dataUrl) => {
      //     this.$emit('setBackground', dataUrl);
      //     // console.log(dataUrl)
      //   })
      // } else {
      this.$emit('setBackground', url);
      if (!url) {
        this.$refs.file.value = "";
      }
      // }
    },
    async toDataURL(url, callback) {
      $.ajax({
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/api/get_content',
        data: {image: url}
      })
          .done(function (result) {
            callback(result)
          });

      // fetch(url, { mode: 'no-cors'})
      //     .then(response => response.blob())
      //     .then(imageBlob => {
      //       // Then create a local URL for that image and print it
      //       const imageObjectURL = URL.createObjectURL(imageBlob);
      //       console.log(imageBlob);
      //     });
      //   let xhr = new XMLHttpRequest();
      //   xhr.onload = function () {
      //     let reader = new FileReader();
      //     reader.onloadend = function () {
      //       callback(reader.result);
      //     }
      //     reader.readAsDataURL(xhr.response);
      //   };
      //   xhr.open('GET', url);
      //   // xhr.withCredentials = true;
      //   xhr.setRequestHeader('Access-Control-Allow-Origin', 'https://lappi-web.test');
      //   // xhr.setRequestHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
      //
      //   xhr.responseType = 'blob';
      //   xhr.send();
    },
    close() {
      this.$emit('close');
    },
    handleFileUpload() {
      const file = this.$refs.file.files[0];
      this.uploadFileToS3(file);
    },
    uploadFileToS3(file) {
      let formData = new FormData();
      formData.append('file', file);
      axios
          .post("/upload-image", formData)
          .then(response => {
            const imageS3Url = response.data.imageS3Url;
            let reader = new FileReader;
            reader.onload = e => {
              const url = e.target.result;
              this.setBackground(url, 0);
              this.listBackground.unshift(url);
              this.background.unshift(imageS3Url);
            }
            reader.readAsDataURL(file);
          })
          .catch((error) => {
            if (error.response) {
              error.response.data.data.errors.forEach(el => {
                toastr.error(el.error);
              });
            }
          });
    },
    removeImageBackground(index) {
      // if (index === this.indexSelected) return;
      if (index === null) return;
      if (index < this.background.length) {
        const imageS3Url = this.background[index];
        console.log(imageS3Url)
        axios
            .post("/remove-image", {path: imageS3Url})
            .then(res => {
              if (this.listBackground[index]) {
                if (index === this.indexSelected) {
                  this.setBackground(null);
                }
                this.listBackground.splice(index, 1);
                this.background.splice(index, 1);
              }
            })
            .catch((error) => {
              if (error.response) {
                error.response.data.data.errors.forEach(el => {
                  toastr.error(el.error);
                });
              }
            });
        // } else {
        //   if (this.listBackground[index]) {
        //     const imageDefaultUrl = this.listBackground[index];
        //     axios
        //       .post("/remove-image-default", { url: imageDefaultUrl })
        //       .then(res => {
        //           this.listBackground.splice(index, 1);
        //       })
        //       .catch((error) => {
        //         if (error.response) {
        //           error.response.data.data.errors.forEach(el => {
        //             toastr.error(el.error);
        //           });
        //         }
        //       });
        //   }
      }
    },
  }
}
</script>

<style lang="scss" scoped>
@media (min-width: 768px) {
  .none-moblie {
    display: block;
  }
  .moblie {
    display: none;
  }
}

@media (max-width: 767px) {
  .none-moblie {
    display: none;
  }
  .moblie {
    display: block;
  }
}
</style>
