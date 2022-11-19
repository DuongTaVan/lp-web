<template>
  <div v-show="showExtend">
    <div class="extension-request">
      <div v-if="extend_course.length>0" class="extension-request__title" @click="handleShowOptionExtend"> 延長リクエスト <img
          src="/assets/img/join-course/drop-down-extend.svg" alt="" class="dropdown-option-extend-icon">
      </div>
      <div id="optionExtend">
        <div v-if="extend_course.length>0" class="extension-request__price">
          <div v-for="extend in extend_course" class="extension-request__price__option">
            <label class="extension-request__price__option__option-outline">
              <input type="radio" :value="extend.course_id" name="extend"
                     v-on:change="handleBtnPurchase"
                     :disabled="extend['disabled']">
              <span class="checkmark" :class="{'checkmark-purchase': extend['purchased']}"></span>
              <span>{{ extend['minutes_required'] }}分 / ¥{{ formatPrice(extend.price) }}</span>
            </label>
          </div>
        </div>
      </div>
      <div class="extension-request__submit">
        <button v-if="extend_course || option_extra" type="submit"
                @click="openBuyExtend"
                class="btn extension-request__submit__btn-sent-request"
                :disabled="disablePurchase"
        >購入手続きへ
        </button>
        <button v-else type="submit" class="btn extension-request__submit__btn-sent-request" disabled>
          購入手続きへ
        </button>
      </div>
      <div v-if="option_extra.length>0" class="extension-request__dropdown-option">
        <div class="dropdown">
              <span class="dropdown-toggle extension-request__dropdown-option__btn-dropdown-toggle drop-btn-extension
                  drop-btn-extension-mobile" @click="showOptionExtension">
              <img :src="'/assets/img/student-live-stream/icon/primary_plus.svg'" alt=""
                   class="extension-request__dropdown-option__btn-dropdown-toggle__icon-primary-plus">
              <span>有料オプション</span>
              <img :src="'/assets/img/student-live-stream/icon/dropdown_arrow.svg'" alt=""
                   class="extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow">
                  <img :src="'/assets/img/join-course/drop-down-extend.svg'" alt=""
                       class="extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow-right">
            </span>
          <span
              class="dropdown-toggle extension-request__dropdown-option__btn-dropdown-toggle drop-btn-extension dropdown-option-app">
              <img :src="'/assets/img/student-live-stream/icon/primary_plus.svg'" alt=""
                   class="extension-request__dropdown-option__btn-dropdown-toggle__icon-primary-plus">
              <span>有料オプション</span>
              <img :src="'/assets/img/student-live-stream/icon/dropdown_arrow.svg'" alt=""
                   class="extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow ">
                <img :src="'/assets/img/join-course/drop-down-extend.svg'" alt=""
                     class="extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow-right ">
            </span>
          <ul id="dropExtensionRequest"
              class="dropdown-extension dropdown-menu extension-request__dropdown-option__menu-custom">
            <li v-for="option in option_extra" :key="option['optional_extra_id']">
              <label class="checkbox-option">
                <input type="checkbox" :value="option['optional_extra_id']"
                       v-on:change="handleBtnPurchase"
                       v-model="option['checked']"
                       :checked="option['purchased']"
                       :disabled="option['purchased']">
                <span class="checkmark" :class="{'checkmark-purchase': option['purchased']}"></span>
              </label>
              <div class="d-flex flex-column content-option-extend">
                <span class="extension-request__dropdown-option__menu-custom__name">{{ option.title }}</span>
                <span class="extension-request__dropdown-option__menu-custom__price"><img
                    :src="'/assets/img/student-live-stream/icon/add.svg'" alt="">¥{{ formatPrice(option.price) }}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <purchase-gift @buy-gift-success="buyExtendSuccess" ref="purchaseGift" :isTeacher="isTeacher"
                   :courseSchedule="courseSchedule">
    </purchase-gift>
  </div>
</template>

<script>

export default {
  name: "BoxExtend",
  props: ['extend_course', 'option_extra', 'courseSchedule', 'isTeacher', 'creditCard'],
  data() {
    return {
      showExtend: true,
      disablePurchase: true,
      checkedRadioValue: null,
      current_course_schedule_id: null,
      optionPurchased: [],
      optionsChecked: []
    };
  },
  mounted() {
    this.current_course_schedule_id = this.courseSchedule.current_course_schedule_id;
    this.showOptionExtensionPC();
    // this.removeCheckedWhenClickAgain();
  },
  methods: {
    handleShowOptionExtend() {
      let iconDropdown = $('.dropdown-option-extend-icon');
      let optionExtend = $('#optionExtend');
      optionExtend.slideToggle(() => {
        if (optionExtend.is(":visible")) {
          iconDropdown.css('transform', 'rotate( -180deg )');
          iconDropdown.css('transition', 'transform 150ms ease');

        } else {
          iconDropdown.css('transform', 'rotate( 0 )');
          iconDropdown.css('transition', 'transform 150ms ease');
        }
      });
    },
    buyExtendSuccess(e) {
      if (e.current_course_schedule_id) {
        this.current_course_schedule_id = e.current_course_schedule_id;
      }
      this.$emit('buy-extend-success', e.extend, e.options);
      const minute = e ? e['minutes_required'] : 0;
      if (minute) {
        this.courseSchedule.end_datetime_string = new Date(new Date(this.courseSchedule.end_datetime_string).getTime() + minute * 60 * 1000);
      }

      this.disabledOptionWhenBuySuccess(e);
    },
    // removeCheckedWhenClickAgain() {
    //   let radioButtons = $("input[type='radio'][name='extend']").remove('checked');
    //
    //   const self = this;
    //   radioButtons.click(function () {
    //
    //     let val = $(this).val();
    //     if (val === self.checkedRadioValue) {
    //       $(this).prop("checked", false);
    //       self.checkedRadioValue = null;
    //     } else {
    //       self.checkedRadioValue = val;
    //     }
    //   });
    // },
    formatPrice(value) {
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    showOptionExtensionPC() {
      $(".dropdown-option-app").hover(function () {
        $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow-right').hide();
        $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow').show();
        $('#dropExtensionRequest').show();
        $('.extension-request__dropdown-option').mouseleave(() => {
          $('#dropExtensionRequest').hide();
          $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow-right').show();
          $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow').hide();
        })
      });
    },
    showOptionExtension() {
      $('#dropExtensionRequest').slideToggle(() => {
        if ($("#dropExtensionRequest").is(":visible")) {
          const height = document.querySelector('#dropExtensionRequest').offsetHeight;
          $('.join-course-block__body__right').css('height', `calc(100vh - ${height}px)`);
          $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow-right').hide();
          $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow').show();
        } else {
          $('.join-course-block__body__right').css('height', `auto`);
          $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow-right').show();
          $('.extension-request__dropdown-option__btn-dropdown-toggle__icon-dropdown-arrow').hide();
        }
      });

    },
    disabledOptionWhenBuySuccess(e) {
      // disable option
      let optionPurchased = e.options ?? [];
      optionPurchased = optionPurchased.map(el => el.optional_extra_id);
      this.option_extra.forEach(el => {
        if (!el.purchased) {
          el['purchased'] = optionPurchased.includes(el['optional_extra_id']);
        }
      });
      // disable extension


      // refresh btn `購入手続きへ`
      this.handleBtnPurchase();
    },
    handleChecked() {
      console.log(this.option_extra)
    },
    getExtendOption() {
      const extendId = $('input[name=extend]:checked:not(:disabled)').val();
      let price = 0;
      let extend = null;
      const options = [];

      if (new Date(this.courseSchedule.end_datetime_string).getTime() - new Date().getTime() < 5 * 60 * 1000) {
        return {extend, options, price};
      }

      this.option_extra.forEach(el => {
        if (el['checked'] && !el['purchased']) {
          price += +el['price'];
          options.push(el);
        }
      });

      extend = this.extend_course.find(el => el.course_id === +extendId);
      if (extend) {
        price += +extend.price;
      }

      return {extend, options, price};
    },
    handleBtnPurchase() {
      const {extend, options, price} = this.getExtendOption();
      this.disablePurchase = !price;
    },
    openBuyExtend() {
      const {extend, options, price} = this.getExtendOption();

      if (!price) return;

      const gift = {
        gift_id: 'EXTEND',
        extend: extend,
        options: options,
        price: price,
        current_course_schedule_id: this.current_course_schedule_id,
        end_datetime_string: this.courseSchedule.end_datetime_string
      };

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
    }
  }
}
</script>
<style lang="scss">
#optionExtend {
  display: none;
}

.extension-request__price__option .checkmark-purchase:after {
  content: unset !important;
}

.checkmark-purchase {
  background-color: #95a59e !important;
  border: unset !important;
}


.extension-request {
  &__title {
    img {
      margin-bottom: 4px;
    }
  }
}

.content-option-extend {
  width: 95%;
}

.checkbox-option {
  width: 5%;
  margin-right: 5px;
}

.checkbox-option input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

.checkbox-option .checkmark {
  position: absolute;
  top: 46%;
  left: 12px;
  height: 15px;
  width: 15px;
  background-color: transparent;
  border-radius: 3px;
  transform: translateY(-50%);
  cursor: pointer;
  border: 0.820669px solid #4E5768;
}

.checkbox-option input:checked ~ .checkmark {
  background-color: #46CB90;
  border: unset;
}

.checkbox-option .checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.checkbox-option input:checked ~ .checkmark:after {
  display: block;
}

.checkbox-option .checkmark:after {
  left: 5px;
  top: 1px;
  width: 5px;
  height: 11px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
