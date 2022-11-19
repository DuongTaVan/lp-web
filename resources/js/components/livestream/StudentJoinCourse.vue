<template>
  <div class="join-course-block__body">
    <!--Block left-->
    <div
      id="join-course-block__body__left"
      class="join-course-block__body__left"
      v-bind:class="{ 'up-size': upSizeBlockLeft }"
    >
      <student-video-live-stream
        :agora_id="agora_id"
        :auth_user="auth_user"
        :courseSchedule="course"
        :all_sub_course="all_sub_course"
        :gifts="gifts"
        ref="videoLiveStream"
        v-on:leaveRoom="leaveRoom"
        v-on:joinedRoom="joinedRoom"
        v-on:userPublished="userPublished"
        v-on:studentChangeFaceMark="handleChangeFaceMark"
        v-on:openScreenChangeBackground="handleChangeScreenBackground"
      />

      <student-gift-shop
        v-if="show('gift')"
        :gifts="gifts"
        :creditCard="credit_card"
        :courseSchedule="course"
        :subCourse="sub_course"
        v-on:purchaseGiftSuccess="handlePurchaseGiftSuccess"
        v-on:buyHandUp="buyHandUp"
        v-on:sendQuestion="sendQuestion"
        v-on:sendQuestionStamp="sendQuestionStamp"
        ref="giftShop"
      />
    </div>

    <!--Block right-->
    <div
      class="join-course-block__body__right"
      v-bind:class="{ 'up-size': upSizeBlockLeft }"
    >
      <prepare-join-stream
        v-if="show('prepare')"
        :course="course"
        :stash="stash"
        ref="prepareJoinStream"
        @joinStream="joinStream"
        :onFaceMark="onFaceMark"
        @readyJoinStream="readyJoinStream"
      />
      <change-background
        v-if="show('change-background')"
        :background="background"
        role-user="student"
        :listBackgroundRemove="auth_user.list_background_remove"
        v-on:setBackground="handleChangeBackground"
        v-on:close="handleChangeScreenBackground('CLOSE')"
      />
      <student-box-chat
        v-if="show('box-chat')"
        ref="boxChat"
        :creditCard="credit_card"
        :courseSchedule="course"
        v-on:getHand="getHand"
        v-on:suggestComment="suggestComment"
        v-on:suggestCommentStamp="suggestCommentStamp"
        @getVolume="getVolume"
      />
      <box-extend
        v-if="show('box-extend')"
        :courseSchedule="course"
        :extend_course="extend_course"
        :creditCard="credit_card"
        :option_extra="option_extra_course"
        @buy-extend-success="buyExtendSuccess"
      />

      <div class="note-livestream" v-if="type === 'call' && !stash">
        <div class="text-red-note-livestream">【下記の場合にエフェクトが外れる場合がありますのでご注意ください】</div>
        <div>・画面から顔がはみ出そうな場合</div>
        <div>・顔を手で触ったりした場合</div>
        <div>・カメラの前を手で覆った場合</div>
        <div>・顔を左右上下に大きく向けた場合</div>
      </div>
    </div>

  </div>
</template>

<script>

export default {
  name: "StudentJoinCourse",
  props: ['course', 'agora_id', 'auth_user', 'gifts', 'credit_card', 'sub_course', 'all_sub_course', 'temp_image', 'extend_course', 'option_extra_course', 'background', 'bought_gifts'],
  data() {
    return {
      upSizeBlockLeft: false,
      localStream: null,
      screen: {
        changeBackground: false
      },
      studentPrepareJoinRoom: false,
      teacherJoinedRoom: false,
      type: !this.course['course']['parent_course_id'] && this.course['course']['category']['type'] === 1 ? 'live' : 'call',
      stash: false,
      onFaceMark: false,
      resizeVideoToFull: false,
      videoCall: false
    };
  },
  mounted() {
    this.init();
    // window.addEventListener("resize", this.setMaxHeightChatBox);
  },
  methods: {
    init() {
      this.studentPrepareJoinRoom = true;
    },
    buyExtendSuccess(extend, options) {
      this.$refs.videoLiveStream.buyExtendSuccess(extend, options);
    },
    show(screen) {
      switch (screen) {
        case 'prepare':
          return this.studentPrepareJoinRoom && !this.screen.changeBackground;
        case 'change-background':
          return this.screen.changeBackground;
        case 'box-chat':
          return this.type === 'live' &&
              this.teacherJoinedRoom &&
              !this.screen.changeBackground;
        case 'gift':
          return this.type === 'live' &&
              this.teacherJoinedRoom;
        case 'box-extend':
          // return this.extend_course.length &&
          //     this.type !== 'live' &&
          //     this.teacherJoinedRoom &&
          //     !this.screen.changeBackground;
          return this.type !== 'live' &&
              this.teacherJoinedRoom &&
              !this.screen.changeBackground;
        default:
          return false;
      }
    },
    readyJoinStream() {
      this.stash = true;
    },
    joinedRoom() {
      this.$refs.prepareJoinStream.prepareTeacherPublish();
    },
    handleChangeFaceMark(status) {
      this.onFaceMark = status;
      this.$refs.prepareJoinStream.changeFaceMark(status);
    },
    userPublished() {
      this.studentPrepareJoinRoom = false;
      this.teacherJoinedRoom = true;
      if (this.type !== 'live') {
        this.upSizeBlockLeft = true;

        if (!this.extend_course.length && !this.option_extra_course.length) {
          this.resizeVideoToFull = true;
          $('.livestream__layout-content').css('max-width', '1070px');
          $('.join-course-block__body__left').width('100%');
        }

        setTimeout(() => {
          this.$refs.videoLiveStream.setSizeBlockVideoLocal();
        }, 1);
      }
    },
    joinStream() {
      this.$refs.videoLiveStream.playLiveStream();
    },
    handleChangeScreenBackground(action) {
      this.screen.changeBackground = action === 'OPEN';

      if (action === 'CLOSE') {
        this.$refs.videoLiveStream.handleScreenChangeBackground('CLOSE');
      }
    },
    handleChangeBackground(url) {
      this.$refs.videoLiveStream.changeBackground(url);
    },
    leaveRoom() {
      this.stash = false;
      this.studentPrepareJoinRoom = true;
      this.teacherJoinedRoom = false;
      this.upSizeBlockLeft = false;
      if (this.resizeVideoToFull) {
        $('.livestream__layout-content').css('max-width', '');
        $('.join-course-block__body__left').width('');
      }
    },
    handlePurchaseGiftSuccess(giftId) {
      this.$refs.videoLiveStream.studentPurchaseGiftSuccess(giftId);
    },
    getHand(res) {
      this.$refs.giftShop.getHand(res);
    },
    buyHandUp() {
      this.$refs.boxChat.buyHandUp();
    },
    sendQuestion(forceSend, message) {
      this.$refs.boxChat.sendQuestion(forceSend, message);
    },
    sendQuestionStamp(forceSend, message) {
      this.$refs.boxChat.sendQuestionStamp(forceSend, message);
    },
    suggestComment(message) {
      this.$refs.giftShop.suggestComment(message);
    },
    suggestCommentStamp(message) {
      this.$refs.giftShop.suggestCommentStamp(message);
    },
    isMobileDevice() {
      return window.innerWidth < 767;
      return /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)
          || (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.platform))
          || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    },
    setMaxHeightChatBox() {
      const commentBlock = document.getElementById('comment-block');
      if (!commentBlock) return;
      let totalHeight = 0;
      if (this.isMobileDevice()) {
        const header = document.getElementById('layout-header').offsetHeight;
        // const joinCourseHeader = document.getElementById('join-course-header').offsetHeight;
        const video = document.getElementById('block-video').offsetHeight;
        const quickChat = document.getElementById('quick-chat').offsetHeight;
        const gift = document.getElementById('gift-mobile').offsetHeight;
        const extraPadding = 40;

        totalHeight = header + video + gift + quickChat + extraPadding;

        document.body.style.overflow = "hidden";
        commentBlock.style.maxHeight = `${window.innerHeight - totalHeight}px`;
      }
    },
    getVolume(callback) {
      callback(this.$refs.videoLiveStream.remoteTracks.volume);
    }
  }
};
</script>
