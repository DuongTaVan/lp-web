<template>
  <div class="livestream-info">
    <div class="time-left-note">
      <span>{{ endCourse ? titleEnd : title }}</span>
    </div>

    <div v-if="!timeout">
      <div class="livestream-time-remind" v-if="readyJoin && !endCourse">
        <count-down
            v-on:endTime="joinStream()"
            :startTime="checkTime"
        ></count-down>
        <div class="livestream-time-remind__note">※お時間になりましたら自動で開始します。</div>
<!--        <div class="livestream-time-remind__note__title">ご注意</div>-->
        <div class="livestream-time-remind__note__prohibited">
          <a>ガイドラインに違反する配信は禁止されています。</a>
        </div>
        <a href="/teacher/guidelines" class="text-decoration-none" target="_blank">
          <div class="livestream-time-remind__note__prohibited__link">ガイドライン禁止行為 ></div>
        </a>
      </div>

      <div class="livestream-ready" v-if="!readyJoin && !endCourse">
        <a class="btn btn-ready" @click="readyJoinStream()">準備OK</a>
        <p>
          <strong>(準備OK)</strong>のボタンを押すと<br/>
          開始時間までの残り時間が表示されます。
        </p>
      </div>

      <div class="note-effect note-effect-livestream" v-if="!endCourse">
        ※バーチャル背景をご利用の場合は 開始時間までにご準備お願いします。
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "PrepareLiveStream",
  props: ['course', 'stash', 'endCourse'],
  data() {
    return {
      readyJoin: !!this.stash,
      title: '開始までの残り時間',
      titleEnd: 'このサービスは終了しました。',
      timeout: false,
      diffTime: 0
    };
  },
  mounted() {
    this.checkDiffTime();
  },
  computed: {
    checkTime() {
      return new Date(this.course['start_datetime_string']).getTime() + this.diffTime;
    }
  },
  methods: {
    readyJoinStream() {
      if (new Date(this.course['end_datetime_string']).getTime() - (new Date().getTime() - this.diffTime) <= 0) {
        // this.title = 'このサービスは終了しました。';
        // this.timeout = true;
        location.reload();
        this.$destroy();

        return;
      }
      this.readyJoin = true;
      this.$emit('readyJoinStream');
    },
    joinStream() {
      this.$emit('joinStream');
    },
    async checkDiffTime() {
      const tokenRes = await this.getDiffTime();
      if (tokenRes.status !== 200) {
        return;
      }
      this.diffTime = tokenRes.data.diffTime;
    },
    getDiffTime() {
      return axios.post("/agora/token", {
        now: new Date()
      });
    }
  }
}
</script>

