<template>
  <div id="myModal" class="modal" :class="{open: show}">
    <span class="close" @click="$emit('hidden')">&times;</span>
    <img id="content-image" class="modal-content" :src="imageUrl" @load="finishLoadImg">
    <div id="caption"></div>
  </div>
</template>

<script>
export default {
  props: ['imageUrl', 'show'],
  mounted() {
    document.addEventListener("keydown", (e) => {
      if (e.which === 27) {
        this.$emit('hidden');
      }
    });
  },
  watch: {
    show: {
      deep: true,
      handler: function(val) {
        if (val) {
          document.getElementsByTagName('body')[0].style.overflow = 'hidden';
        } else {
          document.getElementsByTagName('body')[0].style.overflow = 'auto';
        }
      }
    }
  },
  methods: {
    finishLoadImg() {
      const img = new Image();
      img.src = this.imageUrl;
      img.onload = function() {
        let imgWidth = this.width;
        let imgHeight = this.height;
        let imagePercent = imgWidth/imgHeight;
        let windowWidth = window.innerWidth - 100;
        let windowHeight = window.innerHeight - 80;
        let windowPercent = windowWidth/windowHeight;
        let width = 0, height = 0;

        if (imagePercent > windowPercent) {
          width = windowWidth;
          height = width/imagePercent;
        } else {
          height = windowHeight;
          width = height * imagePercent;
        }

        document.getElementById('content-image').style.width = String(width) + 'px';
        document.getElementById('content-image').style.height = String(height) + 'px';
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  /* The Close Button */
  .close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    cursor: pointer;
  }
  /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 101; /* Sit on top */
    padding-top: 40px; /* Location of the box */
    padding-bottom: 40px; /* Location of the box */
    left: 0;
    top: 0;
    overflow: hidden; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    &.open {
      display: flex;
      justify-content: center;
      align-items: center;
    }
  }

  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
  }
</style>