<template>
  <main>
    <div class="join-course-block__body__right__box-chat">
      <!--      <div v-if="!questionTicket" class="form-gift">-->
      <!--        <div class="d-flex bd-highlight">-->
      <!--          <div class="pl-4 bd-highlight text-center">-->
      <!--            <div class="gift-name">挙手</div>-->
      <!--            <div class="icon-gift">-->
      <!--              <img src="/assets/img/student-live-stream/emojione_hand-with-fingers.png" alt=""-->
      <!--                   class="img-fluid" id="raise-hand">-->
      <!--            </div>-->
      <!--          </div>-->
      <!--          <div class="pl-3 bd-highlight">-->
      <!--            <div class="gift-name">(質問)</div>-->
      <!--            <span class="total-gift">1件/20コイン (¥200)</span>-->
      <!--          </div>-->
      <!--          <div class="ml-auto bd-highlight btn-sent-gift" @click="buyHandUp">購入</div>-->
      <!--        </div>-->
      <!--      </div>-->
      <!--      <div v-if="questionTicket" class="first-chat">-->
      <div class="first-chat">
        <div class="d-flex">
          <div class="">
            <img src="/assets/img/student-live-stream/emojione_hand-with-fingers.png" alt=""
                 class="img-fluid icon-hand">
          </div>
          <div class="p-0 icon-gift">
            <textarea v-model="message" @input="resizeTextarea" ref="textarea"
                      class="chat-input va-mid" id="comment-chat" placeholder="質問を入力" rows="1">
            </textarea>
          </div>

          <div class="ml-3 text-right">
            <a v-if="!message" href="javascript:;">
              <img src="/assets/img/icons/sent-message.svg" alt="">
            </a>
            <a v-else @click="sendQuestion()">
              <img src="/assets/img/icons/send.svg" alt="" class="img-fluid icon-sent-message pointer"></a>
          </div>
        </div>
      </div>
      <!--  form card before chat-->
      <div class="chat-paragraph">
        <div class="block-stamp" id="block-stamp">
          <div class="quick-chat" id="quick-chat">
            <div class="swiper-container quick-chat-container">
              <div class="swiper-button swiper-button-prev button-prev-quick-chat"></div>
              <div class="swiper-wrapper quick-chat-wrapper">
                <div class="swiper-slide swiper-slide-quick-chat btn" v-for="(suggest, index) in suggestions"
                     :key="index"
                     @click="suggestCommentStamp(suggest)">
                  <span> {{ suggest }} </span>
                </div>
              </div>
              <div class="swiper-button swiper-button-next button-next-quick-chat"></div>
            </div>
          </div>
        </div>

        <div class="comment-block" id="comment-block">
          <div class="viewer-comment" v-for="index in comments.length" :key="index">
            <div class="d-flex bd-highlight">
              <div class="flex-shrink-1 bd-highlight">
                <div class="avatar-viewer">
                  <a>
                    <img class="avatar-user img-fluid" :key="index + imageKey"
                         :src="getImage(comments[comments.length - index].user.userId)" alt="">
                    <img src="/assets/img/icons/online.svg" alt="" class="icon-status">
                  </a>
                </div>
              </div>
              <div class="w-100 bd-highlight">
                <div class="comment-content" v-bind:class="{ gift: comments[comments.length - index].type === 'GIFT' }">
                  <strong>
                    {{ comments[comments.length - index].user ? comments[comments.length - index].user.nickname : "" }}
                  </strong>
                  <p style="white-space: pre-line;white-space: pre-wrap;"
                     v-html="comments[comments.length - index].message"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <purchase-gift ref="purchaseGift" :isTeacher="isTeacher"></purchase-gift>
    <!-- Modal -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <p class="title">この内容で送信してもよろしいですか？</p>
            <div class="list-btn">
              <button class="btn btn-back" data-dismiss="modal">キャンセル</button>
              <button class="btn btn-confirm" @click="sendQuestion(true)">OK</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import Swiper from "swiper";
import SwiperCore, {Navigation, Pagination} from 'swiper/core';
import {useSound} from "@vueuse/sound";
// configure Swiper to use modules
SwiperCore.use([Navigation, Pagination])
export default {
  name: "StudentBoxChat",
  props: ['creditCard', 'courseSchedule', 'isTeacher'],
  setup() {
    const {play, stop} = useSound(window.location.origin + '/assets/sounds/notification-2.wav');

    return {
      play,
      stop,
    }
  },
  data() {
    return {
      card: JSON.parse(this.creditCard),
      questionTicket: null,
      comments: [],
      message: "",
      suggestions: [
        "はい！", "こんにちは!", "こんばんは!", "ありがとうございます!", "さようなら！"
      ],
      listImageUrl: {},
      imageKey: 0,
      maxHeight: 100,
    };
  },
  computed: {
    commentsSort() {
      return this.comments.sort((a, b) => {
        let dateA = new Date(a.createdAt);
        let dateB = new Date(b.createdAt);
        if (!(dateB instanceof Date && !isNaN(dateB))) {
          return -1;
        }
        if (dateA > dateB) {
          return -1;
        }
        if (dateA < dateB) {
          return 1;
        }
        return 0;
      })
    }
  },
  mounted() {
    this.quickChatSlider();
    // this.getHand();
    this.fetchMessages();
  },
  methods: {
    resizeTextarea() {
      const {textarea} = this.$refs;
      textarea.style.height = 'auto';
      if (textarea.scrollHeight > this.maxHeight) {
        textarea.style.overflow = 'auto';
        textarea.style.height = this.maxHeight + 'px';
      } else {
        textarea.style.overflow = 'hidden';
        textarea.style.height = textarea.scrollHeight - 4 + 'px';
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
    suggestComment(suggest) {
      if (this.questionTicket) {
        this.message = suggest;
        this.$emit('suggestComment', suggest);
      }
    },
    suggestCommentStamp(suggest) {
      if (this.isTeacher) {
        return false;
      }
      // this.message = suggest;
      // this.$emit('suggestCommentStamp', suggest);
      if (suggest) {
        this.message = suggest;
      }
      let forceSend = false;
      $.ajax({
        beforeSend: () => {
          // $('#loading-overlay').show();
          $('.join-course-block__body__right').addClass('join-course-block__body__right__overlay')
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/student/stamp",
        data: {
          message: this.message,
          courseScheduleId: this.courseSchedule.course_schedule_id,
          forceSend: forceSend ? 1 : 0
        },
      })
          .done((res) => {
            // if (res) {
            //   this.getHand();
            //   this.canHandUp = true;
            //   this.questionTicket = res;
            // }
            $('.join-course-block__body__right').removeClass('join-course-block__body__right__overlay')
            this.message = "";
            this.$emit('suggestComment', '');
            $('#modalConfirm').modal('hide');
            // $('#loading-overlay').hide();
          })
          .catch(function (error) {
            if (error.status === 429) {
              $('#modalConfirm').modal('show');
            }
            // $('#loading-overlay').hide();
          });
    },
    quickChatSlider() {
      return new Swiper('.quick-chat-container', {
        slidesPerView: 3,
        navigation: {
          nextEl: '.button-next-quick-chat',
          prevEl: '.button-prev-quick-chat',
        },
        breakpoints: {
          // when window width is >= 320px
          320: {
            freeMode: {
              enabled: true,
            },
            slidesPerView: 'auto',
          },
          // when window width is >= 480px
          480: {
            freeMode: {
              enabled: true,
            },
            slidesPerView: 'auto',
          },
          // when window width is >= 640px
          640: {
            freeMode: {
              enabled: true,
            },
            slidesPerView: 'auto',
          },
          1140: {
            slidesPerView: 3,
          }
        }
      });
    },
    sendQuestion(forceSend = false, message = '') {
      if (this.isTeacher) {
        return false;
      }

      if (message) {
        this.message = message;
      }
      // if (!this.questionTicket || !this.message) return;
      if (!this.message) return;
      let self = this;
      $.ajax({
        beforeSend: () => {
          // $('#loading-overlay').show();
          $('.join-course-block__body__right').addClass('join-course-block__body__right__overlay')
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/student/question-ticket",
        data: {
          message: this.message,
          courseScheduleId: this.courseSchedule.course_schedule_id,
          forceSend: forceSend ? 1 : 0
        },
      })
          .done((res) => {
            $('.join-course-block__body__right').removeClass('join-course-block__body__right__overlay')
            this.message = "";
            this.$emit('suggestComment', '');
            $('#modalConfirm').modal('hide');
            self.$nextTick(() => {
              self.resizeTextarea();
            });
            // $('#loading-overlay').hide();
          })
          .catch(function (error) {
            if (error.status === 429) {
              $('#modalConfirm').modal('show');
            }
            // $('#loading-overlay').hide();
          });
    },
    sendQuestionStamp(forceSend = false, message = '') {
      if (message) {
        this.message = message;
      }

      $.ajax({
        beforeSend: () => {
          // $('#loading-overlay').show();
          $('.join-course-block__body__right').addClass('join-course-block__body__right__overlay')
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/student/stamp",
        data: {
          message: this.message,
          courseScheduleId: this.courseSchedule.course_schedule_id,
          forceSend: forceSend ? 1 : 0
        },
      })
          .done((res) => {
            // if (res) {
            //   this.getHand();
            //   this.canHandUp = true;
            //   this.questionTicket = res;
            // }
            $('.join-course-block__body__right').removeClass('join-course-block__body__right__overlay')
            this.message = "";
            this.$emit('suggestComment', '');
            $('#modalConfirm').modal('hide');
            // $('#loading-overlay').hide();
          })
          .catch(function (error) {
            if (error.status === 429) {
              $('#modalConfirm').modal('show');
            }
            // $('#loading-overlay').hide();
          });
    },
    // buyHandSuccess() {
    //   // document.getElementById('audioNotification').play();
    //   // this.playSound();
    //   this.getHand();
    // },
    // getHand() {
    //   $.ajax({
    //     // beforeSend: () => {
    //     //   $('#loading-overlay').show();
    //     // },
    //     headers: {
    //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     method: "GET",
    //     url: "/student/question-ticket/" + this.courseSchedule['course_schedule_id'],
    //   })
    //       .done((res) => {
    //         if (res) {
    //           this.questionTicket = res;
    //           this.$emit('getHand', res);
    //         } else {
    //           this.questionTicket = null;
    //           this.$emit('getHand', null);
    //         }
    //         // $('#loading-overlay').hide();
    //       })
    //       .catch(function () {
    //         // $('#loading-overlay').hide();
    //       });
    // },
    // buyHandUp() {
    //   const gift = {
    //     'gift_id': 0,
    //     'image': '/assets/img/student-live-stream/big-raise-hand.svg',
    //     'name': '挙手',
    //     'points_equivalent': 20,
    //     'price': 200,
    //     'statusGiftHand': true,
    //   };
    //
    //   if (this.isTeacher) {
    //     this.$refs.purchaseGift.openBuyGift(gift, true, this.courseSchedule['course_schedule_id']);
    //     return;
    //   }
    //
    //   if (!localStorage.getItem('CARD-CHANGED')) {
    //     this.$refs.purchaseGift.openBuyGift(gift, JSON.parse(this.creditCard), this.courseSchedule['course_schedule_id']);
    //   } else {
    //     $.ajax({
    //       beforeSend: () => {
    //         $('#loading-overlay').show();
    //       },
    //       headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //       },
    //       method: "GET",
    //       url: "/api/card-info",
    //       data: {},
    //     })
    //         .done((res) => {
    //           if (res.success) {
    //             localStorage.removeItem('CARD-CHANGED');
    //             this.creditCard = JSON.stringify(res.data);
    //             this.$refs.purchaseGift.openBuyGift(gift, JSON.parse(this.creditCard), this.courseSchedule['course_schedule_id']);
    //           }
    //           $('#loading-overlay').hide();
    //         })
    //         .catch(function () {
    //           $('#loading-overlay').hide();
    //         });
    //   }
    // },
    playSound() {
      this.$emit('getVolume', (volume) => {
        if (volume > 0) {
          this.play();
        }
      })
    },
    async fetchMessages() {
      const now = new Date().getTime();
      await this.$db
          .collection('live_streams/' + this.courseSchedule.course_schedule_id + '/comments')
          .orderBy('createdAt')
          .onSnapshot(async (querySnapShot) => {
            await querySnapShot.docs.map(async doc => {
              let comment = doc.data();
              comment.id = doc.id;
              if (!this.comments.find(i => i.id === comment.id)) {
                if (comment.userId) {
                  // await comment.userId.get().then(async res => {
                  //   if (comment.createdAt.toMillis() > now && comment.type !== 'GIFT') {
                  //     this.playSound();
                  //   }
                  //   comment.user = {
                  //     userId: comment.userId.id,
                  //     ...res.data()
                  //   }
                  //   if (comment.createdAt) {
                  //     comment.createdAt = comment.createdAt.toDate();
                  //   }
                  //   this.comments.push(comment);
                  //   this.getImageUrl(comment.user.imageUrl, comment.user.userId);
                  //   this.$nextTick(function () {
                  //     this.scrollToTop();
                  //   });
                  // })
                  const myPromise = new Promise((resolve, reject) => {
                    comment.userId.get().then(async res => {
                      const data = res.data();
                      resolve(data);
                    })
                  });
                  myPromise
                      .then(value => {
                        if (value) {
                          if (comment.createdAt.toMillis() > now && comment.type !== 'GIFT') {
                            this.playSound();
                          }
                          comment.user = {
                            userId: comment.userId.id,
                            ...value
                          };
                          if (comment.createdAt) {
                            comment.createdAt = comment.createdAt.toDate();
                          }
                          this.comments.push(comment);
                          this.getImageUrl(comment.user.imageUrl, comment.user.userId);
                          this.$nextTick(function () {
                            this.scrollToTop();
                          });
                        }
                      });

                  // } else {
                  //   // this.comments.push(comment);
                  //   this.$nextTick(function () {
                  //     this.scrollToTop();
                  //   });
                }
              }
            });
          });
    },
    scrollToTop() {
      if (document.getElementById('comment-block')) {
        document.getElementById('comment-block').scrollTop = 0;
      }
    },
    commentOfGift(message) {
      return message.includes('を送りました');
    }
  }
}
</script>

<style lang="scss">
.join-course-block__body__right__box-chat .chat-paragraph > .block-stamp .quick-chat .swiper-slide-quick-chat:nth-child(1) {
  margin-left: 25px;
}

.avatar-user {
  width: 45px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 1px solid #C5C5C5;
}

.pointer {
  cursor: pointer;
}

.viewer-comment {
  word-break: break-all;
}

.join-course-block__body__right__overlay {
  pointer-events: none !important;
}

#modalConfirm {
  .modal-content {
    width: 400px;
  }

  .modal-dialog {
    margin-top: 20vh;
    display: flex;
    justify-content: space-evenly;
  }

  .modal-body {
    padding: 30px 33px;

    .title {
      font-size: 16px;
      font-weight: 600;
      color: #2A3242;
      margin: 0;
      text-align: center;
      margin-bottom: 25px;
    }

    .list-btn {
      display: flex;
      justify-content: space-between;
    }

    .btn-back {
      width: 150px;
      background-color: #FFFFFF;
      border: 1px solid #4E576833;
      color: #2A3242;
      font-size: 14px;
      font-weight: 600;
      height: 41px;
    }

    .btn-confirm {
      width: 150px;
      height: 41px;
      color: #FFFFFF;
      background-color: #46CB90;
    }
  }
}

@media only screen and (max-width: 414px) {
  .join-course-block__body__right__box-chat .chat-paragraph > .block-stamp .quick-chat .swiper-slide-quick-chat:nth-child(1) {
    margin-left: unset;
  }
}
</style>
