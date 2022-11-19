<!--<script src="../dayjs.js"></script>-->
<template>
  <div class="join-course-block__body__left__video"
       @click="!isMobile() ? null : (showButton = !showButton)"
       @mouseover="isMobile() ? null : (showButton = true)"
       @mouseleave="isMobile() ? null : (showButton = false)"
       v-bind:class="{'fullscreen': localTracks.fullscreen}"
       :style="style.blockVideo">
    <div class="backdrop" v-bind:class="{'fullscreen': localTracks.fullscreen}"></div>
    <img
        id="video-img-background"
        class="join-course-block__body__left__video__temp"
        :src="courseSchedule['image']"
        alt="">

    <div id="block-video" class="join-course-block__body__left__video__block">
      <div :style="style.frameMainVideo">
        <!--gift-->
        <div v-if="type === 'live' && connectRoom" class="livestream__gift-banner"
             v-bind:class="{'fullscreen': localTracks.fullscreen}" id="gift-banner-list" :style="style.giftBanner">
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

        <!--Super gift-->
        <div v-if="type === 'live' && connectRoom" id="gift-banner-super" class="livestream__gift-banner__super"
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

        <!--deepar video-->
        <div id="local-video" class="join-course-block__body__left__video__local-video" :style="style.localVideo"
             :hidden="!localTracks.videoTrackEnabled">
          <span class="description">
            プレゼンテーション（あなた）
          </span>
          <canvas id="canvas-video" :hidden="!localTracks.grantedCamera || !localTracks.videoTrackEnabled"></canvas>
        </div>

        <div v-if="connectRoom && type === 'rtc'" id="remote-video"
             class="join-course-block__body__left__video__remote-video">
        </div>
      </div>
    </div>

    <div v-if="localTracks.grantedCamera && local.eventHappening !== 'CHANGE-BACKGROUND' && showButton"
         :style="style.localControl" class="join-course-block__body__left__video__control d-flex flex-row"
         v-bind:class="{'fullscreen': localTracks.fullscreen}">
      <div class="mr-auto pr-2 btn-control-custom" @click.stop="">
        <button class="btn btn-speaker" data-original-title="音量" v-tooltip="true" @click.prevent.stop="handleVolume">
          <img v-if="type === 'rtc'" :src="'/assets/img/icons/' + (remoteTracks.volume ? '' : 'off-') + 'speaker.svg'"
               alt="speaker">
        </button>
        <vue-slider v-if="type === 'rtc'" v-model="remoteTracks.volume" v-bind="optionsSlider"></vue-slider>
      </div>
      <div class="btn-control-custom share-screen">
        <button class="btn btn-control-custom" @click.prevent.stop="handleScreenToggle" v-tooltip="true"
                data-original-title="画面共有">
          <img :src="'/assets/img/icons/share.svg'" alt="share">
        </button>
      </div>
      <div class="btn-control-custom" v-show="!changeFaceMark">
        <button class="btn btn-control-custom" @click.prevent.stop="handleVideoToggle" v-tooltip="true"
                data-original-title="カメラ">
          <img :src="'/assets/img/icons/' + (!localTracks.videoTrackEnabled ? 'off-' : '') + 'cam.svg'" alt="cam">
        </button>
      </div>
      <div class="btn-control-custom" v-show="!changeFaceMark">
        <button class="btn btn-control-custom" @click.prevent.stop="handleAudioToggle" v-tooltip="true"
                data-original-title="マイク">
          <img :src="'/assets/img/icons/' + (!localTracks.audioTrackEnabled ? 'off-' : '') + 'mic.svg'" alt="mic">
        </button>
      </div>
      <div class="btn-control-custom" v-if="connectRoom">
        <button class="btn btn-control-custom" @click.prevent.stop="handleEndCall" v-tooltip="true"
                data-original-title="終了">
          <img :src="'/assets/img/icons/call.svg'" alt="End Call">
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
        <img
            id="vc-btn" v-if="!connectRoom" :src="'/assets/img/icons/svg.svg'" alt="svg"
            class="btn btn-custom drop-btn-video-call drop-btn-video-call-small"
            @click.prevent.stop="$refs.dropdown2.click()"
        >
        <div v-if="!connectRoom" @click.prevent.stop="handleClickDropdown" ref="dropdown2"
             class="dropdown-video-call-small">
          <div class="triangle-up"></div>
          <a @click.prevent.stop="handleScreenChangeBackground('OPEN')">背景変更</a>
        </div>
      </div>
      <div class="ml-auto pl-2 btn-control-custom option-livestream-button-mobile"
           @click.prevent.stop="handleShowOptionLivestream(true)">
        <img v-if="!connectRoom" src="/assets/img/icons/svg.svg" alt="svg"
             class="btn btn-custom drop-btn-video-call drop-btn-video-call-small">
      </div>
    </div>

    <face-mark v-if="changeFaceMark" v-on:setFaceMark="setFaceMark"></face-mark>

    <div v-if="connectRoom && type === 'live'" class="join-course-block__body__left__video__viewers"
         :style="style.localCounter" v-bind:class="{'fullscreen': localTracks.fullscreen}">
      <div class="livestream-icon f-w6"><img :src="'/assets/img/icons/record.svg'" alt="time">Live</div>
      <div class="viewer-icon f-w6"><img :src="'/assets/img/icons/eye-livestream.svg'" alt="time">{{ viewer }}人</div>
    </div>
    <div v-if="connectRoom" class="join-course-block__body__left__video__timeline"
         v-bind:class="{'fullscreen': localTracks.fullscreen}">
      {{ timeline.text }}
    </div>

    <div class="livestream__extend-banner" id="extend-banner-list">
      <div v-for="item in listExtend" class="banner__item__wrapper" id="hide__banner-item">
        <div class="banner__item">
          <span class="banner__item__close">
            <img :src="'/assets/img/icons/close-2.svg'" alt="" @click.prevent.stop="removeBannerExtend(item.id)">
          </span>

          <span class="banner__item__avatar">
              <img :src="item.user.profile" alt="">
          </span>

          <div class="banner__item__info">
            <div class="item-info__name">{{ item.user.fullName }}</div>
            <div class="item-info__detail">{{ item.message }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="option-livestream-mobile-outline" v-if="showOptionDropDown"></div>
    <div class="option-livestream-mobile" v-if="showOptionDropDown">
      <div class="option-livestream-mobile__button-close" @click.prevent.stop="handleShowOptionLivestream(false)">
        <img src="/assets/img/icons/close-option.svg" alt="">
      </div>
      <div class="option-livestream-mobile__content">
        <a @click.prevent.stop="handleScreenChangeBackground('OPEN')">背景変更</a>
      </div>
    </div>
  </div>
</template>

<script>
import AgoraRTC from "agora-rtc-sdk-ng";
import Gathering from "../../clients/commons/gathering";
import delay from "delay";
import { useSound } from '@vueuse/sound';
import SocketClient from "../../clients/commons/socket";

export default {
  name: "TeacherVideoLiveStream",
  props: ['agora_id', 'auth_user', 'courseSchedule', 'all_sub_course', 'gifts', 'option_extra'],
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
      type: !this.courseSchedule['course']['parent_course_id'] && this.courseSchedule['course']['category']['type'] === 1 ? 'live' : 'rtc',
      client: null,
      localTracks: {
        grantedCamera: false,
        // modeTrack: '',
        videoTrack: null,
        screenTrack: null,
        tempTrack: null,
        tempScreenTrack: null,
        audioTrack: null,
        fullscreen: false,
        videoTrackEnabled: true,
        audioTrackEnabled: true,
        localVideoElementId: null,
      },
      minimize: {
        deepAr: false,
        screen: false,
      },
      listExtend: [],
      normalGift: [],
      superGift: [],
      stashNormalGift: [],
      stashSuperGift: [],
      remoteTracks: {
        videoTrack: null,
        audioTrack: null,
        volume: 100
      },
      options: {
        appid: null,
        channel: null,
        uid: null,
        token: null,
        role: null, // host or audience
        cameraVideoProfile: null,
        videoConfig: null
      },
      playerContainer: null,
      connectRoom: false,
      deepAr: {
        init: null,
        // effect: null,
        run: false,
        element: null,
        effectAnimation: null,
        bgUrl: null
      },
      viewer: 0,
      timeline: {
        text: '',
        function: null,
      },
      roomFirebase: null,
      roomSocket: null,
      changeFaceMark: false,
      local: {
        eventHappening: null,
        // reconnecting: false
      },
      remote: null,
      style: {
        blockVideo: {},
        screenVideo: {},
        localVideo: {},
        localControl: {},
        localCounter: {},
        // tempVideo: {},
        frameMainVideo: {},
        giftBanner: {}
      },
      count: 0,
      optionsSlider: {
        dotSize: 12,
        width: 66,
        processStyle: {backgroundColor: 'rgba(255, 255, 255, 0.5)'},
        railStyle: {backgroundColor: 'rgba(255, 255, 255, 0.2)'},
      },
      isHandleEndCall: false,
      markRequired: null,
      maskStatus: null,
      // showButton: !this.courseSchedule['course']['parent_course_id'] && this.courseSchedule['course']['category']['type'] === 1 ? false : true,
      showButton: true,
      endCourseStatus: false,
      scaleFull: null,
      showVideoTemp: true,
      state: {
        teacherPublished: false
      },
    };
  },
  async mounted() {
    await this.defaultValue();
    this.initDeepAr();
    this.setSizeBlockVideoLocal();
  },
  created() {
    const that = this;
    document.addEventListener("scroll", function () {
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
    mouseOver: function () {
      this.active = !this.active;
    },
    handleShowOptionLivestream(status) {
      status === true ? this.showOptionDropDown = true : this.showOptionDropDown = false;
    },
    async defaultValue() {
      this.options.videoConfig = {
        mirror: false,
        fit: 'contain'
      };

      this.options.cameraVideoProfile = {width: 870, height: 490};
      // this.options.cameraVideoProfile = '1080p_2';
      this.localTracks.localVideoElementId = 'local-video';
      this.client = AgoraRTC.createClient({mode: this.type, codec: "vp8"});
      // set option config channel agora
      this.options.appid = this.agora_id;
      this.options.channel = this.courseSchedule.agora_channel;
      // const tokenRes = await this.generateToken(this.options.channel);
      // this.options.token = tokenRes.data;
      this.options.role = 'host';
      this.options.uid = this.auth_user.user_id;

      await this.addDevice();

    },
    timeLineFunc(notClear = false) {
      if (notClear && this.timeline.function) {
        return;
      }
      clearInterval(this.timeline.function);
      let endTime = this.getTime(this.courseSchedule['actual_end_date'] ?? this.courseSchedule['end_datetime_string']);
      const diffTime = this.courseSchedule['diffTime'] ?? 0;
      console.log(diffTime);

      this.timeline.function = setInterval(() => {
        const now = this.getTime(new Date());
        const time = endTime - (now - diffTime);

        const {min, sec} = this.getHMOfTime(time);
        if (+time < 0) {
          clearInterval(this.timeline.function);
          this.timeline.text = '00分 00秒';
          this.endCourseStatus = true;
          this.handleEndCall('expired');
          return;
        }
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
    async addDevice() {
      try {
        this.localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
      } catch (err) {
        this.handleFail(err);
      }
    },
    checkDevice() {
      // return true;
      return !!(this.localTracks.videoTrack && this.localTracks.audioTrack);
    },
    getTime(time) {
      return new Date(time).getTime();
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
    isMobile() {
      return window.innerWidth < 767;
    },
    async startLiveStream() {
      try {
        // if (this.isHandleEndCall) {
        //   this.isHandleEndCall = false;
        //   await this.turnOffDevices(false);
        // }

        await this.joinRoom();
        if (this.type === 'rtc') {
          $('.option-livestream-button-mobile').css('pointer-events', 'none');
        } else {
          await this.loadOldGift();
        }
        // success join room
        this.updateStyleJoinRoom();
      } catch (error) {
        this.handleFail(error);
      }
    },
    updateStyleJoinRoom() {
      this.$emit('teacherJoined');
      $('.header__left__search').hide();
      $('.header-right').hide();
      $('.layout__hidden').hide();
      $('.header__bar').hide();
      $('.header__left').addClass('left-full');
      $('.livestream-social').show();
      $('.header-info').addClass('header-info-live');
      $('.avt').addClass('avt-live');
      $('.join-course-block__header__time-live').hide();
      $('.tools-option').show();
      $('.join-course-block__body').css('margin-bottom', '82px');
      $('#footer').addClass('footer-mobile-livestream');
      if (this.type === 'rtc') {
        $('.join-course-block__body__left').removeClass('bg-livestream-left');
        $('.join-course-block__body__left').removeClass('bg-livestream-right');
        $('.join-course-block__body__left').addClass('bg-video-call-left');
      }
    },
    async joinRoom() {
      // connect realtime
      if (this.type === 'live') {
        this.client.setClientRole(this.options.role);
      }
      this.initializedAgoraListeners();
      await this.makeDBJoin();

      // check join late or error server
      if (!this.options.token || this.courseSchedule['isCancel']) {
        location.reload();
        this.$destroy();
        return;
      }

      this.timeLineFunc(true);
      this.connectRoomFb();
      this.connectRoomNode();

      // join the channel
      this.options.uid = await this.client.join(
          this.options.appid,
          this.options.channel,
          this.options.token,
          this.options.uid
      );

      this.publishVideo();
      this.publishAudio();
    },
    async studentPurchaseExtendSuccess(data) {
      this.courseSchedule['teacher_join_late'] = false;
      const minute = data.minute;

      if (!data.minute && !data.optionIds) return;
      let message = data.minute + '分の延長';//と～オプションを購入しました。

      if (data.optionIds) {
        message += 'と';
        this.option_extra.forEach((el, index) => {
          if (data.optionIds.includes(el['optional_extra_id'])) {
            message += (index ? '、' : '') + el.title;
          }
        });

        message += 'の';
      }
      message += 'を購入しました。';

      this.listExtend.push({
        id: this.listExtend.length + 1,
        user: data.user,
        message
      });

      await this.addTimeToAgoraToken(minute);
    },
    removeBannerExtend(id) {
      this.listExtend = this.listExtend.filter(el => el.id !== id);
    },
    async addTimeToAgoraToken() {
      await this.makeDBJoin();
      this.timeLineFunc();
      this.client.renewToken(this.options.token);
    },
    playSound() {
      if (this.remoteTracks.volume > 0) {
        this.play();
      }
    },
    studentPurchaseGiftSuccess(res) {
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
    connectRoomFb() {
      if (!this.roomFirebase) {
        // Create an isolated space
        this.roomFirebase = new Gathering(this.$database, this.courseSchedule.course_schedule_id);

        this.roomFirebase.onUpdated((count, users) => {
          // this.viewer = count;
          if (users && users['PURCHASE_OPTION-SUCCESS']) {
            this.studentPurchaseExtendSuccess(users['PURCHASE_OPTION-SUCCESS']);
          }

          // disable uncheck default option purchase issues 1307
          if (users && users['PURCHASED-OPTION'] && users['PURCHASED-OPTION'].length) {
            // disabled option
            $("input[name='option[]']").each(function () {
              const value = +$(this).val();
              if (users['PURCHASED-OPTION'].includes(value)) {
                $(this).attr('checked', true);
                $(this).attr('disabled', true);
              }
            });
          }
        });

        this.roomFirebase.join('TEACHER');
      }
    },
    connectRoomNode() {
      // init socket
      this.roomSocket = new SocketClient(this.courseSchedule.course_schedule_id);
      this.roomSocket.join('HOST');

      this.roomSocket.onUpdated((obj) => {
        if (obj.type === 'COUNT_USER') {
          this.viewer = obj.data;
        }
        if (obj.type === 'SEND_GIFT') {
          this.studentPurchaseGiftSuccess(obj.data);
        }
      });
    },
    resizeLive() {
      let width, height, scale, giftHeight, livePosition, heightItemGift, canvasWidth, canvasHeight;
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
          zIndex: 100,
          position: 'absolute',
          bottom: '10px',
          right: '5px',
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
          scale = width >= 870 ? 1 : width / 870;
          canvasHeight = canvasWidth * 49 / 87;

          this.deepAr.init.setCanvasSize(canvasWidth, canvasHeight);
          this.deepAr.element.style.transform = `scale(${scale})`;
          this.deepAr.element.style.width = 'auto';
        }
      }

      // style gift
      livePosition = (window.innerWidth > 767) ? 38 : 25;
      heightItemGift = (window.innerWidth > 767) ? 49 : 31;
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
    setSizeBlockVideoLocal() {
      if (this.type === 'live') {
        return this.resizeLive();
      }
      return this.resizeRtc();
    },
    initDeepAr() {
      this.deepAr.element = document.getElementById('canvas-video');
      this.deepAr.init = DeepAR({
        canvasWidth: 870,
        canvasHeight: 490,
        licenseKey: process.env.MIX_DEEPAR_LICENSE_KEY,
        canvas: this.deepAr.element,
        numberOfFaces: 1,
        libPath: '/deepar/lib',
        segmentationInfoZip: 'segmentation.zip',
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
    async customVideoAgora() {
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
        this.showVideoTemp = false;
      }
    },
    initFacemark() {
      this.deepAr.runBackground = !!this.deepAr.bgUrl;
      if (this.courseSchedule['is_mask_required']) {
        this.switchEffectDeepAr('frog_bg', 'mask');
        this.markRequired = true;
        this.maskStatus = true;
      } else {
        this.switchEffectDeepAr('frog_ear_bg', 'mask');
        this.markRequired = false;
      }
    },
    createCameraStream() {
      // this.localTracks.modeTrack = 'CAMERA';
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
      // window.alert("This is a mistake ===> " + err);
      console.error("This is a mistake ===> " + err);
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
    createScreenVideoElement(video) {
      if (video) {
        video.play('screen-video', this.options.videoConfig);
        this.style.screenVideo = {
          display: 'block'
        };
        this.style.localVideo = {};
      }
    },
    hardUnPublish() {
      console.log('hard un-publish');
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
    publishVideo() {
      // if (this.state.teacherPublished || !this.connectRoom) return;
      try {
        if (this.localTracks.screenTrack) {
          this.client.publish(this.localTracks.screenTrack);
        } else if (this.localTracks.videoTrackEnabled) {
          this.client.publish(this.localTracks.videoTrack);
        }
      } catch (err) {
      }
      // this.state.teacherPublished = true;
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
      this.courseSchedule['actual_start_date'] = tokenRes.data.actualStartDate;
      this.courseSchedule['actual_end_date'] = tokenRes.data.actualEndDate;
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
      this.minimize.deepAr = true;
      this.setSizeBlockVideoLocal();
      // this.state.teacherPublished = false;
      this.publishVideo();

      this.localTracks.screenTrack.on('track-ended', async () => {
        await this.stopShareScreen();
      });
    },
    async stopShareScreen(publish = true) {
      if (this.type === 'live') {
        this.style.localVideo = {};
        this.minimize.deepAr = false;
      }

      this.style.screenVideo = {};
      this.clearScreenVideo();
      this.setSizeBlockVideoLocal();
      // this.state.teacherPublished = false;
      if (publish && this.localTracks.videoTrackEnabled) {
        this.publishVideo();
      }
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
        this.$refs.dropdown2.click();
      } else {
        this.local.eventHappening = null;
      }
    },
    handleScreenFaceMark() {
      this.$refs.dropdown2.click();
      this.changeFaceMark = !this.changeFaceMark;
    },
    noMask(context) {
      if (context === 'noMask') {
        this.maskStatus = false;
        this.switchEffectDeepAr('frog_ear_bg', 'mask');
      } else {
        this.maskStatus = true;
        this.switchEffectDeepAr('frog_bg', 'mask');
      }
      this.$refs.dropdown2.click();
    },
    handleExpire() {
      clearInterval(this.timeline.function);
      this.handleEndCall();
      console.log('-----------EXPIRE TOKEN----------');
    },
    async handleEndCall(token = null) {
      if (this.localTracks.fullscreen) {
        this.handleFullscreen();
        $('.tooltip.show').remove();
      }
      this.clearScreenVideo();
      this.isHandleEndCall = true;
      await this.stopShareScreen(false);
      await this.turnOffDevices(true);
      await this.client.leave();
      this.localTracks.videoTrackEnabled = false;
      // this.state.teacherPublished = false;
      this.handleTeacherLeave(token);
    },
    async turnOffDevices(isTurnOff = true) {
      if (isTurnOff) {
        if (this.localTracks.audioTrack) {
          await this.localTracks.audioTrack.setEnabled(false);
        }
        this.deepAr.init.stopVideo();
      } else {
        // if (this.localTracks.audioTrack) {
        //   await this.localTracks.audioTrack.setEnabled(true);
        // }
        this.localTracks.videoTrackEnabled = true;
        this.deepAr.init.startVideo(true);
      }
    },
    handleFullscreen() {
      // if (!this.connectRoom) return;
      this.localTracks.fullscreen = !this.localTracks.fullscreen;
      this.setSizeBlockVideoLocal();
    },
    handleTeacherLeave(token = null) {
      this.$emit('leaveRoom', this.endCourseStatus);
      this.connectRoom = false;
      $('.join-course-block__header__time-live').show();
      $('.tools-option').hide();
      if (this.roomFirebase) this.roomFirebase.leave();
      if (this.roomSocket) this.roomSocket.leave();
      this.roomFirebase = null;

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
            } else if (token === 'expired') {
              window.location.href = window.location.origin + '/page-expired';
            }
          })
          .catch(function (error) {
            console.log(error)
          });
    },
    initializedAgoraListeners() {
      this.client.on('token-privilege-did-expire', this.handleExpire);
      this.client.on('connection-state-change', this.handleStateChange);
      if (this.type === 'rtc') {
        this.client.on("user-published", this.handleUserPublished);
        this.client.on("user-unpublished", this.handleUserUnpublished);
      }
    },
    handleStateChange(curState, revStatus) {
      if (curState === 'CONNECTED') {
        this.connectRoom = true;
        if (this.type === 'rtc') {
          this.minimize.deepAr = true;
        }
      }
    },
    handleUserPublished(user, mediaType) {
      this.$emit('userPublished');
      this.subscribe(user, mediaType);
    },
    handleUserUnpublished(user) {
      const id = user.uid;
      $(`#player-wrapper-${id}`).remove();
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
    handleVolume() {
      if (this.remoteTracks.volume) {
        this.remoteTracks.volume = 0;
      } else {
        this.remoteTracks.volume = 100;
      }
      this.changeVolume(this.remoteTracks.volume);
    },
    changeVolume(level) {
      if (!this.remoteTracks.audioTrack) return;
      this.remoteTracks.audioTrack.setVolume(level);
    },
    async muteAudio() {
      if (!this.localTracks.audioTrack) return;
      await this.localTracks.audioTrack.setEnabled(false);
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
      // await this.localTracks.screenTrack.setEnabled(false);
      // }
      this.localTracks.videoTrackEnabled = false;
    },
    async unmuteAudio() {
      if (!this.localTracks.audioTrack) return;
      await this.localTracks.audioTrack.setEnabled(true);
      this.client.publish(this.localTracks.audioTrack);
      this.localTracks.audioTrackEnabled = true;
    },
    async unmuteVideo() {
      if (this.isHandleEndCall) {
        this.isHandleEndCall = false;
        await this.turnOffDevices(false);
      }
      // if (!this.localTracks.videoTrack) {
      //   this.deepAr.init.startVideo(true);
      // }
      if (this.localTracks.videoTrack) {
        await this.localTracks.videoTrack.setEnabled(true);
      }
      this.localTracks.videoTrackEnabled = true;
      this.publishVideo();
    },
    handleClickDropdown(event) {
      const target = event.target.classList;
      if (target.contains('show')) {
        target.remove('show');
      } else {
        target.add('show');
      }
    },
    changeBackground(url) {
      this.switchEffectDeepAr(url, 'bg');
    },
    setFaceMark(faceMode) {
      this.switchEffectDeepAr(faceMode);
    },
    setCanvasSize(width, height = null) {
      if (this.deepAr.init) {
        if (height) height = width * 10 / 16;
        this.deepAr.init.setCanvasSize(width, height);
      }
    },
    switchEffectDeepAr(effect, status) {
      if (effect) {
        this.deepAr.element.style.display = 'block';
        if (status === 'mask') {
          if (this.deepAr.runBackground) {
            this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/' + effect, () => {
              this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', this.deepAr.bgUrl);
            });
          } else {
            this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/' + effect, () => {
            });
          }
          this.deepAr.effectAnimation = effect;
        } else {
          this.deepAr.runBackground = true;
          this.deepAr.init.switchEffect(0, 'slot', '/deepar/effects/' + this.deepAr.effectAnimation, () => {
            this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', effect);
          });
          this.deepAr.bgUrl = effect;
        }
      } else {
        this.deepAr.init.changeParameterTexture('Background', 'MeshRenderer', 's_texColor', '/assets/img/common/background/trans.png');
        this.deepAr.runBackground = false;
      }
    },
  }
};
</script>
