<template>
  <div class="join-course-block__body__left__gift" v-if="showDialog">
    <div class="modal-backdrop show" @click="closeDialog"></div>

    <div v-if="giftDetail" class="modal show" id="gift" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content gift-popup">
          <input type="hidden" id="gift-id">
          <div class="header-popup">
            <div class="title">{{ title() }}</div>
            <div class="exit close" data-dismiss="modal" aria-label="Close" @click="closeDialog">
              <img :src="'/assets/img/icons/exit.svg'" alt="">
            </div>
          </div>

          <div v-if="gift.gift_id !== 'EXTEND'">
            <div class="popup-gift-name">{{ gift ? gift.name : '' }}</div>
            <img :src="gift ? gift.image : ''" alt="" id="popup-gift-image">
            <div class="price">
              <span class="point">{{ gift ? gift.points_equivalent : 0 }}</span>コイン
              (¥<span id="price">{{ gift ? formatPrice(gift.price) : 0 }}</span>)
            </div>
          </div>

          <div class="modal-extend" v-if="gift.gift_id === 'EXTEND'">
            <div class="modal-extend__extend" v-if="gift.extend">
              <span class="modal-extend__extend__name">延長リクエスト</span>
              <strong class="modal-extend__extend__price">
                {{ gift.extend['minutes_required'] }}分 / ¥{{ formatPrice(gift.extend.price) }}
              </strong>
            </div>

            <div v-if="gift.options.length">
              <div class="modal-extend__title-option">有料オプション</div>
              <div class="modal-extend__option" v-for="option in gift.options">
                <img :src="'/assets/img/icons/option-status.svg'" alt="" class="modal-extend__option__status">
                <span class="modal-extend__option__name">{{ option.title }}．．．．．．．．．．</span>
                <span class="modal-extend__option__price">¥{{ formatPrice(option.price) }}</span>
              </div>
            </div>
          </div>

          <button class="buy" aria-label="Close" @click="next" :disabled="isTeacher">
            購入する
          </button>
        </div>
      </div>
    </div>

    <div v-if="giftConfirm" class="modal show gift-order" id="gift-confirm" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content next-step">
          <div class="header-popup">
            <div class="title">お支払い方法選択</div>
            <div class="exit close" data-dismiss="modal" aria-label="Close" @click="closeDialog">
              <img :src="'/assets/img/icons/exit.svg'" alt="">
            </div>
          </div>
          <div class="payment-info">
            <div class="total-payment">
              <div>クレジット支払い合計(税込)</div>
              <div class="price">¥{{ gift ? formatPrice(gift.price) : 0 }}</div>
            </div>
            <div class="title">登録済みのクレジットカード</div>
            <div class="register-card">
              <div class="img-card">
                <img :src="cardBrandImg" alt="">
              </div>
              <div class="expired-date">
                有効期限 {{ creditCard['exp_year'] }}/{{
                  creditCard['exp_month'] < 10 ? '0' : ''
                }}{{ creditCard['exp_month'] }}
              </div>
            </div>
            <div class="change-card">
              <a data-toggle="modal" data-target="#edit-card">変更する</a>
            </div>
            <div class="text-center error-card text-danger" style="display: none;">
              クレジットカード情報を登録してください。
            </div>
            <div class="action d-flex">
              <button class="back back-confirm" @click="back">
                戻る
              </button>
              <button class="confirm" id="button-confirm" data-dismiss="modal" @click="next">
                確認する
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="giftBuy" class="modal show gift-order" id="gift-buy" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content next-step">
          <div class="header-popup">
            <div class="title">内容の確認</div>
            <div class="exit close" data-dismiss="modal" aria-label="Close" @click="closeDialog">
              <img :src="'/assets/img/icons/exit.svg'" alt="">
            </div>
          </div>
          <div class="payment-info">
            <div class="total-payment">
              <div>クレジット支払い合計(税込)</div>
              <div class="price">¥{{ gift ? formatPrice(gift.price) : 0 }}</div>
            </div>
            <div class="title">登録済みのクレジットカード</div>
            <div class="register-card">
              <div class="img-card">
                <img :src="cardBrandImg" alt="">
              </div>
              <div class="expired-date">
                有効期限 {{ creditCard['exp_year'] }}/{{
                  creditCard['exp_month'] < 10 ? '0' : ''
                }}{{ creditCard['exp_month'] }}
              </div>
            </div>
            <div class="action d-flex justify-content-between">
              <button class="back back-confirm" @click="back">
                戻る
              </button>
              <button id="buy-gift" class="buy" data-dismiss="modal" @click="next">
                決済する
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="giftSuccess" class="modal show gift-order" id="gift-success" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content next-step payment-success">
          <div class="title">決済が終了しました</div>
          <div class="payment-info">

            <div class="total-payment clear-top" v-if="gift.gift_id !== 'EXTEND'">
              <div v-if="gift.statusGiftHand">{{ gift.name }}</div>
              <div v-else>ギフト</div>
              <div class="price">¥{{ formatPrice(gift.price) }}</div>
            </div>

            <div class="modal-extend" v-if="gift.gift_id === 'EXTEND'">
              <div class="modal-extend__extend" v-if="gift.extend">
                <span class="modal-extend__extend__name">延長リクエスト</span>
                <strong class="modal-extend__extend__price">
                  {{ gift.extend['minutes_required'] }}分 / ¥{{ formatPrice(gift.extend.price) }}
                </strong>
              </div>

              <div v-if="gift.options.length">
                <div class="modal-extend__title-option">有料オプション</div>
                <div class="modal-extend__option" v-for="option in gift.options">
                  <img :src="'/assets/img/icons/option-status.svg'" alt="" class="modal-extend__option__status">
                  <span class="modal-extend__option__name">{{ option.title }}．．．．．．．．．．</span>
                  <span class="modal-extend__option__price">¥{{ formatPrice(option.price) }}</span>
                </div>
              </div>
            </div>

            <div class="total-payment clear-top">
              <div class="gift-success-text">クレジット支払い合計
                <span style="font-weight: 300">(税込)</span>
              </div>
              <div class="price">¥{{ formatPrice(gift.price) }}</div>
            </div>
            <div class="action d-flex justify-content-between">
              <button class="confirm confirm-success" @click="closeDialog">
                閉じる
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="giftError" class="modal show gift-order" id="gift-error" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content next-step payment-success">
          <div class="title text-center title-error">{{ errorMessage }}</div>
          <div class="payment-info">
            <div class="action d-flex justify-content-center m-0">
              <button class="confirm confirm-success m-0" @click="closeDialog">
                OK
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <EditCard @edit-success="fetchCardInfo"/>

  </div>
</template>
<script>
import SwiperCore, {Navigation, Pagination} from 'swiper/core';
import EditCard from "./EditCard";
// configure Swiper to use modules
SwiperCore.use([Navigation, Pagination])
export default {
  name: "PurchaseComponent",
  components: {
    EditCard
  },
  props: ['isTeacher', 'courseSchedule'],
  data() {
    return {
      subCourseFree: true,
      gift: null,
      creditCard: {},
      courseScheduleId: null,
      showDialog: false,
      giftDetail: false,
      giftBuy: false,
      giftConfirm: false,
      giftSuccess: false,
      giftError: false,
      errorMessage: 'クレジットカード決済に失敗しました',
    }
  },
  computed: {
    cardBrandImg() {
      switch (this.creditCard['card_brand']) {
        case 'visa':
          return '/assets/img/clients/cards/visa.svg';
        case 'mastercard':
          return '/assets/img/clients/cards/master_card.svg';
          // case 'jcb':
          //   return '/assets/img/clients/cards/jcb.svg';
          // case 'amex':
          //   return '/assets/img/clients/cards/american-express.svg';
        default:
          return '/assets/img/clients/cards/american-express.svg';
          // default:
          //   return '/assets/img/clients/cards/dinner.svg';
      }
    }
  },
  mounted() {
  },
  methods: {
    title() {
      switch (this.gift.gift_id) {
        case 0:
          return '挙手購入';
        case 'EXTEND':
          return '延長サビース購入';
        default:
          return 'ギフト購入';
      }
    },
    fetchCardInfo() {
      let self = this;
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
              self.creditCard = res.data;
            }
            $('#loading-overlay').hide();
          })
          .catch(function () {
            $('#loading-overlay').hide();
          });
    },
    show() {
      this.showDialog = true;
    },
    closeDialog(context) {
      this.showDialog = false;
      this.giftDetail = false;
      this.giftBuy = false;
      this.giftConfirm = false;
      this.giftSuccess = false;
      this.giftError = false;
      if (!context || context !== 'buyGift') {
        this.gift = null;
      }
      this.creditCard = null;
      this.courseScheduleId = null;
      $('.modal-backdrop').hide();
    },
    next() {
      if (!this.gift) return;

      if (this.isTeacher) {
        this.giftDetail = true;
        return;
      }

      if (this.gift.gift_id === 'EXTEND') {
        if (new Date(this.gift.end_datetime_string).getTime() - new Date().getTime() < 5 * 60 * 1000) {
          this.giftDetail = false;
          this.giftConfirm = false;
          this.giftBuy = false;
          this.giftSuccess = false;
          this.giftError = true;

          this.errorMessage = '延長期限を超過しました。';

          return;
        }
      }

      switch (true) {
        case this.giftDetail:
          this.giftDetail = false;
          this.giftConfirm = true;
          break;
        case this.giftConfirm:
          if (!this.creditCard['exp_year']) {
            $('#gift-confirm').find('.error-card').show();
            return;
          }
          this.giftConfirm = false;
          this.giftBuy = true;
          break;
        case this.giftBuy:
          this.progressBuyGift();
          break;
        default:
          this.giftDetail = true;
          break
      }
    },
    back() {
      switch (true) {
        case this.giftConfirm:
          this.giftConfirm = false;
          this.giftDetail = true;
          break;
        case this.giftBuy:
          this.giftBuy = false;
          this.giftConfirm = true;
          break;
        default:
          break;
      }
    },
    formatPrice(value) {
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "")
    },
    openBuyGift(gift, card, courseScheduleId) {
      if (!gift || !card || !courseScheduleId) return;

      this.showDialog = true;
      this.gift = gift;
      this.creditCard = card;
      this.courseScheduleId = courseScheduleId;
      this.next();
    },
    progressBuyGift() {
      let data, url;

      switch (this.gift.gift_id) {
        case 0:
          url = '/question-ticket/purchase';
          data = {
            gift_id: this.gift.gift_id,
            course_schedule_id: this.courseScheduleId
          };
          break;
        case 'EXTEND':
          url = '/extension/purchase';
          data = {
            course_id: this.gift.extend ? this.gift.extend.course_id : this.courseSchedule.course_id,
            origin_course_schedule_id: this.courseScheduleId,
            current_course_schedule_id: this.gift.current_course_schedule_id,
            course_schedule_id: this.courseScheduleId,
            // extend_ids: this.gift.extend.map(el => el['course_id']),
            optional_extra_ids: this.gift.options.map(el => el['optional_extra_id']),
          };
          break;
        default:
          url = '/student/student-livestream/purchase-gift';
          data = {
            gift_id: this.gift.gift_id,
            course_schedule_id: this.courseScheduleId
          };
          break;
      }

      $.ajax({
        beforeSend: function () {
          // $('#loading-overlay').show();
          document.getElementById('buy-gift').disabled = true;
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: url,
        data: data
      })
          .done(async (res) => {
            document.getElementById('buy-gift').disabled = false;
            if (res.success) {
              if (this.gift.gift_id === 'EXTEND') {
                let elements = document.getElementsByName('extend');
                elements.forEach((element) => {
                  if (this.gift.extend) {
                    element.disabled = true;
                  }
                  if (element.value === res.course_id) {
                    $(element).parent('.extension-request__price__option__option-outline').find('.checkmark').addClass('checkmark-purchase')
                  }
                });
              }
              this.giftBuy = false;
              this.giftSuccess = true;
              if (res.current_course_schedule_id) {
                this.gift['current_course_schedule_id'] = res.current_course_schedule_id;
              }
              await new Promise((res, rej) => {
                setTimeout(() => {
                  this.closeDialog('buyGift');
                  res('done');
                }, 1000);
              })
                  .then(() => {
                    this.$emit('buy-gift-success', this.gift);
                    this.gift = null;
                  });
              // await setTimeout(() => {
              //   this.closeDialog();
              // }, 1000);
            } else {
              this.giftBuy = false;
              this.giftError = true;
              if (res.message) {
                this.errorMessage = res.message;
              } else {
                this.errorMessage = 'クレジットカード決済に失敗しました';
              }
            }
            // $('#loading-overlay').hide();
          })
          .catch(function () {
            document.getElementById('buy-gift').disabled = false;
            // $('#loading-overlay').hide();
          });
    }
  }
}
</script>

<style scoped lang="scss">
.total-payment {
  .gift-success-text {
    display: block;
  }
}

.title-error {
  font-size: 16px;
  font-weight: 600;
}

.modal-dialog {
  height: 100%;
  margin-top: 0;
  justify-content: center;
  align-items: flex-start;
  padding-top: 200px;
}

#gift-error {
  .modal-content {
    padding: 30px 0px !important;
    height: 150px;

    .payment-info {
      margin: 25px 0px 0px 0px;
      padding: 0;
      width: 100%;
    }
  }
}

.img-card img:last-child {
  margin-left: 10px;
}
</style>
