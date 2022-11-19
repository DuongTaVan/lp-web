<template>
  <div class="join-course-block__body__left__gift">
    <div class="row gift-outline">
      <div class="livestream-note-app">
        <div class="livestream-note">
          <div class="note-title">受講者限定サービス！</div>
          <div class="note-content">
            <h3>個別講座(ビデオ通話)</h3>
            <div class="note-price" v-if="subCourse">
              {{ subCourse['minutes_required'] }}分
              ¥{{ formatPrice(subCourse['price']) }}
            </div>
            <div v-if="subCourse" class="sub-course-link">
              <a v-if="isTeacher" target="_blank"
                 :href="`/teacher/sub-course-detail/${courseSchedule['course']['course_id']}`">日程を見る <img
                  src="/assets/img/icons/arrow-right.svg" alt=""></a>
              <a v-else target="_blank"
                 :href="`/orders/sub-course/${courseSchedule['course_schedule_id']}/detail`">日程を見る <img
                  src="/assets/img/icons/arrow-right.svg" alt=""></a>
            </div>
            <div v-else class="no-sub-course">只今受け付けておりません</div>
          </div>
        </div>
        <div class="jamb-right"></div>
      </div>
      <div class="livestream-gift-app">
        <div class="gift-title">ギフト</div>
        <div class="swiper-container gift-container">
          <div class="swiper-wrapper gift-wrapper" v-if="gifts.length >0">
            <div class="swiper-slide slide-gift" v-for="gift in gifts" :key="gift.gift_id">
              <div class="gift-paragraph" @click="openBuyGift(gift.gift_id)"
                   data-toggle="tooltip" :title="'¥' + formatPrice(gift.price)">
                <a class="link-item">
                  <div class="gift-name">{{ gift.name }}</div>
                  <img :src="gift ? gift.image : ''" alt="" class="img-fluid gift-img">
                  <div class="gift-price">{{ gift.points_equivalent }}コイン</div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Mobile Gift and Comment-->
    <div class="gift-mobile" id="gift-mobile">
      <div class="gift-mobile__gift-slider">
        <div class="gift-mobile__gift-slider__title">ギフト</div>
        <div class="gift-mobile__gift-slider__gifts" v-if="gifts.length >0">
          <div class="gift-paragraph"
               v-for="gift in gifts"
               :key="gift.gift_id"
               @click="openBuyGift(gift.gift_id)"
               data-toggle="tooltip" :title="'¥' + formatPrice(gift.price)"
          >
            <a class="link-item">
              <img :src="gift ? gift.image : ''" alt="" class="gift-img"
                   style="width: 35px">
            </a>
          </div>
        </div>
      </div>
      <div class="gift-mobile__body">
        <div class="gift-mobile__body__note-title">受講者限定サービス！</div>
        <div class="gift-mobile__body__content">
          <div class="gift-mobile__body__content__sub-course">
            <h3>個別講座(ビデオ通話)</h3>
            <div class="note-price" v-if="subCourse">
              {{ subCourse['minutes_required'] }}分
              ¥{{ formatPrice(subCourse['price']) }}
            </div>
            <div v-if="subCourse" class="sub-course-link">
              <a v-if="isTeacher" target="_blank"
                 :href="`/teacher/sub-course-detail/${courseSchedule['course']['course_id']}`">日程を見る
                <img src="/assets/img/icons/arrow-right.svg" alt=""></a>
              <a v-else target="_blank"
                 :href="`/orders/sub-course/${courseSchedule['course_schedule_id']}/detail`">日程を見る <img
                  src="/assets/img/icons/arrow-right.svg" alt=""></a>
            </div>
            <a v-else class="no-sub-course">只今受け付けておりません</a>
          </div>
          <!--chat input-->
          <div class="gift-mobile__body__content__comment">
            <div class="first-chat d-flex">
              <div class="">
                <img src="/assets/img/student-live-stream/emojione_hand-with-fingers.png" alt=""
                     class="img-fluid icon-hand">
              </div>
              <div class="p-0 input-gift">
<!--                <input v-model="message" type="text" class="chat-input" id="comment-chat" placeholder="質問を入力し送信して下さい">-->
                <textarea v-model="message" @input="resizeTextarea" ref="textarea"
                          class="chat-input va-mid" id="comment-chat" placeholder="質問を入力" rows="1">
                </textarea>
              </div>

              <div class="ml-auto text-right">
                <a v-if="!message" href="javascript:;">
                  <img src="/assets/img/icons/sent-message.svg" alt="">
                </a>
                <a v-else @click="sendQuestion">
                  <img src="/assets/img/icons/send.svg" alt="" class="img-fluid icon-sent-message pointer">
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End Mobile Gift and Comment-->
    <purchase-gift ref="purchaseGift" @buy-gift-success="buyGiftSuccess" :isTeacher="isTeacher"></purchase-gift>
  </div>
</template>
<script>
import Swiper from "swiper";
import SwiperCore, { Navigation, Pagination } from 'swiper/core';

// configure Swiper to use modules
SwiperCore.use([Navigation, Pagination])
export default {
  name: "StudentGiftShop",
  props: ['gifts', 'creditCard', 'courseSchedule', 'subCourse', 'isTeacher'],
  data() {
    return {
      card: JSON.parse(this.creditCard),
      questionTicket: null,
      gift: null,
      message: '',
      maxHeight: 100
    };
  },
  mounted() {
    $('[data-toggle="tooltip"]').tooltip({ customClass: 'gift-paragraph' });
    this.giftSlider();
    this.$emit('gift-rendered');
  },
  methods: {
    resizeTextarea() {
      const { textarea } = this.$refs;
      textarea.style.height = 'auto';
      if (textarea.scrollHeight > this.maxHeight) {
        textarea.style.overflow = 'auto';
        textarea.style.height = this.maxHeight + 'px';
      } else {
        textarea.style.overflow = 'hidden';
        textarea.style.height = textarea.scrollHeight - 4 + 'px';
      }
    },
    formatPrice(value) {
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    giftSlider() {
      let swiper = new Swiper('.gift-container', {
        slidesPerView: 9,
        navigation: {
          nextEl: ".button-next-gift",
          prevEl: ".button-prev-gift"
        },
        breakpoints: {
          // when window width is >= 320px
          320: {
            slidesPerView: 3,
          },
          // when window width is >= 480px
          480: {
            slidesPerView: 3,
          },
          // when window width is >= 640px
          640: {
            slidesPerView: 7,
          },
          1140: {
            slidesPerView: 9,
          }
        }
      });
      return swiper
    },
    openBuyGift(giftId) {

      const gift = this.gifts.find(el => el.gift_id === giftId);
      if (!gift) return;

      if (this.isTeacher) {
        this.$refs.purchaseGift.openBuyGift(gift, true, this.courseSchedule['course_schedule_id']);
        return;
      }

      if (!localStorage.getItem('CARD-CHANGED')) {
        this.$refs.purchaseGift.openBuyGift(gift, JSON.parse(this.creditCard), this.courseSchedule['course_schedule_id']);
      } else {
        $.ajax({
          beforeSend: () => {
            $('#loading-overlay').show();
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          method: "GET",
          url: "/api/card-info",
          data: {},
        })
            .done((res) => {
              if (res.success) {
                localStorage.removeItem('CARD-CHANGED');
                this.creditCard = JSON.stringify(res.data);
                this.$refs.purchaseGift.openBuyGift(gift, JSON.parse(this.creditCard), this.courseSchedule['course_schedule_id']);
              }
              $('#loading-overlay').hide();
            })
            .catch(function () {
              $('#loading-overlay').hide();
            });
      }
    },
    buyGiftSuccess(gift) {
      if (gift.gift_id) {
        this.$emit('purchaseGiftSuccess', gift.gift_id);
      }
    },
    buyHandUp() {
      this.$emit('buyHandUp');
    },
    getHand(res) {
      this.questionTicket = res;
    },
    sendQuestion() {
      this.$emit('sendQuestion', false, this.message);
    },
    suggestComment(suggest) {
      if (suggest === '') {
        this.message = suggest;
      }
      if (this.questionTicket) {
        this.message = suggest;
      }
    },
    suggestCommentStamp(suggest) {
      this.message = suggest;
      this.$emit('sendQuestionStamp', false, this.message);
    }
  }
}
</script>
