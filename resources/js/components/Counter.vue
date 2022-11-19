<template>
  <strong>
    <div class="lappi-digit" :class="'digit-' + min0"></div>
    <div class="lappi-digit" :class="'digit-' + min1"></div>
    <span>分</span>
    <div class="lappi-digit" :class="'digit-' + sec0"></div>
    <div class="lappi-digit" :class="'digit-' + sec1"></div>
    <span>秒</span>
  </strong>
</template>

<script>
export default {
  props: ["min0", "min1", "sec0", "sec1"],
};
</script>
