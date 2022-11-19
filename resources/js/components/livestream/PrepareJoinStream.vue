<template>
  <div class="livestream-info">
    <div class="time-left-note">
      <span>{{ title }}</span>
    </div>

    <div v-if="!timeout">
      <div class="livestream-time-remind__note" v-if="studentJoinedRoom">
        <!--        ※この講座はもう始まっています。-->
        ※配信開始まで、もうしばらくお待ち下さい。
      </div>
      <div class="livestream-time-remind__note" v-if="!studentUsedFaceMark">
        ※顔出し（NG）の講座では必ずLappiエフェクトを選択してください。
      </div>

      <div class="livestream-ready" @class v-if="studentPrepareJoinRoom">
        <!--        <a class="btn btn-ready" v-bind:class="{ disabled: !studentUsedFaceMark }" @click="readyJoinStream()">準備OK</a>-->
        <a class="btn btn-ready" @click="readyJoinStream()">準備OK</a>
        <p>
          <strong>(準備OK)</strong>のボタンを押すと<br/>
          開始時間までの残り時間が表示されます。
        </p>
      </div>

      <div class="livestream-time-remind" v-if="studentReadyJoinRoom">
        <count-down
            v-on:endTime="joinStream()"
            :startTime="checkTime"
        ></count-down>
        <div class="livestream-time-remind__note">※お時間になりましたら自動で開始します。</div>
      </div>

      <div class="note-effect" v-if="videoCall && studentPrepareJoinRoom">
        ※バーチャル背景、動物ARエフェクトをご利用の場合
        は開始時間までにご準備お願いします。
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "PrepareJoinStream",
  props: ['course', 'stash', 'onFaceMark'],
  data() {
    return {
      videoCall: false,
      timeout: false,
      title: '開始までの残り時間',
      studentPrepareJoinRoom: !this.stash,
      studentReadyJoinRoom: !!this.stash,
      studentJoinedRoom: false,
      teacherJoinedRoom: false,
      studentUsedFaceMark: false,
      countDownSuccess: false,
      diffTime: 0
    };
  },
  mounted() {
    this.studentUsedFaceMark = !this.course['is_mask_required'] ||
        (!this.course['course']['parent_course_id'] && this.course['course']['category']['type'] === 1);
    if (this.course['course']['parent_course_id'] || this.course['course']['category']['type'] !== 1) {
      this.videoCall = true;
    }
    if (this.onFaceMark) {
      this.studentUsedFaceMark = true;
    }
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
      // if (!this.studentUsedFaceMark) return;
      this.studentPrepareJoinRoom = false;
      this.studentReadyJoinRoom = true;
      this.$emit('readyJoinStream');
    },
    joinStream() {
      this.countDownSuccess = true;
      // if (!this.studentUsedFaceMark) return;
      this.$emit('joinStream');
    },
    prepareTeacherPublish() {
      this.studentReadyJoinRoom = false;
      this.studentJoinedRoom = true;
    },
    changeFaceMark(status) {
      this.studentUsedFaceMark = status;
      if (this.countDownSuccess && status) this.joinStream();
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

