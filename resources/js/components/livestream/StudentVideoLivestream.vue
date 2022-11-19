<template>
  <div class="join-course-block__body__left__video"
       @click="!isMobile() ? null : (showButton = !showButton)"
       @mouseover="isMobile() ? null : (showButton = true)"
       @mouseleave="isMobile() ? null : (showButton = false)"
       v-bind:class="{'fullscreen': localTracks.fullscreen}"
       :style="style.blockVideo">
    <div class="backdrop" v-bind:class="{'fullscreen': localTracks.fullscreen}"></div>
    <img id="imgBg" class="join-course-block__body__left__video__temp" :src="courseSchedule['image']" alt="">

    <div id="block-video" class="join-course-block__body__left__video__block">
      <div :style="style.frameMainVideo">

        <!--gift-->
        <div v-if="type === 'live' && state.teacherJoined" class="livestream__gift-banner"
             id="gift-banner-list"
             :style="style.giftBanner">
          <div v-for="item in normalGift" class="livestream__banner__item-wrapper">
            <div class="livestream__banner__item">

              <span class="livestream__banner__item-avatar">
                  <img :src="item.user.profile" alt="">
              </span>
              <div class="livestream__banner__item-info">
                <div class="item-info__name">{{ item.user.fullName }}</div>
                <div class="item-info__detail">Send {{ item.gift.name }}</div>
              </div>

              <div class="livestream__banner__item-gift">
                <img :src="item.gift.image" alt="">
              </div>
            </div>
          </div>
        </div>

        <!--super gift-->
        <div v-if="type === 'live' && state.teacherJoined" id="gift-banner-super" class="livestream__gift-banner__super"
             v-bind:class="{'fullscreen': localTracks.fullscreen}">
          <div v-for="item in superGift" class="livestream__gift-banner__super-item">
            <div class="item-gift">
              <img :src="item.gift.image" alt="">
            </div>
          </div>
        </div>

        <!--share screen video-->
        <div id="screen-video" class="join-course-block__body__left__video__screen-video" :style="style.screenVideo">
        </div>

        <!--deepar or camera video-->
        <div
            :hidden="!localTracks.grantedCamera || !localTracks.videoTrackEnabled"
            id="local-video"
            class="join-course-block__body__left__video__local-video"
            :style="style.localVideo"
        >
        <span class="description">
          プレゼンテーション（あなた）
        </span>
          <canvas id="canvas-video" :hidden="!localTracks.grantedCamera || !localTracks.videoTrackEnabled"></canvas>
        </div>

        <!--remote video-->
        <div
            id="remote-video"
            v-if="showVideoCall && connectRoom"
            class="join-course-block__body__left__video__remote-video"
            :style="style.remoteVideo"
        >
        </div>
      </div>
    </div>

    <div v-if="localTracks.localVideoElementId && local.eventHappening !== 'CHANGE-BACKGROUND' && showButton"
         class="join-course-block__body__left__video__control d-flex flex-row"
         v-bind:class="{'fullscreen': localTracks.fullscreen}">
      <div class="mr-auto pr-2 btn-control-custom" @click.stop="">
        <button class="btn btn-speaker" data-original-title="音量" v-tooltip="true" @click.prevent.stop="handleVolume">
          <img :src="'/assets/img/icons/' + (remoteTracks.volume ? '' : 'off-') + 'speaker.svg'" alt="speaker">
        </button>
        <vue-slider v-model="remoteTracks.volume" v-bind="optionsSlider"></vue-slider>
      </div>
      <div class="btn-control-custom share-screen" v-if="type === 'rtc' && connectRoom">
        <button class="btn btn-control-custom" @click.prevent.stop="handleScreenToggle"
                data-original-title="画面共有" v-tooltip="true">
          <img :src="'/assets/img/icons/share.svg'" alt="share">
        </button>
      </div>
      <div class="btn-control-custom" v-if="type === 'rtc'">
        <button v-if="!changeFaceMark" class="btn btn-control-custom" @click.prevent.stop="handleVideoToggle"
                v-tooltip="true" data-original-title="カメラ">
          <img :src="'/assets/img/icons/' + (!localTracks.videoTrackEnabled ? 'off-' : '') + 'cam.svg'" alt="cam">
        </button>
      </div>
      <div class="btn-control-custom" v-if="type === 'rtc'">
        <button v-if="!changeFaceMark" class="btn btn-control-custom" @click.prevent.stop="handleAudioToggle"
                v-tooltip="true" data-original-title="マイク">
          <img :src="'/assets/img/icons/' + (!localTracks.audioTrackEnabled ? 'off-' : '') + 'mic.svg'" alt="mic">
        </button>
      </div>
      <div class="btn-control-custom" v-if="connectRoom">
        <button class="btn btn-control-custom" @click.prevent.stop="handleEndCall(true)" v-tooltip="true"
                data-original-title="終了">
          <img src="/assets/img/icons/call.svg" alt="End Call">
        </button>
      </div>

      <div class="px-2 bd-highlight btn-control-custom" v-if="connectRoom">
        <button v-if="!localTracks.fullscreen" class="btn btn-control-custom" @click.prevent.stop="handleFullscreen"
                v-tooltip="true"
                data-original-title="全画面表示">
          <img :src="'/assets/img/icons/fullscreen.svg'" alt="Fullscreen">
        </button>
        <button v-if="localTracks.fullscreen" class="btn btn-control-custom" @click.prevent.stop="handleFullscreen"
                v-tooltip="true"
                data-original-title="全画面非表示">
          <img :src="'/assets/img/icons/exit-fullscreen.svg'" alt="Fullscreen">
        </button>
      </div>

      <div class="ml-auto pl-2 btn-control-custom option-livestream-button">
        <img v-if="!connectRoom && type === 'rtc'" id="vc-btn" src="/assets/img/icons/svg.svg" alt="svg"
             class="btn btn-custom drop-btn-video-call drop-btn-video-call-small"
             @click.prevent.stop="handleClickDropdown">
        <div v-if="!connectRoom && type === 'rtc'" class="dropdown2 dropdown-video-call-small">
          <div class="triangle-up"></div>
          <a @click.prevent.stop="handleScreenChangeBackground('OPEN')">背景変更</a>
          <!--          <a v-if="local.showFaceMark" @click="changeFaceMark = !changeFaceMark">動物マスク</a>-->
          <a @click.prevent.stop="changeFaceMark = !changeFaceMark">動物マスク</a>
          <a @click.prevent.stop="turnOffFaceMark">マスク無し</a>
        </div>
      </div>
      <div class="ml-auto pl-2 btn-control-custom option-livestream-button-mobile"
           @click.prevent.stop="handleShowOptionLivestream(true)">
        <img v-if="!connectRoom && type === 'rtc'" src="/assets/img/icons/svg.svg" alt="svg"
             class="btn btn-custom drop-btn-video-call drop-btn-video-call-small">
      </div>
    </div>

    <face-mark v-if="changeFaceMark" v-on:setFaceMark="setFaceMark"></face-mark>

    <div v-if="state.teacherJoined && type === 'live'" class="join-course-block__body__left__video__viewers"
         v-bind:class="{'fullscreen': localTracks.fullscreen}">
      <div class="livestream-icon"><img :src="'/assets/img/icons/record.svg'" alt="live">Live</div>
      <div class="viewer-icon"><img :src="'/assets/img/icons/eye-livestream.svg'" alt="time">{{ viewer }}人</div>
    </div>
    <div v-if="state.teacherJoined" class="join-course-block__body__left__video__timeline"
         v-bind:class="{'fullscreen': localTracks.fullscreen}">
      {{ timeline.text }}
    </div>

    <div class="option-livestream-mobile-outline" v-if="showOptionDropDown"></div>
    <div class="option-livestream-mobile" v-if="showOptionDropDown">
      <div class="option-livestream-mobile__button-close" @click.prevent.stop="handleShowOptionLivestream(false)">
        <img src="/assets/img/icons/close-option.svg" alt="">
      </div>
      <div class="option-livestream-mobile__content">
        <a @click.prevent.stop="handleScreenChangeBackground('OPEN')">背景変更</a>
        <a @click.prevent.stop="changeFaceMark = !changeFaceMark;showOptionDropDown=!showOptionDropDown">動物マスク</a>
        <a @click.prevent.stop="turnOffFaceMark">マスク無し</a>
      </div>
    </div>
  </div>
</template>

<script>
import '../../clients/commons/dropdown_video_call';
import AgoraRTC from "agora-rtc-sdk-ng";
import Gathering from "../../clients/commons/gathering";
import delay from "delay";
import {useSound} from "@vueuse/sound";
import SocketClient from "../../clients/commons/socket";

export default {
  name: "StudentVideoLiveStream",
  props: ['agora_id', 'auth_user', 'courseSchedule', 'all_sub_course', 'gifts'],
  setup() {
    const {play, stop} = useSound(window.location.origin + '/assets/sounds/notification-2.wav');

    return {
      play,
      stop,
    }
  },
  data() {
    return {
      showOptionDropDown: false,
      client: null,
      localTracks: {
        grantedCamera: false,
        // modeTrack: '',
        videoTrack: null,
        screenTrack: null,
        audioTrack: null,
        tempTrack: null,
        tempScreenTrack: null,
        videoTrackEnabled: true,
        audioTrackEnabled: true,
        fullscreen: false,
      },
      remoteTracks: {
        uid: null,
        videoTrack: null,
        audioTrack: null,
        volume: 100
      },
      mutedAudio: false,
      mutedVideo: false,
      options: {
        appid: null,
        channel: null,
        uid: null,
        token: null,
        role: null, // host or audience
        videoConfig: null,
        cameraVideoProfile: null
      },
      playerContainer: null,
      connectRoom: false,
      deepAr: {
        init: null,
        effect: null,
        element: null,
        tempBackground: null,
        tempFaceMark: null,
      },
      teacherNotPublish: false,
      // param video call
      showVideoCall: false,
      viewer: 0,
      timeline: {
        text: '',
        function: null,
      },
      type: !this.courseSchedule['course']['parent_course_id'] && this.courseSchedule['course']['category']['type'] === 1 ? 'live' : 'rtc',
      roomFirebase: null,
      roomSocket: null,
      showTempCourse: true,
      changeFaceMark: false,
      local: {
        eventHappening: null,
        reconnecting: false,
        showFaceMark: false
      },
      remote: {
        connectionState: null,
        reconnect: null
      },
      style: {
        blockVideo: {},
        screenVideo: {},
        localVideo: {},
        remoteVideo: {},
        localControl: {},
        localCounter: {},
        tempVideo: {},
        frameMainVideo: {},
        giftBanner: {}
      },
      normalGift: [],
      superGift: [],
      stashNormalGift: [],
      stashSuperGift: [],
      optionsSlider: {
        dotSize: 12,
        width: 66,
        processStyle: {backgroundColor: 'rgba(255, 255, 255, 0.5)'},
        railStyle: {backgroundColor: 'rgba(255, 255, 255, 0.2)'},
      },
      listSubcribe: [],
      scaleFull: null,
      showButton: true,
      state: {
        studentPublished: false,
        teacherJoined: false
      },
      minimize: {
        deepAr: false,
        screen: false,
      },
      isHandleEndCall: false,
    };
  },
  async mounted() {
    await this.defaultValue();
    const that = this;
    setTimeout(function () {
      that.setSizeBlockVideoLocal();
    }, 100);
  },
  created() {
    const that = this;
    document.addEventListener("scroll", function (value) {
      if ($(window).width() < 768) {
        const rect = document.getElementById('join-course-block__body__left').getBoundingClientRect();
        const header = document.getElementById('header').getElementsByClassName('header__left left-full')[0];
        const video = document.getElementById('join-course-block__body__left');
        const stamp = document.getElementById('quick-chat');
        if (rect.top <= header.offsetHeight) {
          if (that.style.blockVideo.position !== 'fixed') {
            that.style.blockVideo = {
              position: 'fixed',
              top: `${header.offsetHeight}px`
            };
            stamp.style.position = 'fixed';
            stamp.style.top = `${header.offsetHeight + video.offsetHeight - 1}px`;
            stamp.style.left = '20px';
            stamp.style.right = '20px';
          }
        } else {
          if (that.style.blockVideo.position === 'fixed') {
            that.style.blockVideo = {};
            stamp.style = null;
          }
        }
      }
    });
    window.addEventListener("resize", function () {
      that.setSizeBlockVideoLocal();
    });
  },
  destroyed() {
    const that = this;
    // document.removeEventListener("scroll");
    window.removeEventListener("resize", function () {
      that.setSizeBlockVideoLocal();
    });
  },
  watch: {
    "remoteTracks.volume"(val) {
      if (!this.remoteTracks.audioTrack) return;

      if (val !== 0) {
        if (!this.remoteTracks.audioTrack.isPlaying) {
          this.remoteTracks.audioTrack.play();
        }
        this.remoteTracks.audioTrack.setVolume(val);
      } else {
        this.remoteTracks.audioTrack.stop();
      }
    }
  },
  methods: {
    async defaultValue() {
      this.options.videoConfig = {
        fit: 'contain'
      };
      // this.options.cameraVideoProfile = {width: 870, height: 490};
      this.options.cameraVideoProfile = '720p';
      this.localTracks.localVideoElementId = 'local-video';
      this.local.showFaceMark = !!this.courseSchedule.course['is_mask_required'] || this.type === 'live';
      this.client = AgoraRTC.createClient({mode: this.type, codec: "vp8"});
      // set option config channel agora
      this.options.appid = this.agora_id;
      this.options.channel = this.courseSchedule.agora_channel;
      const tokenRes = await this.generateToken(this.options.channel);
      this.options.token = tokenRes.data;
      this.options.role = 'audience';
      this.options.uid = this.auth_user.user_id;

      if (this.type === 'rtc') {
        await this.addDevice();
        // this.createCameraStream();
        this.initDeepAr();
      }
    },
    turnOffFaceMark() {
      this.deepAr.tempFaceMark = null;
      this.switchEffectDeepAr(null, 'FACE-MARK')
    },
    timeLineFunc() {
      clearInterval(this.timeline.function);
      let endTime = this.getTime(this.courseSchedule['actual_end_date'] ?? this.courseSchedule['end_datetime_string']);
      const diffTime = this.courseSchedule['diffTime'] ?? 0;
      console.log(diffTime);

      this.timeline.function = setInterval(() => {
        const now = this.getTime(new Date());
        const time = endTime - (now - diffTime);

        if (+time < 0) {
          clearInterval(this.timeline.function);
          this.handleEndCall();
          this.timeline.text = '00分 00秒';
          return;
        }

        const {min, sec} = this.getHMOfTime(time);
        this.timeline.text = `${min}分 ${sec}秒`;
      }, 1000);
    },
    getHMOfTime(time = 0) {
      let min = Math.trunc(time / 1000 / 60);
      let sec = Math.trunc(time / 1000) % 60;
      min = (min > 9 || min < 0) ? min : "0" + min;
      sec = (sec > 9 || sec < 0) ? sec : "0" + sec;

      return {min, sec};
    },
    buyExtendSuccess(extend, options) {
      this.courseSchedule['teacher_join_late'] = false;
      const minute = extend ? extend['minutes_required'] : 0;
      const optionIds = options.length > 0 ? options.map(el => el['optional_extra_id']) : [];

      if (minute || optionIds.length > 0) this.sendNotiToTeacher(minute, optionIds, {
        fullName: this.auth_user['full_name'],
        profile: this.auth_user['profile_thumbnail']
      });

      // disable uncheck default option purchase issues 1307
      if (optionIds && optionIds.length) this.disableBuyOption(optionIds);
    },
    sendNotiToTeacher(minute, optionIds, user) {
      if (this.roomFirebase) {
        this.roomFirebase.purchaseExtendSuccess({minute, optionIds, user});
      }
      this.addTimeToAgoraToken(minute);
    },
    async addTimeToAgoraToken() {
      await this.makeDBJoin();
      this.timeLineFunc();
      this.client.renewToken(this.options.token);
    },
    disableBuyOption(optionIds) {
      // disabled option purchased
      $("input[name='option[]']").each(function () {
        const value = +$(this).val();
        if (optionIds.includes(value)) {
          $(this).attr('checked', true);
          $(this).attr('disabled', true);
        }
      });
      // if (this.roomFirebase) {
      //   this.roomFirebase.addOptionPurchased(optionIds);
      // }
    },
    async addDevice() {
      try {
        this.localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        // this.localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack({encoderConfig: this.options.cameraVideoProfile});
      } catch (err) {
        this.handleFail(err);
      }
    },
    getTime(time) {
      return new Date(time).getTime();
    },
    async playLiveStream() {
      // if (this.isHandleEndCall) {
      //   this.isHandleEndCall = false;
      //   await this.turnOffDevices(false);
      // }

      await this.joinRoom();
      this.connectRoom = true;

      // success join room
      this.$emit('joinedRoom');
    },
    checkDevice() {
      if (this.type === 'live') return true;
      return !!(this.localTracks.videoTrack && this.localTracks.audioTrack);
    },
    async loadOldGift() {
      const res = await this.getListOldGift();
      if (res.status !== 200) {
        return;
      }
      if (res && res.data.success) {
        this.normalGift = res.data.data;
      }
    },
    getListOldGift() {
      return axios.get('/gift/list-old', { params: { csId: this.courseSchedule.course_schedule_id } });
    },
    async joinRoom() {
      try {
        await this.makeDBJoin();

        // check join late or error server
        if (!this.options.token || this.courseSchedule['isCancel']) {
          location.reload();
          this.$destroy();
          return;
        }

        this.initializedAgoraListeners();
        this.connectRoomFb();
        this.connectRoomNode();
        // set client to host
        if (this.type === 'live') {
          this.client.setClientRole(this.options.role);
        }

        // join the channel
        this.options.uid = await this.client.join(
            this.options.appid,
            this.options.channel,
            this.options.token,
            this.options.uid
        );

        if (this.type === 'rtc') {
          // type call
          this.publishVideo();
          await this.publishAudio();
        }

        //change size button option in video-call
        const btn = document.getElementById('vc-btn');
        const btn2 = document.getElementById('dropdownVideoCall');
        if (btn && btn2) {
          btn.classList.add('drop-btn-video-call-small');
          btn2.classList.add('dropdown-video-call-small');
        }
        this.showVideoCall = true;

      } catch (err) {
        this.handleFail(err);
      }
    },
    connectRoomFb() {
      if (!this.roomFirebase) {
        // Create an isolated space
        this.roomFirebase = new Gathering(this.$database, this.courseSchedule.course_schedule_id);

        this.roomFirebase.join('STUDENT');
      }
    },
    connectRoomNode() {
      // init socket
      this.roomSocket = new SocketClient(this.courseSchedule.course_schedule_id);
      this.roomSocket.join('AUDIENCE');

      this.roomSocket.onUpdated((obj) => {
        if (obj.type === 'COUNT_USER') {
          this.viewer = obj.data;
        }
        if (obj.type === 'SEND_GIFT') {
          this.handleUserPurchaseGiftSuccess(obj.data);
        }
      });
    },
    playSound() {
      if (this.remoteTracks.volume > 0) {
        // document.getElementById('audioNotification').play();
        this.play();
      }
    },
    handleUserPurchaseGiftSuccess(res) {
      const gift = this.gifts.find(el => el.gift_id === res.giftId);
      if (gift) {
        this.playSound();

        const banner = {
          gift: gift,
          user: res.user
        };
        this.animationSuperGiftBanner(banner);
      }
    },
    async animationGiftBanner(banner) {
      await delay(10);
      if (this.normalGift.length < 3) {
        this.normalGift.push(banner);
        setTimeout(() => {
          this.normalGift.shift();
          if (this.stashNormalGift.length) {
            this.animationGiftBanner(this.stashNormalGift[0]);
            this.stashNormalGift.shift();
          }
        }, 3000);
      } else {
        this.stashNormalGift.push(banner);
      }
    },
    async animationSuperGiftBanner(banner) {
      await delay(10);
      if (this.superGift.length < 1) {
        this.superGift.unshift(banner);
        setTimeout(() => {
          this.superGift.shift();
          if (this.stashSuperGift.length) {
            this.animationSuperGiftBanner(this.stashSuperGift[0]);
            this.stashSuperGift.shift();
          }
          this.normalGift.unshift(banner);
          setTimeout(() => {
            $('#gift-banner-list').scrollTop(0);
          }, 1);
        }, 1700);
      } else {
        this.stashSuperGift.unshift(banner);
      }
    },
    initializedAgoraListeners() {
      this.client.on("user-published", this.handleUserPublished);
      this.client.on("user-joined", this.handleUserJoined);
      this.client.on("user-left", this.handleUserLeft);
      this.client.on("user-unpublished", this.handleUserUnpublished);
      this.client.on('token-privilege-did-expire', this.handleExpire);
      this.client.on('connection-state-change', this.handleStateChange);
    },
    handleStateChange(curState, revStatus) {
      if (curState === 'CONNECTED' && this.type === 'rtc') {
        // this.state.studentPublished = true;
        this.connectRoom = true;
        if (this.type === 'rtc') {
          this.minimize.deepAr = true;
        }
      }
    },
    handleUserJoined(user) {
      if (user.uid === this.courseSchedule['course']['user_id']) {
        this.minimize.deepAr = true;
        this.state.teacherJoined = true;
      }
    },
    handleUserLeft(user, reason) {
      if (this.remoteTracks.uid === user.uid) {
        this.handleEndCall();
      }
    },
    isMobile() {
      return window.innerWidth < 767;
    },
    async handleUserPublished(user, mediaType) {
      if (!this.courseSchedule['tokenOk']) {
        await this.makeDBJoin();
      }

      // check join late or error server
      if (!this.options.token || this.courseSchedule['isCancel']) {
        location.reload();
        this.$destroy();
        return;
      }
      this.timeLineFunc();
      this.client.renewToken(this.options.token);

      this.remote.connectionState = 'TEACHER-JOINED';
      // this.teacherNotPublish = true;
      if (this.type === 'rtc') {
        $('.option-livestream-button-mobile').css('pointer-events', 'none');
      } else {
        await this.loadOldGift();
      }
      this.updateStyleJoinRoom();

      this.$emit('userPublished');

      await this.subscribe(user, mediaType);
    },
    updateStyleJoinRoom() {
      $('.header__left__search').hide();
      $('.header-right').hide();
      $('.layout__hidden').hide();
      $('.header__bar').hide();
      $('.header-info').addClass('header-info-live');
      $('.avt').addClass('avt-live');
      $('.header__left').addClass('left-full');
      $('.livestream-social').show();
      $('.join-course-block__header__time-live').hide();
      $('.tools-option').show();
      $('.join-course-block__body').css('margin-bottom', '102px');
      $('#footer').addClass('footer-mobile-livestream');
      // if type is videocall is scale 0.25 and move to conner
      if (this.type === 'rtc') {
        this.changeFaceMark = false;
        this.local.showFaceMark = false;
        $('.join-course-block__body__left').removeClass('bg-livestream-left');
        $('.join-course-block__body__left').removeClass('bg-livestream-right');
        $('.join-course-block__body__left').addClass('bg-video-call-left');
      }
      this.setSizeBlockVideoLocal();
    },
    handleUserUnpublished(user) {
      const id = user.uid;
      $(`#player-wrapper-${id}`).remove();
      this.remote.connectionState = 'TEACHER-LEAVE';
    },
    async subscribe(user, mediaType) {
      // subscribe to a remote user
      await this.client.subscribe(user, mediaType);
      if (mediaType === 'video') {
        this.remoteTracks.videoTrack = user.videoTrack;
        this.remoteTracks.videoTrack.play("remote-video", this.options.videoConfig);
        // this.localTracks.videoTrackEnabled = true;
      }
      if (mediaType === 'audio') {
        this.remoteTracks.audioTrack = user.audioTrack;
        this.changeVolume(this.remoteTracks.volume);
        this.remoteTracks.audioTrack.play();
      }
    },
    setSizeBlockVideoLocal() {
      if (this.type === 'live') {
        return this.resizeLive();
      }
      return this.resizeRtc();
    },
    resizeLive() {
      let width, height, giftHeight, livePosition, heightItemGift;
      if (this.localTracks.fullscreen) {
        width = window.innerWidth;
      } else {
        width = document.getElementById('join-course-block__body__left').offsetWidth;
      }
      height = width * 49 / 87;
      if (height > window.innerHeight) {
        height = window.innerHeight;
        width = height * 87 / 49;
      }

      // style main video
      if (this.localTracks.fullscreen) {
        this.style.frameMainVideo = {
          width: `${width}px`,
          height: `${height}px`,
          position: 'fixed',
          top: '50%',
          left: '50%',
          zIndex: 101,
          transform: 'translate(-50%, -50%)',
        };
      } else {
        this.style.frameMainVideo = {
          width: `${width}px`,
          height: `${height}px`,
        };
      }
      document.getElementById('join-course-block__body__left').style.height = `${height}px`;

      // style gift
      livePosition = (window.innerWidth > 767) ? 38 : 25;
      heightItemGift = (window.innerWidth > 767) ? 49 : 31;
      // giftHeight = ((height + livePosition) < window.innerHeight && this.localTracks.fullscreen) ? height : (height - livePosition);
      if ((height + livePosition) < window.innerHeight && this.localTracks.fullscreen) {
        giftHeight = height;
        livePosition = 0;
      } else {
        giftHeight = height - livePosition - 37;
      }
      giftHeight = Math.floor((giftHeight) / heightItemGift) * heightItemGift;

      this.style.giftBanner = {
        top: `${livePosition}px`,
        height: `${giftHeight}px`,
      };
    },
    resizeRtc() {
      let width, height, scale, canvasWidth, canvasHeight;
      if (this.localTracks.fullscreen) {
        width = window.innerWidth;
      } else {
        width = document.getElementById('join-course-block__body__left').offsetWidth;
      }
      height = width * 49 / 87;
      if (height > window.innerHeight) {
        height = window.innerHeight;
        width = height * 87 / 49;
      }

      // style main video
      if (this.localTracks.fullscreen) {
        this.style.frameMainVideo = {
          width: `${width}px`,
          height: `${height}px`,
          position: 'fixed',
          top: '50%',
          left: '50%',
          zIndex: 101,
          transform: 'translate(-50%, -50%)',
        };
      } else {
        this.style.frameMainVideo = {
          width: `${width}px`,
          height: `${height}px`,
        };
      }
      document.getElementById('join-course-block__body__left').style.height = `${height}px`;

      // minimize local-video
      if (this.minimize.deepAr) {
        this.style.localVideo = {
          width: `${width / 4}px`,
          height: `${height / 4}px`,
          zIndex: 99,
          position: 'absolute',
          top: '10px',
          left: '5px',
          display: 'flex',
          alignItems: 'unset',
        };
        this.deepAr.element.style.transform = `scale(1)`;
        this.deepAr.element.style.width = '100%';
      } else {
        // style deepar
        if (this.deepAr.init) {
          canvasWidth = width;
          canvasWidth = width < 870 ? 870 : canvasWidth;
          scale = width > 870 ? 1 : width / 870;
          canvasHeight = canvasWidth * 49 / 87;

          this.deepAr.init.setCanvasSize(canvasWidth, canvasHeight);
          this.deepAr.element.style.transform = `scale(${scale})`;
          this.deepAr.element.style.width = 'auto';
        }
      }

      if (this.localTracks.screenTrack && this.minimize.screen) {
        this.style.screenVideo = {
          width: `${width / 4}px`,
          height: `${height / 4}px`,
          zIndex: 100,
          position: 'absolute',
          top: `${this.localTracks.videoTrackEnabled ? (height / 4) + 20 : 10}px`,
          left: '5px',
          display: 'flex',
          alignItems: 'unset',
        };
      }
    },
    initDeepAr() {
      this.deepAr.element = document.getElementById('canvas-video');

      this.deepAr.init = DeepAR({
        canvasWidth: 870,
        canvasHeight: 490,
        libPath: '/deepar/lib',
        segmentationInfoZip: 'segmentation.zip',
        licenseKey: process.env.MIX_DEEPAR_LICENSE_KEY,
        canvas: this.deepAr.element,
        numberOfFaces: 1,
        onInitialize: () => {
          this.deepAr.init.startVideo(true);
        },
        onCameraPermissionGranted: () => {
          if (!this.localTracks.grantedCamera) {
            this.customVideoAgora();
            this.initFacemark();
          }
          this.localTracks.grantedCamera = true;
        }
      });

      this.deepAr.init.downloadFaceTrackingModel('/deepar/lib/models-68-extreme.bin');
    },
    initFacemark() {
      this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/background_segmentation', () => {
      });
    },
    createCameraStream() {
      this.createLocalVideoElement(this.localTracks.videoTrack);
    },
    generateToken(channelName) {
      return axios.post("/agora/token", {
        channelName,
        exp: this.courseSchedule.end_datetime_string,
        csId: this.courseSchedule.course_schedule_id,
        now: new Date()
      });
    },
    handleFail(err) {
      // window.alert("Shit is failing : " + err);
      console.log(err);
    },
    createLocalVideoElement(video) {
      if (video) {
        this.playerContainer = document.createElement('div');
        this.playerContainer.style.width = '100%';
        this.playerContainer.style.height = '100%';
        document.getElementById('local-video').append(this.playerContainer);
        video.play(this.playerContainer, this.options.videoConfig);
      }
    },
    async handleScreenToggle() {
      if (this.type === 'rtc') {
        this.minimize.screen = true;
      }
      this.localTracks.tempScreenTrack = await AgoraRTC.createScreenVideoTrack({
        encoderConfig: this.options.cameraVideoProfile,
      });
      // clear screen-video
      await this.clearScreenVideo();
      this.createScreenVideoElement(this.localTracks.screenTrack);
      // this.minimize.deepAr = true;
      this.setSizeBlockVideoLocal();
      this.publishVideo();

      this.localTracks.screenTrack.on('track-ended', async () => {
        await this.stopShareScreen();
      });
    },
    hardUnPublish() {
      try {
        this.client.unpublish(this.localTracks.screenTrack);
        this.localTracks.screenTrack.close();
      } catch {
      }
      try {
        this.client.unpublish(this.localTracks.videoTrack);
      } catch {
      }
    },
    createScreenVideoElement(video) {
      if (video) {
        video.play('screen-video', this.options.videoConfig);
        this.style.screenVideo = {
          display: 'block'
        };
        this.style.localVideo = {};
      }
    },
    clearScreenVideo() {
      document.getElementById('screen-video').innerHTML = '';

      this.client.localTracks.forEach(element => {
        if (element.trackMediaType === 'video') {
          const trackIdPlaying = element._ID;
          let trackIdScreen = null;
          let trackIdVideo = null;
          if (this.localTracks.screenTrack) {
            trackIdScreen = this.localTracks.screenTrack._ID;
          }
          if (this.localTracks.videoTrack) {
            trackIdVideo = this.localTracks.videoTrack._ID;
          }
          if (trackIdPlaying === trackIdScreen) {
            this.client.unpublish(this.localTracks.screenTrack);
            this.localTracks.screenTrack.close();
          } else if (trackIdPlaying === trackIdVideo) {
            this.client.unpublish(this.localTracks.videoTrack);
          } else {
            this.hardUnPublish();
          }
        }
      });

      this.localTracks.screenTrack = this.localTracks.tempScreenTrack;
      this.localTracks.tempScreenTrack = null;
    },
    async stopShareScreen(publish = true) {
      this.style.screenVideo = {};
      this.clearScreenVideo();
      this.setSizeBlockVideoLocal();
      this.state.teacherPublished = false;
      if (publish && this.localTracks.videoTrackEnabled) {
        this.publishVideo();
      }
    },
    publishVideo() {
      // if (!this.state.studentPublished) return;
      try {
        if (this.localTracks.screenTrack) {
          this.client.publish(this.localTracks.screenTrack);
        } else if (this.localTracks.videoTrackEnabled) {
          this.client.publish(this.localTracks.videoTrack);
        }
      } catch (err) {}
    },
    async publishAudio() {
      if (this.localTracks.audioTrackEnabled) {
        await this.localTracks.audioTrack.setEnabled(true);
      }
      this.client.publish(this.localTracks.audioTrack);
      if (!this.localTracks.audioTrackEnabled) {
        this.localTracks.audioTrack.setEnabled(false);
      }
    },
    async makeDBJoin() {
      const tokenRes = await this.generateToken(this.options.channel);
      if (tokenRes.status !== 200) {
        return;
      }
      this.options.token = tokenRes.data.token;
      this.courseSchedule['isCancel'] = tokenRes.data.isCancel;
      this.courseSchedule['diffTime'] = tokenRes.data.diffTime;
      this.courseSchedule['tokenOk'] = tokenRes.data.tokenOk;
      this.courseSchedule['actual_start_date'] = tokenRes.data.actualStartDate;
      this.courseSchedule['actual_end_date'] = tokenRes.data.actualEndDate;
    },
    async handleVideoToggle() {
      if (this.localTracks.videoTrackEnabled) {
        await this.muteVideo();
      } else {
        await this.unmuteVideo();
      }
      this.setSizeBlockVideoLocal();
    },
    handleAudioToggle() {
      if (this.localTracks.audioTrackEnabled) {
        this.muteAudio();
      } else {
        this.unmuteAudio();
      }
    },
    handleScreenChangeBackground(action) {
      this.showOptionDropDown = false;
      this.changeFaceMark = false;
      if (action === 'OPEN') {
        this.$emit('openScreenChangeBackground', action);
        this.local.eventHappening = 'CHANGE-BACKGROUND';
        this.handleClickDropdown();
      } else {
        this.local.eventHappening = null;
      }
    },
    handleExpire() {
      clearInterval(this.timeline.function);
      this.handleEndCall();
      console.log('-----------EXPIRE TOKEN----------');
    },
    async handleEndCall() {
      if (this.localTracks.fullscreen) {
        $('.tooltip.show').remove();
        this.handleFullscreen();
      }
      if (this.type === 'rtc') {
        this.clearScreenVideo();
        this.isHandleEndCall = true;
        await this.stopShareScreen(false);
        await this.turnOffDevices(true);
        this.localTracks.videoTrackEnabled = false;
      }
      await this.client.leave();
      this.handleUserLeave();
    },
    async turnOffDevices(isTurnOff = true) {
      if (isTurnOff) {
        // if (this.localTracks.audioTrack) {
        //   await this.localTracks.audioTrack.setEnabled(false);
        // }
        this.deepAr.init.stopVideo();
      } else {
        if (this.localTracks.audioTrack) {
          await this.localTracks.audioTrack.setEnabled(true);
        }
        this.localTracks.videoTrackEnabled = true;
        this.deepAr.init.startVideo(true);
      }
    },
    handleFullscreen() {
      this.localTracks.fullscreen = !this.localTracks.fullscreen;
      this.setSizeBlockVideoLocal();
    },
    handleUserLeave(fixed = false) {
      this.$emit('leaveRoom');
      this.connectRoom = false;
      this.state.teacherJoined = false;
      $('.join-course-block__header__time-live').show();
      $('.tools-option').hide();
      if (this.roomFirebase) {
        this.roomFirebase.leave();
        this.roomFirebase = null;
      }
      if (this.roomSocket) {
        this.roomSocket.leave();
        this.roomSocket = null;
      }
      this.style.localVideo = {};
      if (!fixed) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "POST",
          url: '/student/join-course/pay-extent-end/' + this.courseSchedule.course_schedule_id,
        })
            .done(async (res) => {
              if (res.allSubCourse > 0) {
                $('#sub-course_end').html(res.html);
                $('#subCourseFree').modal('show');
              } else {
                window.location.href = '/student/course/review/' + this.courseSchedule.course_schedule_id;
              }
            })
            .catch(function (error) {
              console.log(error)
            });
        // if (this.all_sub_course != 0)
        //   $('#subCourseFree').modal({backdrop: 'static', keyboard: false});
        // else
        //   window.location.href = '/student/course/review/' + this.courseSchedule.course_schedule_id;
      }
    },
    showOptionDropDownVideoCall() {
      document.getElementById("dropdownVideoCall").classList.toggle("show");
      // Close the dropdown if the user clicks outside of it
      window.onclick = function (event) {
        if (!event.target.matches('.drop-btn-video-call')) {
          let dropdowns = document.getElementsByClassName("dropdown-video-call");
          let i;
          for (i = 0; i < dropdowns.length; i++) {
            let openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
            }
          }
        }
      }
    },
    handleVolume() {
      if (this.remoteTracks.volume) {
        this.remoteTracks.volume = 0;
      } else {
        this.remoteTracks.volume = 100;
      }
    },
    changeVolume(level) {
      if (!this.remoteTracks.audioTrack) return;
      this.remoteTracks.audioTrack.setVolume(level);
    },
    async muteAudio() {
      if (!this.localTracks.audioTrack) return;
      await this.localTracks.audioTrack.setMuted(true);
      this.localTracks.audioTrackEnabled = false;
    },
    async muteVideo() {
      if (!this.localTracks.videoTrack) {
        this.deepAr.init.stopVideo();

        return;
      }
      if (this.localTracks.videoTrack) {
        await this.localTracks.videoTrack.setEnabled(false);
      }
      // if (this.localTracks.screenTrack) {
      //   await this.localTracks.screenTrack.setEnabled(false);
      // }
      this.localTracks.videoTrackEnabled = false;
    },
    async unmuteAudio() {
      if (!this.localTracks.audioTrack) return;
      await this.localTracks.audioTrack.setMuted(false);
      this.localTracks.audioTrackEnabled = true;
    },
    async unmuteVideo() {
      if (!this.localTracks.videoTrack) {
        this.deepAr.init.startVideo(true);

        return;
      }
      if (this.localTracks.videoTrack) {
        await this.localTracks.videoTrack.setEnabled(true);
      }
      // if (this.localTracks.screenTrack) {
      //   await this.localTracks.screenTrack.setEnabled(true);
      // }
      this.localTracks.videoTrackEnabled = true;
      this.publishVideo();
    },
    handleClickDropdown() {
      this.changeFaceMark = false;
      const target = $('.dropdown2');
      if (target.hasClass('show')) {
        target.removeClass('show');
      } else {
        target.addClass('show');
      }
    },
    handleShowOptionLivestream(status) {
      // this.changeFaceMark = false;
      if (status && !this.changeFaceMark) {
        this.showOptionDropDown = true
      } else {
        this.showOptionDropDown = false;
        this.changeFaceMark = false;
      }
    },
    changeBackground(url) {
      this.deepAr.effect = 'BACKGROUND';
      this.deepAr.tempBackground = url;
      this.switchEffectDeepAr(url, 'BACKGROUND');
    },
    setFaceMark(faceMode) {
      this.deepAr.effect = 'FACE-MARK';
      this.$emit('studentChangeFaceMark', true);
      this.deepAr.tempFaceMark = faceMode;
      this.switchEffectDeepAr(faceMode, 'FACE-MARK');
    },
    switchEffectDeepAr(effect, mode) {
      if (!effect) {
        if (this.deepAr.tempBackground) {
          this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/background_segmentation', () => {
            this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', this.deepAr.tempBackground);
          });
        } else if (this.deepAr.tempFaceMark) {
          this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', '/assets/img/common/background/trans.png');
        } else {
          // this.localTracks.videoTrack = AgoraRTC.createCameraVideoTrack({encoderConfig: this.options.cameraVideoProfile});
          this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/background_segmentation', () => {
          });
        }
      } else {
        if (mode === 'FACE-MARK') {
          this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/' + effect, () => {
            this.deepAr.run = true;
            if (this.deepAr.tempBackground) {
              this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', this.deepAr.tempBackground);
            }
          });
        }
        if (mode === 'BACKGROUND') {
          if (this.deepAr.tempFaceMark) {
            this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', effect);
          } else {
            this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/background_segmentation', () => {
              this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', effect);
            });
          }
        }

        this.setSizeBlockVideoLocal();
      }
    },
    async customVideoAgora() {
      if (this.type === 'live') return;
      // custom video agora canvas
      const canvas = document.getElementById('canvas-video');
      if (canvas) {
        const isIOS = /iPad|iPhone|iPod/.test(navigator.platform);
        const fps = isIOS ? 5 : 25;
        const track = canvas.captureStream(fps).getVideoTracks() ?? null;
        if (track && track[0]) {
          this.localTracks.videoTrack = await AgoraRTC.createCustomVideoTrack({
            mediaStreamTrack: track[0],
            optimizationMode: 'motion'
          });
        }
      }
    },
    studentPurchaseGiftSuccess(giftId) {
      if (this.roomSocket) {
        const user = {
          fullName: this.auth_user['full_name'],
          profile: this.auth_user['profile_thumbnail']
        };

        this.roomSocket.addGift(giftId, user);
      }
    }
  }
};
</script>
