<template>
  <div>
    <div class="modal fade" id="explain-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog explain-modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            セキュリティコードとは？
            <button type="button" class="close close-explain-modal" data-dismiss="modal" aria-label="Close">
              <img src="/assets/img/icons/exit.svg" alt="" width="20" height="20">
            </button>
          </div>
          <div class="modal-body">
            <p style="font-size: 14px;">セキュリティコードは、クレジットカード裏面の署名欄に印字してある7桁の数字のうち、右側の3桁です。</p>
            <p style="font-size: 14px;">インターネットショッピングの際、セキュリティーを高めるために入力する場合があります。</p>
            <p style="font-size: 14px;">
              お持ちのカードにセキュリティコードの印字がない場合や、かすれて見えなくなっている場合は、お手もとにカードをご用意のうえ、カード裏面に記載のカード発行会社までご連絡ください。</p>
          </div>
        </div>
      </div>
    </div>
    <div id="edit-card" class="modal bd-example-modal-lg">
      <div class="modal-dialog" role="document">
        <div class="modal-content payment-info-wrapper">
          <div class="header-popup">
            <div class="title">クレジットカード情報変更</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <img src="/assets/img/icons/exit.svg" alt="">
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <input type="hidden" value="" name="type">
              <div class="payment-edit-content d-flex">
                <div class="right">
                  <div class="right-payment-content">
                    <div class="title">
                      <!--                    {{ trans('labels.order.card_info') }}-->
                      クレジットカード情報
                    </div>
                    <div class="d-flex list-bank">
                      <img src="/assets/img/clients/cards/visa.svg" alt="" class="visa-icon">
                      <img src="/assets/img/clients/cards/master_card.svg" alt="" class="master-card-icon">
                      <!--                      <img src="/assets/img/clients/cards/jcb.svg" alt="" class="jcb-icon">-->
                      <img src="/assets/img/clients/cards/american-express.svg" alt="" class="express-icon">
                      <!--                      <img src="/assets/img/clients/cards/dinner.svg" alt="" class="dc-icon">-->
                    </div>
                    <div class="bank-text">
                      ※VISA、Master、American Expressがご利用できます。
                    </div>
                    <div class="payment-content">
                      <div class="title">
                        カード番号
                      </div>
                      <div class="account-number">
                        <input
                            value=""
                            type="text"
                            class="form-control"
                            v-model="cardInfo.number"
                            name="number"
                            id="account-number"
                            @keydown="changeFormat"
                            maxlength="19"
                        >
                        <span class="text-danger" v-if="errors.filter(item => item.key === 'number').length > 0">
                        {{ errors.filter(item => item.key === 'number')[0].error }}
                      </span>
                        <div class="text-danger" v-if="errorCard.filter(item => item.error === 'number').length > 0">
                          無効なクレジットカード番号です
                        </div>
                        <a class="suggest">例）1234567890123456</a>
                      </div>
                      <div class="title">有効期限</div>
                      <div class="expired-date">
                        <div class="d-flex expired-date-content">
                          <div class="expired-date-month">
                            <input v-model="cardInfo.exp_month" type="text" name="exp_month" maxlength="2"
                                   class="form-control">
                          </div>
                          <div class="expired-date-year">
                            <input v-model="cardInfo.exp_year" type="text" name="exp_year" maxlength="4"
                                   class="form-control">
                          </div>
                        </div>
                        <div class="text-danger"
                             v-if="(errorsExpMonth.length > 0 || errorsExpYear.length> 0)
                            && (errorsExpMonth.filter(item => item.error === 'required').length > 0 ||
                              errorsExpYear.filter(item => item.error === 'required').length > 0)">
                          有効期限は、必ず指定してください。
                        </div>
                        <div class="text-danger" v-else-if="errorsExpMonth.length > 0">
                          {{ errorsExpMonth[0].error }}
                        </div>
                        <div class="text-danger" v-else-if="errorsExpYear.length > 0">
                          {{ errorsExpYear[0].error }}
                        </div>
                        <!--                      @if ($errors->has('exp_year'))-->
                        <!--                      <span class="text-danger">{{ $errors->first('exp_year') }}</span>-->
                        <!--                      <br>-->
                        <!--                      @endif-->
                        <!--                      @if ($errors->has('error_card') && ($errors->first('error_card') == 'exp_month' || $errors->first('error_card') == 'exp_year'))-->
                        <div class="text-danger"
                             v-if="errorCard.filter(item => ['exp_month', 'exp_year'].includes(item.error)).length > 0">
                          カード有効期限が不正です
                        </div>
                        <!--                      @endif-->
                        <span class="suggest">※カードに刻印されている表記のとおりにご選択ください。</span>
                      </div>
                      <div class="title">カード名義人</div>
                      <div class="owner-bank">
                        <input v-model="cardInfo.owner_bank" type="text" name="owner_bank" class="form-control">
                        <span class="text-danger" v-if="errors.filter(item => item.key === 'owner_bank').length > 0">
                        {{ errors.filter(item => item.key === 'owner_bank')[0].error }}
                      </span>
                        <!--                      @if ($errors->has('owner_bank'))-->
                        <!--                      <span class="text-danger">{{ $errors->first('owner_bank') }}</span>-->
                        <!--                      <br>-->
                        <!--                      @endif-->
                        <div class="text-danger"
                             v-if="errorCard.filter(item => item.error === 'owner_bank').length > 0">
                          入力されたクレジットカード情報が一致しません。
                        </div>
                        <span class="suggest">※カードに刻印されている表記のとおりにご選択ください。</span>
                      </div>
                    </div>
                    <div class="title">セキュリティコード</div>
                    <div class="secret-code d-flex align-items-center">
                      <input v-model="cardInfo.cvc" type="text" name="cvc" class="form-control" maxlength="4">
                      <a href="javascript:;" class="fs-14" data-toggle="modal" data-target="#explain-modal">
                        セキュリティコードとは？
                      </a>
                    </div>
                    <span class="text-danger" v-if="errors.filter(item => item.key === 'cvc').length > 0">
                    {{ errors.filter(item => item.key === 'cvc')[0].error }}
                  </span>
                    <div class="text-danger" v-if="errorCard.filter(item => item.error === 'cvc').length > 0">
                      CVCが不正です。
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer confirm d-flex justify-content-center edit-card-footer">
            <button type="button" class="btn back" @click="closeModal">戻る</button>
            <button class="btn fs-14 button-confirm" @click="submit">確認する</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cardInfo: {
        number: "",
        exp_month: "",
        exp_year: "",
        owner_bank: "",
        cvc: ""
      },
      errors: []
    }
  },
  computed: {
    errorsExpMonth() {
      return this.errors.filter(item => item.key === 'exp_month');
    },
    errorsExpYear() {
      return this.errors.filter(item => item.key === 'exp_year');
    },
    errorCard() {
      return this.errors.filter(item => item.key === 'error_card');
    }
  },
  methods: {
    changeFormat(event) {
      if (!(event.keyCode == 8 // backspace
          || event.keyCode == 46 // delete
          || event.keyCode >= 35 && event.keyCode <= 40 // arrow keys/home/end
          || event.keyCode >= 48 && event.keyCode <= 57 // numbers on keyboard
          || event.keyCode >= 96 && event.keyCode <= 105) // number on keypad
      ) {
        event.preventDefault();
      }

      let val = event.target.value;
      let newval = '';
      val = val.replace(/\s/g, ''); // iterate to letter-spacing after every 4 digits

      for (let i = 0; i < val.length; i++) {
        if (i % 4 === 0 && i > 0) newval = newval.concat(' ');
        newval = newval.concat(val[i]);
      }

      this.cardInfo.number = newval;
    },
    closeModal() {
      let self = this;
      self.errors = [];
      $('#edit-card').modal('hide');
      self.cardInfo = {
        number: "",
        exp_month: "",
        exp_year: "",
        owner_bank: "",
        cvc: ""
      }
    },
    submit() {
      let self = this;
      self.errors = [];
      $.ajax({
        beforeSend: () => {
          $('#loading-overlay').show();
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "/orders/edit",
        data: this.cardInfo,
      })
          .done((res) => {
            self.errors = [];
            $('#loading-overlay').hide();
            $('#edit-card').modal('hide');
            self.cardInfo = {
              number: "",
              exp_month: "",
              exp_year: "",
              owner_bank: "",
              cvc: ""
            }
            localStorage.setItem('CARD-CHANGED', true);
            self.$emit('edit-success');
          })
          .catch(function (error) {
            self.errors = error.responseJSON.data.errors;
            $('#loading-overlay').hide();
          });
    }
  }
}
</script>

<style scoped lang="scss">
.list-bank img:last-child {
  margin-left: 10px;
}

@media only screen and (max-width: 767px) {
  .payment-info-wrapper {
    .edit-card-footer {
      padding-left: 0 !important;
      padding-right: 0 !important;
    }

    .payment-edit-content {
      .suggest {
        font-size: 12px !important;
      }

      .expired-date-content {
        max-width: 100% !important;
      }

      input {
        max-width: 100% !important;
        height: 41px;
      }

      .payment-content {
        max-width: 100% !important;
      }
    }

    .right {
      .secret-code {

        input {
          max-width: 127px !important;
        }
      }

      .bank-text {
        margin-top: 5px;
        padding-bottom: 5px !important;
        margin-bottom: 10px !important;
      }

      .title {
        font-weight: bold !important;
      }

      .list-bank {
        height: 22px !important;

        img {
          height: 100% !important;
        }
      }

      .payment-content {
        .expired-date {
          .expired-date-month {
            max-width: 100% !important;
            margin-right: 14px !important;
          }

          .expired-date-year {
            max-width: 100% !important;
          }
        }

        .account-number, .expired-date, .owner-bank {
          margin-bottom: 8px !important;
        }
      }

      .right-payment-content {
        padding: 10px !important;
      }
    }
  }
}

#explain-modal {
  z-index: 2000;
}

.close-explain-modal {
  padding: 13.5px 1rem;
}

.explain-modal-dialog {
  margin: 28px auto;
}

.payment-info-wrapper {
  padding: 10px 17px 5px 17px;
  margin-top: 5px;

  .header-popup {
    .title {
    }
  }

  .modal-body {
    padding: 10px 0;
  }

  .modal-footer {
    margin-top: 10px;
  }

  .header-title {
    text-align: center;
    font-weight: 600;
    font-size: 16px;
    color: #2A3242;
    margin-bottom: 14px;
  }

  .content {
    max-width: 885px;
    margin: auto;
    display: flex;
  }

  .left {
    max-width: 365px;
    width: 100%;
    margin-right: 24px;
    border-radius: 3.90792px;

    .total-payment {
      padding: 22px 25px;
      background: #F9FAFB;

      .title {
        color: #2A3242;
        font-size: 14px;
        line-height: 14px;
      }

      .time {
        margin-top: 10px;

        img {
          margin-right: 9px;
        }

        div {
          font-size: 12px;
          color: #2A3242;
        }

        :last-child {
          margin-left: 25px;
        }
      }
    }
  }

  .right {
    width: 100%;

    .list-bank {
      height: 22px;
      align-items: center;
      margin-top: 8px;
      margin-bottom: 6px;

      .master-card-icon {
        width: 30px;
        height: 22px;
        margin: auto 0px auto 2px;
      }

      .express-icon {
        height: 22px;
        width: 22px;
        margin: auto 7px auto 0;
        margin-left: 10px;
      }

      .dc-icon {
        width: 28px;
        height: 22px;
        margin: auto 0;
      }

      .jcb-icon {
        width: 27px;
        height: 22px;
        margin: auto 14px auto 17px;
      }

      img {
        margin-right: 7px;
        height: 22px;
        width: 54px;
      }
    }

    .right-payment-content {
      padding: 20px 25px;
      background: #F9FAFB;
      border: 1.04708px solid #E6E6E6;
      box-sizing: border-box;
      border-radius: 5.2354px;
    }

    .title {
      font-weight: 600;
      color: #2A3242;
      font-size: 14px;
      //line-height: 24px;
    }

    .bank-text {
      font-size: 10px;
      color: #000000;
      padding-bottom: 12px;
      border-bottom: 1.04708px solid #F1F1F1;
      margin-bottom: 12px;
      line-height: 10px;
    }

    .payment-content {
      max-width: 306px;
      padding-right: 28px;

      .account-number {
        margin-bottom: 12px;
      }

      .expired-date {
        margin-bottom: 12px;

        .expired-date-month {
          max-width: 127px;
        }

        .expired-date-year {
          max-width: 127px;
          margin-right: 0;
          margin-left: auto;
        }
      }

      .owner-bank {
        margin-bottom: 12px;
      }
    }

    .secret-code {
      max-width: 306px;

      input {
        max-width: 127px;
      }

      a {
        margin-left: auto;
        margin-right: 0;
        color: #1AADEC;
      }
    }

    .change {
      text-align: center;
      margin-top: 18px;

      button, .change-button {
        padding: 10px 46px;
        background: #F9FAFB;
        font-weight: 700;
        border: 1px solid #46CB90;
        box-sizing: border-box;
        border-radius: 5px;
        color: #46CB90;
      }
    }

    input {
      background: #EDEDED;
      border-radius: 5px;
      padding-left: 13px;
      margin-top: 4px;
      color: #2A3242;
      font-size: 14px;

      //:focus {
      //  border: 1px solid #DEDEDE;
      //}
    }
  }

  .confirm {
    margin-top: 25px;
    text-align: center;

    .button-cancel {
      font-weight: 700;
      font-size: 14px;
      padding: 8px 40px;
      border: 1px solid #2A3242;
      margin-right: 20px;
    }

    .button-confirm {
      font-size: 14px;
      font-weight: 700;
      padding: 8px 40px;
      background: #46CB90;
      border: 1px solid #46CB90;
      box-sizing: border-box;
      border-radius: 5px;
      color: #FFFFFF;
      width: 150px;
    }

    .back {
      border-radius: 5px;
      height: 41px;
      text-align: center;
      width: 150px;
      font-size: 14px;
      background: #FFFFFF;
      border: 1px solid rgba(78, 87, 104, 0.2);
      max-width: 168px;
    }
  }

  .text-danger {
    font-size: 12px;
  }

  .payment-edit-content {
    max-width: 498px;
    margin: auto;

    a[href^="tel"] {
      color: inherit;
      text-decoration: none;
    }

    a:hover {
      text-decoration: none;
    }

    .suggest {
      font-size: 10px;
      margin-top: 4px;
      color: #ABABAB;
    }

    .payment-content {
      max-width: 328px;
      padding-right: 0;
    }

    .expired-date-content {
      max-width: 278px;
    }

    input {
      background: #FFFFFF;
      max-width: 278px;

      &:focus {
        border: 1px solid #4BBD8B;
        box-shadow: unset;
      }
    }
  }
}
</style>
