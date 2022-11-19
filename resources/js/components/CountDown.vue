<template>
  <counter :min0="min0" :min1="min1" :sec0="sec0" :sec1="sec1"></counter>
</template>

<script>
if (!Math.trunc) {
  Object.defineProperty(Math, "trunc", {
    value: function(val) {
      return val < 0 ? Math.ceil(val) : Math.floor(val);
    }
  });
}
export default {
  name: "CountDown",
  props: {
    startTime: {
      // pass date object till when you want to run the timer
      type: Number,
      default() {
        return new Date().getTime();
      },
    },
    negative: {
      // optional, should countdown after 0 to negative
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      now: new Date().getTime(),
      timer: null,
    };
  },
  computed: {
    min0() {
      let m = Math.trunc((this.startTime - this.now) / 1000 / 60);
      if (m >= 15) {
        return '--';
      }

      return m > 9 ? '1' : '0';
    },
    min1() {
      let m = Math.trunc((this.startTime - this.now) / 1000 / 60);
      if (m >= 15) {
        return '--';
      }

      return m < 0 ? '0' : m.toString().slice(-1);
    },
    sec0() {
      let m = Math.trunc((this.startTime - this.now) / 1000 / 60);
      if (m >= 15) {
        return '--';
      }
      let s = Math.trunc((this.startTime - this.now) / 1000) % 60;

      return s > 9 ? s.toString().slice(0, 1) : '0';
    },
    sec1() {
      let m = Math.trunc((this.startTime - this.now) / 1000 / 60);
      if (m >= 15) {
        return '--';
      }
      let s = Math.trunc((this.startTime - this.now) / 1000) % 60;

      return s < 0 ? '0' : s.toString().slice(-1);
    },
 
  },
  watch: {
    startTime: {
      immediate: true,
      handler(newVal) {
        if (this.timer) {
          clearInterval(this.timer);
        }
        this.timer = setInterval(() => {
          this.now = new Date().getTime();
          if (this.negative) return;
          if (this.now > newVal) {
            this.now = newVal;
            this.$emit("endTime");
            clearInterval(this.timer);
          }
        }, 1000);
      },
    },
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
};
</script>
