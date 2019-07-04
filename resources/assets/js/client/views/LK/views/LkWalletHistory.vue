<template lang="pug">
.card.profile-card.mb-5
	.card-body
		.wallet-history(v-if='profile')
			h1.form--title
				span История платежей
				.date-select-wrapper
					.inputs-wrapper.d-flex
						v-menu(
							ref="menu"
							v-model="menu"
							:close-on-content-click="false"
							:nudge-right="40"
							lazy
							transition="scale-transition"
							offset-y
							full-width
							max-width="290px")
							template(v-slot:activator="{ on }")
								v-text-field(
									v-model="computedstartdate"
									label="C"
									hint="DD.MM.YYYY формат"
									readonly
									v-on="on")
							v-date-picker(
								v-model="startdate"
								locale="ru-ru"
								:max="new Date().toISOString().substr(0, 10)"
								@input="menu = false")
						v-menu(
							ref="menu1"
							v-model="menu1"
							:close-on-content-click="false"
							:nudge-right="40"
							lazy
							transition="scale-transition"
							offset-y
							full-width
							max-width="290px")
							template(v-slot:activator="{ on }")
								v-text-field(
									v-model="computedenddate"
									label="По"
									readonly
									v-on="on")
							v-date-picker(
								v-model="enddate"
								locale="ru-ru"
								:min="mindate"
								@input="menu1 = false")
		
		.results(v-if="!empty")
			.history-record
				.date 14.03.2020
				.row
					dl.col-md-4.price
						dt Сумма
						dd 15 000 руб.
					dl.col-md-4.type
						dt Способ оплаты
						dd Банковский перевод
					dl.col-md-4.sort
						dt Вид услуги
						dd Пополнение кошелька
		.empty-results(v-else)
			span Нет записей				
</template>
<script>
export default {
  props: {
    profile: Object
  },
  data() {
    return {
      startdate: new Date().toISOString().substr(0, 10),
      enddate: new Date().toISOString().substr(0, 10),
      menu: false,
      menu1: false,
      empty: false
    };
  },
  computed: {
    computedstartdate() {
      return this.formatDate(this.startdate);
    },
    mindate() {
      return this.startdate;
    },
    computedenddate() {
      if (this.enddate < this.startdate) {
        this.enddate = this.startdate;
      }
      return this.formatDate(this.enddate);
    }
  },
  methods: {
    formatDate(date) {
      if (!date) return null;

      let [year, month, day] = date.split("-");
      return `${day}.${month}.${year}`;
    }
  }
};
</script>
<style lang="scss" scoped>
@import '../../../../../sass/base.scss';

@media (max-width: 576px) {
	.type,
	.sort {
		width: 50%;
	}
	.row {
		position: relative;
		border-top: 2px dotted #dadada;
	}
	.date {
		height: 51px;
		line-height: 51px;
	}
	.price {
		width: auto;
		float: right;
		position: absolute;
		right: 0;
		top: -100%;
	}
}
.form--title {
	font-size: 2rem;
	font-weight: normal;
	font-style: normal;
	font-stretch: normal;
	line-height: 1.2;
	letter-spacing: normal;
	text-align: left;
	color: $secondary;
	border-bottom: 2px dotted $body-color;
	margin: 0 0 3rem;

	@include media-breakpoint-up(md) {
		display: flex;
		align-items: center;
		justify-content: space-between;
	}

	span {

	}
	.date-select-wrapper {
		margin-bottom: 1.5rem;
		margin-top: 1.5rem;

		@include media-breakpoint-up(md) {
			margin-left: .5rem;
			margin-top: 0;
		}
	}
}
.v-menu {
	display: none;
}
.date-select-wrapper {
	.v-input {
		@include media-breakpoint-up(md) {
			margin-left: .5rem;
		}
	}
}
.inputs-wrapper.d-flex {
	max-width: 268px;
	justify-content: space-between;
}
.inputs-wrapper.d-flex .v-input {
	max-width: 120px;
}
.line {
	border-bottom: 2px dotted #dadada;
	border-top: none;
	margin: 0;
	margin-bottom: 35px;
	margin-left: 5px;
	margin-right: 5px;
}
.history-record {
	border-top: 2px dotted #dadada;
	margin-bottom: 30px;
	padding: 1rem 0 0;
}
.date {
	font-family: Roboto;
	font-size: 18px;
	font-weight: 500;
	text-align: left;
	color: #010101;
	margin-bottom: 5px;
}
.price dd {
	height: 30px;
	line-height: 40px;
}
dt {
	font-family: Roboto;
	font-size: 14px;
	font-weight: normal;
	color: #cfcccc;
}
dd {
	font-family: Roboto;
	font-size: 15px;
	font-weight: normal;
	text-align: left;
	color: #707070;
	margin-bottom: 0;
	height: 30px;
	line-height: 40px;
}
.price dd {
	font-size: 20px;
}
</style>