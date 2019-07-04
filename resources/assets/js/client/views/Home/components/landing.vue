<template>
  <section class="landing-section">
    <div class="container position-relative landing-container">
      <div class="left-side">
        <div class="landing-title">
          <router-link :to="{name: 'bids.list'}">
			<img alt="TamTem" class="landing-logo" src="/images/biglogo.svg">
		  </router-link>
          <h1>
            - Сервис объявлений
            <br>для Вашего бизнеса
          </h1>
        </div>
        <div class="subtitle-info">
          <p class="subtitle-text">
            Сайт свежих объявлений о закупке и продаже товаров (в том числе б/у)
            <br>или услуг от компаний и юридических лиц.
          </p>
        </div>
        <div class="info-list">
          <ul class="list-items">
            <li class="list-element">
              <span class="colored-text text--blue">Сервис объявлений</span> поможет продать ненужное оборудование или найти дополнительные каналы сбыта
            </li>
            <li class="list-element">
              <span class="colored-text text--blue">Создайте объявление</span> закупки и его увидят все поставщики, которые работают с данной категорией товара или услуг
            </li>
            <li class="list-element">
              <span class="colored-text text--blue">Настройте профиль</span> и просматривайте объявления из интересующих Вас категорий
            </li>
            <li class="list-element">
              <span class="colored-text text--blue">Создайте компанию</span> и используйте все возможности для продвижения Вашего бизнеса
            </li>
          </ul>
        </div>
        <div class="ordercall-form">
          <div class="ordercall-title">
            <h3 class="ordercall-title">Есть вопросы? Мы Вам перезвоним</h3>

            <v-snackbar
              v-model="snackbar.toggle"
              :color="snackbar.color"
              :timeout="snackbar.timeout"
              :top="true"
              :right="true"
            >
              {{snackbar.text}}
              <v-btn dark flat @click="snackbar.toggle = false">Закрыть</v-btn>
            </v-snackbar>
            <form action="javascript:void(0);" v-on:submit.prevent="sendform()">
              <v-text-field
                v-on:keyup="error=null"
                class="phone-wrapper"
                v-model="phone"
                solo
                :light="true"
                placeholder="номер телефона"
                data-vv-as="Телефон"
                data-vv-name="phone"
                mask="(###) ###-##-##"
                prefix="+7"
                :errorMessages="error ? error: ''"
              />
              <input tabindex="-1" type="text" name="name" v-model="fakename" class="honeypot">
              <button class="ordercall-button" type="submit">Заказать звонок</button>
            </form>
          </div>
        </div>
      </div>
      <div class="right-side">
        <div class="right-side-item first-item">
          <h4 class="item-title">
            Самый простой способ
            <br>найти поставщика и закупщика
          </h4>
          <div class="item-image"></div>
        </div>
        <div class="right-side-item second-item">
          <h4 class="item-title">
            Проще продать тем,
            <br>кому это нужно
          </h4>
          <div class="item-image"></div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
	name: "landing",
	props: {},
	data() {
	return {
		phone: "",
		error: null,
		fakename: "",
		snackbar: {
		color: undefined,
		text: "",
		toggle: false,
		timeout: 6000
		}
	};
	},
	methods: {
	sendform() {
		if (this.fakename.length == 0) {
		if (this.phone.length != 10) {
			this.error = "Введите корректный номер";
			return false;
		} else {
			axios
			.post("/api/v1/user/callme", { phone: this.phone })
			.then(resp => {
				if (resp.data.result == true) {
				this.snackbar.color = "success";
				this.snackbar.text = resp.data.data;
				this.snackbar.toggle = true;
				this.snackbar.timeout = 6000;
				} else {
				this.snackbar.color = "error";
				this.snackbar.text = "Произошла ошибка, попробуйте позднее";
				this.snackbar.toggle = true;
				this.snackbar.timeout = 6000;
				}
			})
			.catch(err => {
				this.snackbar.color = "error";
				this.snackbar.text = "Произошла ошибка, попробуйте позднее";
				this.snackbar.toggle = true;
				this.snackbar.timeout = 6000;
			});
		}
		}
	}
	}
};
</script>
<style scoped>
.ordercall-form >>> .v-text-field__prefix {
	padding-left: 5px;
}
.landing-section {
	padding-left: 5px;
	overflow: hidden;
}
.landing-container {
	display: flex;
}
.text--blue {
	color: #0071bc;
}
.landing-logo {
	margin-bottom: 12px;
	vertical-align: middle;
}
.left-side {
	position: relative;
}

.left-side::after {
	background: url("/images/landingarrows.svg");
	background-repeat: repeat;
	width: 96px;
	height: 34px;
	content: "";
	position: absolute;
	right: -130px;
	top: 45%;
	background-repeat: round;
}
.landing-title h1 {
	font-family: Roboto;
	font-size: 30px;
	font-weight: 600;
	font-style: normal;
	font-stretch: normal;
	line-height: 1.11;
	letter-spacing: normal;
	text-align: left;
	color: #010101;
	vertical-align: middle;
	margin-left: 10px;
	display: inline;
	margin-bottom: 0;
	padding-top: 5px;
}
.subtitle-info {
	margin-top: 15px;
	height: 61px;
	margin-bottom: 16px;
}
.subtitle-text {
	margin: 0;
	font-family: "Roboto", regular;
	font-weight: normal;
	font-style: normal;
	font-stretch: normal;
	line-height: 1.19;
	letter-spacing: normal;
	text-align: left;
	color: #010101;
}
.info-list {
	border-radius: 20px;
	-webkit-backdrop-filter: blur(25px);
	backdrop-filter: blur(25px);
	box-shadow: 0.5px 3px 6px 0 rgba(0, 0, 0, 0.16);
	background-color: #ffffff;
	max-width: 615px;
}
.list-items {
	counter-reset: item;
	list-style-type: none;
	padding-bottom: 40px;
	padding-top: 40px;
}
.list-element {
	font-family: Roboto;
	font-size: 18px;
	font-weight: normal;
	font-style: normal;
	font-stretch: normal;
	line-height: 1.22;
	letter-spacing: normal;
	color: #010101;
	margin-bottom: 23px;
	padding: 33px;
	padding-bottom: 33px;
	max-width: 615px;
	padding-bottom: 10px;
	padding-top: 10px;
}

.list-element::before {
  content: counter(item, decimal);
  counter-increment: item;
  font-size: 45px;
  float: left;
  color: #0071bc;
  padding-right: 15px;
  font-family: "Roboto";
  font-weight: 300;
  width: 40px;
  text-align: center;
  line-height: 45px;
}
.ordercall-form {
	margin-top: 38px;
	max-width: 615px;
}
.ordercall-title {
	font-family: "Roboto";
	font-weight: 600;
	font-size: 17px;
	text-align: center;
	color: #0071bc;
	margin-bottom: 18px;
}

.phone-wrapper {
	width: 280px;
	height: 30px;
	color: #cfcccc;
	font-size: 16px;
	font-family: "Roboto";
	font-weight: 500;
	margin: 0 auto;
	margin-bottom: 33px;
}
.ordercall-button {
	display: block;
	width: 180px;
	height: 35px;
	border: none;
	margin: 0 auto;
	border-radius: 10px;
	-webkit-backdrop-filter: blur(25px);
	backdrop-filter: blur(25px);
	background-color: #0071bc;
	font-family: "Roboto";
	color: white;
	font-weight: normal;
}
.right-side {
	margin-left: 120px;
	padding-top: 20px;
}
.item-title {
	font-family: "Roboto";
	font-weight: initial;
	border-bottom: 2px dotted #c1c1c1;
	font-size: 18px;
	margin-left: 40px;
	display: inline-block;
}
.first-item .item-image {
	background: url("/images/landing-image-top3.png");
	width: 369px;
	height: 306px;
	background-position: center;
	background-size: 100%;
	transition: all 0.2s 0.5s;
	margin-top: 26px;
}
.second-item {
	margin-top: 78px;
}
.second-item .item-image {
	background: url("/images/landing-image-bottom3.png");
	width: 383px;
	min-height: 374px;
	background-position: center;
	background-size: 100%;
	transition: all 0.2s 0.5s;
	background-repeat: no-repeat;
}
.item-image:hover {
	-webkit-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
	transition: all 0.2s 0.5s;
}

@media (max-width: 1024px) {
	.landing-container {
	display: block;
	margin: 0 auto;
	}
	.right-side {
	display: none !important;
	}
	.left-side:after {
	display: none;
	}
	.info-list {
	margin: 0 auto;
	}
	.ordercall-form {
	margin: 0 auto;
	margin-top: 33px;
	}
}

.honeypot {
	left: -10000px;
	position: absolute;
}
</style>
