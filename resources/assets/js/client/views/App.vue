<template lang="pug">
v-app

	HeightGift(v-if='isGiftActive')
	//- Header(v-if="$route.name !== 'home'")
	Header(:class="'header-'+ $route.name.replace('.', '-')")

	.error-message(v-if="$root.errorCode == 429")
		|С вашего IP поступает слишком много запросов! Обновите страницу через несколько минут.
	.error-message(v-if="$root.errorCode == true")
		|Ошибка соединения с сетью или плохое соединение.
	
	main.main(
		role="main" 
		:class="'main-'+ $route.name.replace('.', '-')"
	)
		// Breadcrumbs(v-if=`$route.name !== 'home'`)
		//- transition(name="fade")
		.content-wrapper
			//- transition(name='fade')
			router-view
			Loader(v-show='this.$store.state.loading')

		Voply(v-if="$route.name !== 'home'")
		.support-wrapper
			button.show-support(@click="supportVisibleChange(true)")
				span.wrench
			support(v-if="supportvisible" @close="supportVisibleChange()")
		.new-bid-md
			router-link(
				v-if="$root.isAuth && $route.name == 'bids.list'"
				:to="{name:'new.bid', params:{}}"
				class='btn btn-danger btn-newbid'
			) Добавить объявление

	b-modal#modalMsg(
		modal-class='modal-msg'
		:size='$store.state.modalMsg.size'
		v-model='$store.state.modalMsg.toggle'
		ref='modalMsg'
	)
		template(slot='modal-title')
			.text-center.py-5
				logoheader
			hr
		div(v-html='$store.state.modalMsg.content')
		.text-center.mt-5(v-if='$store.state.modalMsg.btns')
			b-button(
				v-for='(btn, ind) in $store.state.modalMsg.btns'
				:key='ind'
				variant='outline-primary'
				size='lg'
				@click.stop='btn.action()'
			)
				.px-5 {{btn.text}}
		div(slot='modal-footer')

	Footer

	v-snackbar(
		v-model="$store.state.snackbar.toggle"
		:color="$store.state.snackbar.color"
		:timeout="6000"
		top=true
		right=true
	) {{$store.state.snackbar.text}}
		v-btn(
			dark
			flat
			@click="$store.commit('setSnackbar', {toggle: false})"
		) Закрыть

</template>

<script>
import Loader from "./GeneralComponents/components/Loader";
import Breadcrumbs from "./GeneralComponents/components/Breadcrumbs";
import Header from "./GeneralComponents/components/Header";
import Voply from "./GeneralComponents/components/Voply";
import HeightGift from "./GeneralComponents/components/HeightGift";
import Footer from "./GeneralComponents/components/Footer";
import support from "./GeneralComponents/components/techform";
export default {
  components: {
    Loader,
    Breadcrumbs,
    Header,
    Voply,
    HeightGift,
    Footer,
    support
  },
  name: "APP",
  data() {
    return {
      pageTitle: "Main page title",
      breadcrumbs: [],
      supportvisible: false
    };
  },
  computed: {
    isGiftActive() {
      return (
        this.$root.isAuth &&
        this.$store.state.profile.active_payment_subscriptions.status == "pause"
      );
    }
  },
  methods: {
    supportVisibleChange(newVal = false) {
      let body = document.body;

      if (newVal) {
        this.supportvisible = newVal;
        body.classList.add("body-overflow");
      } else {
        this.supportvisible = false;
        body.classList.remove("body-overflow");
      }
    }
  },
  mounted() {
    if (window.isDevMode) {
      console.log("%cRoute: %O", "color:gray;", this.$route);
    }
  }
};
</script>
<style>
.body-overflow {
  height: 100vh;
  overflow-y: hidden;
}
</style>

<style lang="scss" scope>
@import "../../../sass/base.scss";

body {
  color: #000;
}
.error-message {
  font-size: 14px;
  font-family: Tahoma;
  background: #fb5b32;
  color: #fff;
  padding: 10px;
  position: fixed;
  width: 100%;
  left: 0;
  top: 0;
  z-index: 9999;
}
.new-bid-md {
  display: none;
  text-align: center;
  position: fixed;
  width: 100%;
  z-index: 4;
  bottom: 3rem;

  @include media-breakpoint-down(md) {
    display: block;
  }

  .btn-newbid {
    height: 4.2rem;
    line-height: 4.2rem;
    padding: 0 calc(#{$grid-gutter-width} / 2);
    font-size: 1.9rem;

    @include media-breakpoint-down(sm) {
    }
  }
}
.support-wrapper {
  position: fixed;
  bottom: 1.5rem;
  z-index: 5;
  @include media-breakpoint-down(md) {
    bottom: 7rem;
  }
  button.show-support {
    outline: none !important;
    width: 65px;
    height: 65px;
    background-color: transparent;
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAABUCAYAAAAGV/BPAAAABHNCSVQICAgIfAhkiAAABSZJREFUeJztnM9PK1UUx78z08LzRYVYqnkrDJIYcCP+yIsmJizUxITEhYsa44oNC1ZudK9/wFu5ApYmhgVRF8ZFE00eTdDXIBFinyEoNAZBnq1AETvM3Ouincf09s50ZtprO+35JJPptMPccz89PdMpmQMQRJzR+nSsduGdOpCqSfsdt5dF+4mNJL3Tk9UCPI4L3OOxbNuTTk1cC7ju5JgqkElttfalE5N1S3y4HB4ePpNKpd4xDOM1Xdef1TTt6Q6M9X/xO+f8V9u2756enn45Nja2hZpQ9wJ0sFZ74QjVARgAEqurqyOmaX7K+wjLsj7L5/O3ACTr89TrizN/5XITAJKbm5vjjLGdbgtRAWOseHBwMF2XnKiLdn9q1cpdW1tLMcZ+67YIxfyZy+XGXZLdmewpKopcUbJhWdZXhmG8EeF4sYIx9qNhGK8CYABstKjJesRx3HL1crn83iDIBQBd12cqlcoHCFiHw2awO3udAQzbtu/puv5chHhjCef8ga7r4wAs1DKZ19eAkMVRMthd2PVsNntrkOQCgKZpY4VC4Xk01l9psrZbIrSpqamXIx4j1qTT6ZcQ4CQXRrDsgkJPJpNjUYOMM0NDQ+MQLq7qLzXIjprBzoE0TdOG2zhGbDEMYxQt5ALhBTdlMWOsl39bUAbnvKVcIPpJzlkPrOA6vnKB9krEQFNPrJaXyW1/i4j49/2Gpw/K4PZQlsFEQEiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYkiwYtq+CWbAb+NqSZQbER8KHR0dRTqdfrezIcUD27bPg+wXVLB4R6MGQNvf3/8wmUy+ECG+2FOtVg/R2IxDShDBYksuDYC2vb394sjIyEfRQ4w3xWJxy7UpdqMKhburVBLAjcXFxZRt28VuN9DpFoyxBwBSAB4HcBPAMK57+IQ6J4nNj4YA3Ly4uOirtl1hOTo6+gTAEwAeqwse8hLcyrb7FlEDgL67u3t7cnLyuzDvUj9hmuZPw8PDr6PWTuYKtcZIztJUKvxqcEPjDQDa7OxsYmJiYkVR7D0PY+yvO3fuvI/rHj2ROwHKSsMj5+fnH3f749ktLMsqrqysvALgSdTKQ1v1t+nEtrGxMd3tSXaLUqn0+cLCwjSAp1A7uY0AeBTADTS2W2wSLDMubd11dXX1RSKReDPoOxRnbNs+rFar++Vy+ftcLvd1JpP5Gdd11hIe+7b1SniM0VB/j4+P3wojl3Neuby8LJydne2cnJzcLxQKhUwmsyMO3oO4a6kjzenw56xt13bLGuyVwQ3Za1nWt4Zh3PaLzDTN3XK5fDefz38zNzd3z2PgXhUs9g12LzLBbvGhBEvLA+f8n4ZoOP/XNM1fKpXK1t7e3vrS0tIPy8vLf3sEGBfJgHcGi4vtet29fxNeJaKBbDY7PTMz83apVCqur6/fn5+f/wPN3T5kYsWAxYn0GmK87q9jbsGBL40DZbCweHW7k8kVC3/cJbsfi/tKCZLBMlkMwbLXqz71qlxALljcDlzuRMEc1+JkmSju4xVQHOsvIE+CVmtfWmWwVyEPItgrmF6X7OAXc+A5eAkWD+CUBFGw7CTWL1LDvOaJ17Wz+N8L8TnZoHEWK9KxuP1+nJAJlX1z8Nv2em5gCPJ7cFgGWqhIGIGyfUkmQRBEdP4DZZlMM/zMje0AAAAASUVORK5CYII=");
    background-position: center;
    background-size: contain;
    position: relative;
    z-index: 5;
    display: flex;
    justify-content: center;
    align-items: center;
    .wrench {
      background-color: transparent;
      background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACIAAAAiCAYAAAA6RwvCAAAABHNCSVQICAgIfAhkiAAAAixJREFUWIW9mNt12kAQhr8Reg8dRKnAuAJbxw6vkSuI6GBdQZIKvKkAXIFPXjE+IhVY6YAS8Lvx5EGIi637hf8FGLGz35ndnf1BKJJZBAgPAKjGIDHoPfbrsnBcA0kxyHyEyBLk01FcWcJggvVXpwEphlnDm48dx6cBKYUZnHdRGafSt+w4RvUS9OUoLgxhM20LkaSqIzMfIc7zh7i+nbddomoVKZM4YdsUDmYRYOajijNeZse14vgiEOEBnKgizPdsDjlrDwLbTVcCYyIPkeznovX2Wg7Iv1IYE3mw+VGQp3UvcbdJznYw6kSYuZ98di5QDZFNybJJaxAH1dlxToaI87w9pjZ3OQ6lfMZEwzYgydrePi5BLtokSi5F18f66ybDk82qbviha9aVyAheo6aVSUCsv8ps4SeE2XdWO45RdwT6tyMYr9awzGhyp4Tbjplu1tQYeSDfSjPXtAn1G5GJhshmSXrkO4Jp1hF7gGnemjuGaW4DrL9GB0Glk5Y2SfOUaxfa+ZG6x150mgfT+tYE8j1tnlQm2Kujq6UbkB1Mho2sCNONVYRtQ5RJ5e+LTjGLnfHuDgTAXs3qwRBiHn8mb/uQeQoRrf4zQwdfuq1IqmTtf2dPyg1314Jysw++Bv1UJNXtYsZ7w313LQfPNYHTX/1UZD9pCNwfxcwiSF4P+4mz6rciqQodoL6grtdvRXZzuQHon2wIAqy/Pk1FUiV//FyCeigxuDb1uP8BuATiOUFMohwAAAAASUVORK5CYII=");
      background-position: center;
      background-size: contain;
      width: 25px;
      height: 25px;
      cursor: pointer;
      margin-left: 5px;
      margin-bottom: 8px;
    }
  }
}
</style>
