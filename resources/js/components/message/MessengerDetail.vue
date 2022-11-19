<template>
  <div>
    <div class="w-100 d-flex align-items-center teacher-title justify-content-between" v-if="type === 1">
      <div class="back back-app d-flex align-items-center" @click="redirectBack">
        <img src="/assets/img/student/my-page/icon/left.svg" alt="" width="9" height="15">
        <div>{{ backLabel }}</div>
      </div>
    </div>
    <div class="title-wrapper d-flex align-items-center" :class="{'pb-0': type === 1}">
      <div class="w-100 d-flex align-items-center" v-if="type === 2">
        <div class="title">
          メッセージ詳細
        </div>
        <div class="back d-flex align-items-center" @click="redirectBack">
          <img src="/assets/img/student/my-page/icon/left.svg" alt="" width="9" height="15">
          <div>{{ backLabel }}</div>
        </div>
      </div>
      <TeacherHeader :profileImage="profileImage" :teacher-info="teacher" v-else/>
    </div>
    <div class="detail-message-wrapper" :class="{'mt-0': type === 1}">
      <div>
        <div class="messages-content" id="messages-content" :class="{'custom-messages-content': type ===1}">
          <div v-for="(messageItem, key) in resultMessages" :key="key" class="wrapper-message">
            <div class="send-at-date first">
              <div>
                {{ key | chatTimeFilter }}
              </div>
            </div>
            <div class="d-flex" :class="{'justify-content-end': Number(mess.user.userId) === Number(user.user_id)}"
                 v-for="(mess, index) in messageItem" :key="index">
              <div class="message-box d-flex"
                   :class="{'flex-row-reverse rtl': Number(mess.user.userId) === Number(user.user_id)}">
                <div class="avatar" v-if="+mess.user.userId !== +user.user_id"
                     @click="redirectProfile(mess.user.userId, mess.userType)"
                     :style="{cursor: mess.userType === 2 ? 'pointer' : 'default'}">
                  <a :href="'/teacher/detail/' + mess.user.userId"
                     v-if="mess.userType === 2 && (index === 0 || index - 1 >= 0 && messageItem[index].user.userId !== messageItem[index - 1].user.userId)">
                    <img style="object-fit: cover" :key="index + imageKey" :src="getImage(mess.user.userId)" alt="">
                  </a>
                  <a v-else-if="index === 0 || index - 1 >= 0 && messageItem[index].user.userId !== messageItem[index - 1].user.userId">
                    <img style="object-fit: cover" :key="index + imageKey" :src="getImage(mess.user.userId)" alt="">
                  </a>
                </div>
                <div class="message" style="position: relative">
                  <div class="comma" :class="{'right': +mess.user.userId === +user.user_id}"
                       v-if="index === 0 || index - 1 >= 0 && messageItem[index].user.userId !== messageItem[index - 1].user.userId"></div>
                  <div class="item item-message"
                       :class="{'p-0': checkMessageImage(mess.message)}" @click="previewImage" v-html="mess.message">
                  </div>
                </div>
                <div class="send-at">
                  <span class="isRead f-w3"
                        v-if="mess.is_read && Number(mess.user.userId) === Number(user.user_id) && index === messageItem.length - 1">既読</span>
                  <div class=""
                       v-if="index < (messageItem.length - 1) ? (Number(messageItem[index + 1].user.userId) !== Number(mess.user.userId)) : true">
                    {{ mess.createdAt | timeSend }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box-input-wrapper">
        <div class="box-input">
          <chat-area v-if="showInput" @submit-message="saveMessage" @custom-resize="resizeMessageContainer"/>
        </div>
      </div>
    </div>
<!--    <textarea id="log-error"></textarea>-->
    <PreviewImage @hidden="showPreview = false" :show="showPreview" :image-url="previewImg"/>
  </div>
</template>

<script>

import ChatArea from "./ChatArea";
import PreviewImage from "./PreviewImage";
import dayjs from "./../dayjs";
import TeacherHeader from "./TeacherHeader";

export default {
  components: {
    ChatArea,
    PreviewImage,
    TeacherHeader
  },
  props: {
    profileImage: {
      type: String,
      default: ""
    },
    user: {
      type: Object,
      default: () => {
      }
    },
    backUrl: String,
    courseSchedule: {
      type: Object,
      default: () => {
      }
    },
    roomData: {
      type: Object,
      default: () => {
      }
    },
    type: {
      type: Number,
      default: 2
    },
    teacher: {
      type: Object,
      default: () => {
      }
    },
    backLabel: {
      type: String,
      default: 'メッセージに戻る '
    },
    isTeacherPage: {
      type: Boolean,
      default: false
    },
    studentId: {
      default: null
    },
  },
  data() {
    return {
      messages: [],
      messageFilter: [],
      previewImg: "",
      showPreview: false,
      listImageUrl: {},
      imageKey: 0,
      commaTempId: null,
      roomId: null,
      roomType: null
    }
  },
  computed: {
    showInput() {
      const teacherStop = (+this.teacher['users']['user_status'] ?? 0) === 1;
      if (+this.roomType === 4 || teacherStop) {
        return false
      }
      return !this.isClosedCourseTimeOut;
    },
    resultMessages() {
      let self = this;
      let messages = this.messages.sort(function (a, b) {
        if (a.createdAt.toDate().getTime() > b.createdAt.toDate().getTime()) return 1;
        if (a.createdAt.toDate().getTime() < b.createdAt.toDate().getTime()) return -1;
        return 0;
      });
      if (messages.length > 0) {
        messages = self.groupArray(messages, 'created_at');
      }
      return messages;
    },
    isClosedCourseTimeOut() {
      if (!this.courseSchedule && this.teacher && +this.teacher['user_status'] === 1) return true;
      if (!this.courseSchedule || !this.courseSchedule['enddatetime_string']) return false;
      const time = this.courseSchedule['enddatetime_string'];

      return (new Date().getTime() - new Date(time).getTime()) / 1000 / 60 / 60 >= 48;
    }
  },
  created() {
    this.roomId = this.roomData.roomId;
    this.roomType = this.roomData.type;

    this.fetchMessages();
  },
  methods: {
    checkMessageImage(message) {
      return message.startsWith('<figure class="image">');
    },
    redirectProfile(userId, userType) {
      if (userType === 2) {
        window.location.replace(`/teacher/detail/${userId}`);
      }
    },
    getImage(userId) {
      return this.listImageUrl[userId];
    },
    getImageUrl(url, userId) {
      if (this.listImageUrl[userId]) return;
      this.listImageUrl[userId] = '/assets/img/clients/header-common/not-login.svg';
      this.imageKey++;

      if (url) {
        let ref = this.$storage.ref(url);
        ref.getDownloadURL().then((url) => {
          this.listImageUrl[userId] = url;
          this.imageKey++;
        });
      }
    },
    previewImage(e) {
      if (String(e.target.tagName).toLowerCase() === 'img') {
        this.previewImg = e.target.src;
        this.showPreview = true;
      }
    },
    redirectBack() {
      if (this.backUrl) {
        window.location.href = this.backUrl;
      }
    },
    groupArray(array, key) {
      // Return the end result
      return array.reduce((result, currentValue) => {
        // If an array already present for key, push it to the array. Else create an array and push the object
        (result[currentValue[key]] = result[currentValue[key]] || []).push(
            currentValue
        );
        // Return the current iteration `result` value, this will be taken as next iteration `result` value and accumulate
        return result;
      }, {}); // empty object is the initial value for result object
    },
    formatTime(time) {
      if (!time) return "";
      return `${time.getFullYear()}-${time.getMonth() + 1}-${time.getDate()}`;
    },
    linkify(inputText) {
      let replacedText, replacePattern1, replacePattern2, replacePattern3, replacePattern4;

      //URLs starting with http://, https://, or ftp://
      replacePattern1 = /(\b(>https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
      replacedText = inputText.replace(replacePattern1, '<a href="$1" target="_blank">$1</a>');
      replacedText = replacedText.replaceAll("<p<a href", "<p><a href");
      replacedText = replacedText.replaceAll("<br<a href", "<br><a href");
      replacedText = replacedText.replaceAll('_blank">>', '_blank">');
      replacedText = replacedText.replaceAll('href=">http', 'href="http');

      //URLs starting with "www." (without // before it, or it'd re-link the ones done above).
      replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
      replacedText = replacedText.replace(replacePattern2, '$1<a href="http://$2" target="_blank">$2</a>');

      //Change email addresses to mailto:: links.
      replacePattern3 = /(([a-zA-Z0-9\-\_\.])+@[a-zA-Z\_]+?(\.[a-zA-Z]{2,6})+)/gim;
      replacedText = replacedText.replace(replacePattern3, '<a href="mailto:$1">$1</a>');

      return replacedText;
    },

    saveMessage(message) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      let url = null;
      let data = null;
      url = '/messages/send';
      if (this.isTeacherPage) {
        data = {
          message: this.linkify(message),
          studentId: this.studentId,
          courseScheduleId: this.courseSchedule ? this.courseSchedule.course_schedule_id : null,
          roomType: this.roomType
        }
      } else {
        data = {
          message: this.linkify(message),
          roomId: this.roomId,
          teacherEmail: this.teacher ? this.teacher.users.email : null,
          teacherFullName: this.teacher ? this.teacher.users.full_name : null,
          studentEmail: this.user ? this.user.email : null,
          studentId: this.roomData ? this.roomData.student_id : null,
          studentFullName: this.user ? this.user.full_name : null,
          courseScheduleId: this.roomData ? this.roomData.courseScheduleId : null,
          enabledRequestRestock: this.roomData ? this.roomData.enabledRequestRestock : null,
        }
      }
      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'JSON',

      });
    },
    async fetchMessages() {
      let self = this;
      await this.$db
          .collection("rooms")
          .doc(this.roomId)
          .collection("messages")
          .orderBy('createdAt')
          .onSnapshot(async (querySnapShot) => {
            await querySnapShot.docs.map(async doc => {
              let message = doc.data();
              message.id = doc.id;
              message.created_at = self.formatTime(message.createdAt.toDate());
              if (typeof message.userId === 'number') {
                return;
              }
              await message.userId.get().then(async res => {
                message.user = {
                  userId: message.userId.id,
                  ...res.data()
                }
                if (!self.messages.find(i => i.id === message.id)) {
                  message.comma = self.commaTempId !== message.user.userId;
                  self.commaTempId = message.user.userId;
                  self.messages.push(message);
                  self.$nextTick(function () {
                    self.scrollToBottom();
                  });
                  // check if message is unread
                  if ((+message.user.userId !== +self.user.user_id) && !message.is_read) {
                    self.$db
                        .collection('rooms').doc(self.roomId)
                        .collection('messages').doc(message.id)
                        .update({is_read: true});
                  }
                  // if (message.readMemberIds && !message.readMemberIds.includes(Number(self.user.user_id))) {
                  //   let readMemberIds = message.readMemberIds;
                  //   readMemberIds.push(Number(self.user.user_id));
                  //   self.$db
                  //       .collection('rooms').doc(self.roomId)
                  //       .collection('messages').doc(message.id)
                  //       .update({ is_read: true });
                  // }
                  self.getImageUrl(message.user.imageUrl, message.user.userId);
                }
              })
            });
          });
    },
    scrollToBottom() {
      if (document.getElementById('messages-content')) {
        document.getElementById('messages-content').scrollTop = document.getElementById('messages-content').scrollHeight;
      }
    },
    resize() {
      let inputHeight = $('.box-input-wrapper').height();
      const $messageContent = document.getElementById('messages-content');
      const titleHeight = $('.title-wrapper').height() ? $('.title-wrapper').height() : 0;
      if (window.innerWidth <= 414) {
        if ($messageContent.classList.contains('custom-messages-content') && window.visualViewport) {
          $messageContent.style.height = `${window.visualViewport.height - inputHeight - titleHeight - 115}px`
        } else {
          $messageContent.style.height = `${window.visualViewport.height - inputHeight - 115}px`
        }
        $(window).scrollTop(0, 0);

      } else {
        if ($messageContent.classList.contains('custom-messages-content') && window.visualViewport) {
          $messageContent.style.height = `${window.visualViewport.height - inputHeight - 252}px`
        } else {
          $messageContent.style.height = `${window.visualViewport.height - inputHeight - 202}px`
        }
      }
      const resizeObs = new ResizeObserver(entries => {
        for (let entry of entries) {
          if (inputHeight !== $('.box-input-wrapper').height()) {
            inputHeight = $('.box-input-wrapper').height();
            this.resize();
          }
        }
      })
      resizeObs.observe(document.querySelector('.box-input-wrapper'));
    },
    resizeAfterLoad() {
      if (window.innerWidth <= 414) {
        const $title = $('.title-wrapper');
        const $messageContent = document.getElementById('messages-content');
        if ($messageContent.classList.contains('custom-messages-content')) {
          let titleHeight = $title.height();
          if (titleHeight) {
            $title.css({overflow: 'hidden', height: 0});
          } else {
            $title.css({overflow: '', height: ''});
          }
        }

      }
      this.resize();
    },
    resizeMessageContainer() {
      setTimeout(() => {
        this.resize();
      }, 100)
      if (window.visualViewport) {
        $(window.visualViewport).off().on('resize', () => {
          this.resizeAfterLoad();
        });
      }
    },
    initialScrollBtm() {
      $(document).ready(() => {
        this.scrollToBottom();
      });
    }
  },
  mounted() {
    this.resizeMessageContainer();
  },
  updated() {
    this.$nextTick(function () {
      this.scrollToBottom();
    })
  },
  filters: {
    timeSend(time) {
      let dateTime = dayjs(time.toDate()).tz('Asia/Tokyo');
      return String(dateTime.hour()).padStart(2, '0') + ':' + String(dateTime.minute()).padStart(2, '0');
    },
    chatTimeFilter(time) {
      let date = new Date(),
          yesterday = new Date(Date.now() - 86400000),
          currentDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`,
          yesterdayDate = `${yesterday.getFullYear()}-${yesterday.getMonth() + 1}-${yesterday.getDate()}`;
      if (time === yesterdayDate) {
        return '昨日';
      }
      if (time === currentDate) {
        return '今日';
      }
      let timeDate = dayjs(time);
      return timeDate.format('M/D(ddd)');
    }
  }
}
</script>

<style lang="scss">
.teacher-title {
  height: 35px;
  background-color: #F1F4F6;
  font-size: 16px;
  font-weight: 700;
  padding: 0px 15px;
  margin-bottom: 20px;
}

.back {
  cursor: pointer;
}

#messages-content {
  .wrapper-message {
    padding: 0 10px;
  }

  .image img {
    max-height: 200px;
  }

  .isRead {
    display: inline-block;
    font-size: 10px;
    line-height: 15px;
    color: rgba(78, 87, 104, 0.5);
  }

  .send-at-date {
    padding-top: 10px;
  }

  .message-box {
    .message {
      .item-message {
        word-break: break-word;
        padding: 12px 16px !important;

        .image {
          padding: 5px 0 5px;
          text-align: center;
          margin: auto;
        }

        p {
          padding: 0;
        }

        p, .image {
          margin-bottom: 0;
        }
      }
    }

    &:not(.rtl)
    &.rtl {
      .message {
        .item-message {
          margin-top: 6px;
        }
      }
    }
  }

  .item-message {
    img {
      cursor: pointer;
      display: block;
      width: 100%;
      object-fit: cover;
    }
  }
}

@media only screen and (max-width: 768px) {
  .back-app {
    margin-left: 0 !important;
  }
  .teacher-header {
    .header-body {
      padding: 10px 0 !important;
    }
  }
  .header-item-detail {
    display: none !important;
  }
  .teacher-title {
    margin-bottom: 10px;
  }
  .item-container {
    .login-info {
      display: none !important;
    }
  }
  .dashboard-wrapper {
    .message-detail {
      .title-wrapper {
        //margin: 0 10px;
        margin: 7px 10px 0;
      }

      .detail-message-wrapper {
        margin: 10px 10px 0;

        .box-input-wrapper {
          min-height: 1px;
          padding: 0 !important;
        }
      }
    }
  }
  #footer {
    display: none;
  }

}
</style>
