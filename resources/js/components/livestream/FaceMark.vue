<template>
  <div id="maskVideo" class="mask-video">
    <div class="d-flex flex-wrap justify-content-center">
      <div class="mask-outline" v-for="item in listFaceMark" :key="item.name" @click="setFaceMark(item.deepAr)">
        <div class="mask-content">
          <h1 class="mask-name">{{ item.name }}</h1>
        </div>
        <img :src="item.url" alt="" @click="setFaceMark(item.deepAr)">
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "FaceMark",
  props: [],
  data() {
    return {
      listFaceMark: []
    };
  },
  mounted() {
    this.listFaceMark = [
      { url: '/assets/img/common/face-mask/rabbit.png', name: 'うさぎ', deepAr: 'rabbit_bg' },
      { url: '/assets/img/common/face-mask/owl.png', name: 'フクロウ', deepAr: 'owl_bg' },
      { url: '/assets/img/common/face-mask/monkey.png', name: 'サル', deepAr: 'monkey_bg' },
    ];
  },
  methods: {
    setFaceMark(deepAr) {
      this.$emit('setFaceMark', deepAr);
    }
  }
}
</script>

