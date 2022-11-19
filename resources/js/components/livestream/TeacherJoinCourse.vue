<template>
  <div class="join-course-block__body">
    <!--Block left-->
    <div
        id="join-course-block__body__left"
        class="join-course-block__body__left"
        v-bind:class="{ 'up-size': upSizeBlockLeft }"
    >
      <teacher-video-live-stream
          :agora_id="agora_id"
          :courseSchedule="course"
          :all_sub_course="all_sub_course"
          :auth_user="auth_user"
          :gifts="gifts"
          :option_extra="option_extra_course"
          ref="videoLiveStream"
          v-on:openScreenChangeBackground="handleChangeScreenBackground"
          v-on:leaveRoom="leaveRoom"
          v-on:teacherJoined="teacherJoined"
      ></teacher-video-live-stream>
      <teacher-gift-shop
          :gifts="gifts"
          :creditCard="credit_card"
          :courseSchedule="course"
          :subCourse="sub_course"
          :isTeacher="true"
          v-on:buyHandUp="buyHandUp"
          v-if="show('gift')"
      ></teacher-gift-shop>
    </div>
    <!--Block right-->
    <div class="join-course-block__body__right" v-bind:class="{ 'up-size': upSizeBlockLeft }">
      <prepare-live-stream
          v-if="show('prepare')"
          :stash="stash"
          :end-course="endCourse"
          :course="course"
          @joinStream="joinStream"
          @readyJoinStream="readyJoinStream"
      />
      <change-background
          v-if="show('change-background')"
          v-on:setBackground="handleChangeBackground"
          :background="background"
          :listBackgroundRemove="auth_user.list_background_remove"
          role-user="teacher"
          v-on:close="handleChangeScreenBackground('CLOSE')"
      />
      <teacher-box-chat
          v-if="show('box-chat')"
          :creditCard="credit_card"
          :courseSchedule="course"
          :isTeacher="true"
          @getVolume="getVolume"
          ref="boxChat"
      ></teacher-box-chat>
      <box-extend v-if="show('box-extend')"
                  :extend_course="extend_course"
                  :option_extra="option_extra_course"
                  :courseSchedule="course"
                  :creditCard="credit_card"
                  :isTeacher="true"
      ></box-extend>
      <div class="note-livestream" v-if="!stash && course.is_mask_required != 0">
        <div class="text-red-note-livestream">【下記の場合にエフェクトが外れる場合がありますのでご注意ください】</div>
        <div>・画面から顔がはみ出そうな場合</div>
        <div>・顔を手で触ったりした場合</div>
        <div>・カメラの前を手で覆った場合</div>
        <div>・顔を左右上下に大きく向けた場合</div>
      </div>
    </div>
  </div>
  <!--  </div>-->
</template>

<script>

export default {
  name: "TeacherJoinCourse",
  props: ['course', 'agora_id', 'auth_user', 'gifts', 'credit_card', 'sub_course', 'all_sub_course', 'extend_course', 'option_extra_course', 'background', 'bought_gifts'],
  data() {
    return {
      videoCall: false,
      upSizeBlockLeft: false,
      localStream: null,
      teacherJoinedRoom: false,
      screen: {
        changeBackground: false
      },
      type: !this.course['course']['parent_course_id'] ? this.course['course']['category']['type'] : 2,
      stash: false,
      endCourse: false,
      resizeVideoToFull: false
    };
  },
  mounted() {
    this.init();
    if (this.course['course']['category']['type'] !== 1) {
      this.videoCall = true;
    }
    // window.addEventListener("resize", this.setMaxHeightChatBox);
  },
  methods: {
    init() {
    },
    show(screen) {
      switch (screen) {
        case 'prepare':
          return !this.teacherJoinedRoom && !this.screen.changeBackground;
        case 'change-background':
          return this.screen.changeBackground;
        case 'box-chat':
          return this.type === 1 &&
              this.teacherJoinedRoom &&
              !this.screen.changeBackground;
        case 'gift':
          return this.type === 1 &&
              this.teacherJoinedRoom;
        case 'box-extend':
          // return this.extend_course.length &&
          return this.type !== 1 &&
              this.teacherJoinedRoom &&
              !this.screen.changeBackground;
        default:
          return false;
      }
    },
    readyJoinStream() {
      this.stash = true;
    },
    joinStream() {
      this.$refs.videoLiveStream.startLiveStream();
    },
    teacherJoined() {
      if (this.type !== 1) {
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
      this.teacherJoinedRoom = true;
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
    leaveRoom(endCourseStatus = false) {
      this.stash = false;
      this.teacherJoinedRoom = false;
      this.endCourse = endCourseStatus;
      this.upSizeBlockLeft = false;
      if (this.resizeVideoToFull) {
        $('.livestream__layout-content').css('max-width', '');
        $('.join-course-block__body__left').width('');
      }
    },
    buyHandUp() {
      this.$refs.boxChat.buyHandUp();
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
