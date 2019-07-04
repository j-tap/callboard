<template lang="pug">
.card.profile-card.mb-5
	.card-body
		v-snackbar(
		v-model="snackbar.toggle"
		:color="snackbar.color"
		:timeout="snackbar.timeout"
		) {{snackbar.text}}
		.wallet(v-if='profile' :class="{'modal-wallet': modal}")
			form.form-wallet(
				@submit.prevent='validateBeforeSubmit'
			)
				h3.form--title Мой кошелёк
					//- span.centralized(v-if="!modal")
						router-link(:to="{name: 'lk.wallet.history'}") История платежей
				span.balance-wrapper
					feather(type="credit-card")
					span.balance {{profile.profile.ballance.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ")}} руб.
				.form-group.price
						span.input-title Введите сумму оплаты
						.d-flex
							v-text-field(
								v-model='form.price'
								solo
								:light='true'
								placeholder='Сумма'
								data-vv-as='сумма'
								data-vv-name='price'
								v-validate=`'required|decimal:2'`
								:error-messages=`err.price ? err.price : errors.collect('price')`
							)
							.form-price-sign &#8381;
				span.payment-type-title Выберите способ оплаты
				hr.line
				.payments-section
					.form-group.payment-element
						label.payment-element-wrapper
							input.payment-element-value(
								name="paymenttype"
								v-model="form.paymenttype"
								type="radio"
								value="bank-transaction"
							)
							span.payment-element-title
								i.payment-element-icon.i
									icon-bank
								i.payment-element-text Банковский перевод
				hr.line
				.v-text-field.d-flex.justify-content-between
					.text-center
						b-button(
							variant='primary' 
							type='submit' 
							:disabled='loading'
						) 
							span.px-3 
								span Выписать счёт
								b-spinner(v-if='loading' label='Загрузка...')
</template>
<script>
import mixin from "../../../mixins/global";
import { Validator } from "vee-validate";
import vue from "vue";

vue.component("icon-bank", {
  template: `
	<svg xmlns="http://www.w3.org/2000/svg" width="28.018" height="28.004" viewBox="0 0 28.018 28.004">
		<defs>
		</defs>
		<g id="bank-building" transform="translate(0 -.012)">
				<g id="Layer_1_78_" transform="translate(0 .012)">
						<g id="Group_1032" data-name="Group 1032">
								<path id="Path_50" d="M26.732 42.718H1.273a1.273 1.273 0 0 0 0 2.547h25.459a1.273 1.273 0 0 0 0-2.547z" style="fill:#85db4b" data-name="Path 50" transform="translate(0 -17.26)"/>
								<path id="Path_51" d="M3.942 28.54a1.274 1.274 0 0 0 0 2.547h22.277a1.274 1.274 0 0 0 0-2.547H25.9V17.083h.318a.636.636 0 0 0 0-1.272H3.942a.636.636 0 0 0 0 1.272h.318V28.54h-.318zm19.413-11.457V28.54h-3.819V17.083zm-6.365 0V28.54h-3.819V17.083zm-10.183 0h3.819V28.54h-3.82z" style="fill:#85db4b" data-name="Path 51" transform="translate(-1.078 -6.393)"/>
								<path id="Path_52" d="M1.273 8.285h25.471a1.273 1.273 0 0 0 .413-2.478L14.526.123a1.276 1.276 0 0 0-1.044 0L.751 5.851a1.273 1.273 0 0 0 .522 2.434z" style="fill:#85db4b" data-name="Path 52" transform="translate(0 -.012)"/>
						</g>
				</g>
		</g>
</svg>`
});

export default {
  props: {
    profile: Object,
    modal: {
      type: Boolean,
      default: false
    },
    paymentData: {
      type: Object,
      default: function() {
        return {
          summ: null,
          bidId: null
        };
      }
    }
  },
  mixins: {
    mixin
  },
  data() {
    return {
      snackbar: {
        toggle: false,
        timeout: 3000,
        color: "",
        text: ""
      },
      err: {},
      formData: new FormData(),
      form: {
        price: this.$route.params.cost || null,
        paymenttype: "bank-transaction"
      },
      loading: false,
      paylink: null
    };
  },
  mounted() {},
  computed: {
    ballance() {
      return this.profile.profile.ballance || 0;
    }
  },
  watch: {
    profile() {
      if (this.modal) {
        this.form.price = Math.abs(this.ballance - this.paymentData.summ);
      }
    }
  },
  methods: {
    formatPrice() {
      const price = parseInt(this.form.price);
      if (price >= 0) {
        if (price == 0) {
          this.form.price = "";
        } else {
          this.form.price = this.priceFormat(
            this.form.price.replace(/\s/g, "")
          );
        }
      }
    },
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.err = {};

          for (let key in this.form) {
            this.formData.set(key, this.form[key]);
          }

          this.addMoney();
          this.goPay();
        }
      });
    },
    addMoney() {
      if (this.modal) {
        vue.set(this.form, "bidId", this.paymentData.bidId);
      }
      // if (
      // 	Math.abs(this.profile.profile.ballance - this.paymentData.summ) >
      // 	+this.form.price
      // ) {
      // 	let text =
      // 		"Минимальная сумма оплаты " +
      // 		Math.abs(this.profile.profile.ballance - this.paymentData.summ) +
      // 		" руб.";
      // 	this.snackbar.color = "error"
      // 	this.snackbar.text = text
      // 	this.snackbar.toggle = true

      // 	return false
      // }
    },
    goPay() {
      this.$parent.getBillPay({
        price: parseInt(this.form.price.replace(/ /g, ""), 10)
      });
    }
  }
};
</script>
<style scoped>
.centralized {
  float: right;
  margin-top: 0.7rem;
  font-size: 15px;
}
.form-price-sign {
  color: #c1c1c1;
  font-size: 3rem;
  vertical-align: middle;
  padding-left: 0.5rem;
  font-weight: 300;
  line-height: 3.5rem;
  width: 0.1%;
}
.form--title {
  font-family: Roboto;
  font-size: 20px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 2;
  letter-spacing: normal;
  text-align: left;
  color: #707070;
  border-bottom: 2px dotted #0a0a0a99;
}
.balance-wrapper {
  display: flex;
  align-items: center;
  margin-bottom: 54px;
}
.balance {
  font-family: Roboto;
  font-size: 20px;
  font-weight: 500;
  text-align: left;
  color: #010101;
  margin-left: 15px;
}
.mr-wrapper {
  margin: 0 auto;
  display: block;
  max-width: 40rem;
  padding-bottom: 10px;
}
.form-group {
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 15px;
  max-width: 275px;
  width: 100%;
}
.form-group.price {
  margin-bottom: 35px;
}
.form-group.price .v-iinput {
  width: 100%;
}
.line {
  border-bottom: 2px dotted #dadada;
  border-top: none;
  margin: 0;
  margin-bottom: 35px;
  margin-left: 5px;
  margin-right: 5px;
}
.form-wallet >>> .v-input--is-focused .v-input__slot {
  border-radius: 10px;
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16) !important;
  border-color: #cfcccc !important;
  background-color: #ffffff;
}
.input-title,
.payment-type-title {
  font-family: Roboto;
  font-size: 18px;
  text-align: center;
  color: #cfcccc;
  display: block;
}
.payments-section {
  margin-bottom: 35px;
}
.payment-type-title {
  margin-bottom: 3px;
}
.form-group.payment-element {
  margin-bottom: 2rem;
}
.payment-element-wrapper {
  display: flex;
  align-items: center;
  position: relative;
}
.payment-element-value {
  width: 17px;
  height: 17px;
  position: relative;
  z-index: -1;
}
.payment-element-value:checked + .payment-element-title::before {
  border-radius: 5px;
  border: solid 4px #0071bc;
  width: 17px;
  height: 17px;
  content: "";
  transition: all 0.1s 0.1s;
}
.payment-element-title::before {
  content: "";
  transition: all 0.1s 0.1s;
  width: 17px;
  height: 17px;
  position: absolute;
  border-radius: 5px;
  border: solid 1px #e6e9ec;
  left: 0px;
  top: 17px;
}

.payment-element-title {
  padding: 1rem;
  border: 1px solid #e6e9ec;
  border-radius: 10px;
  width: 100%;
  margin-left: 15px;
}

.payment-element-wrapper:hover > .payment-element-title,
.payment-element-value:checked + .payment-element-title {
  box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.16);
  transition: all 0.1s 0.1s;
}
.payment-element-icon {
  margin-right: 20px;
}
.payment-element-text {
  font-family: Roboto;
  font-size: 16px;
  text-align: left;
  color: #010101;
  font-style: normal;
}
.form-wallet >>> .text-center .btn {
  font-family: Roboto;
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 2;
  letter-spacing: normal;
  color: #0071bc;
  background-color: #fff;
  max-width: 255px;
  width: 100%;
}
.form-wallet {
  padding-bottom: 2rem;
}
</style>
