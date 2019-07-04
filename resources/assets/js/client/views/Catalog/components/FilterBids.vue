<template lang="pug">
form.form-search-filter
	.filter-bg
		.container
			.filter-row
				.col.checkboxes
					label.btn-checkbox
						input(
							type='radio'
							name='dealtype'
							value="buy"
							v-model="type_deal"
							@change="changeTypeDeal"
						)
						.btn Покупка		
					label.btn-checkbox
						input(
							type='radio'
							name='dealtype'
							value="sell"
							v-model="type_deal"
							@change="changeTypeDeal"
						) 
						.btn Продажа
				.col.d-block.d-sm-none.col-city
					b-btn(
						variant='light-outline'
						id='filterBtnCity'
						class='filter-btn-city' 
						v-b-toggle="'collapseCity'"
					) Город
					.v-input__icon.v-input__icon--append
						i(aria-hidden="true").v-icon.material-icons expand_more    
				.col.active.sort-col
					v-select(
						solo
						appendIcon='expand_more'
						:items='sortList' 
						v-model='sort'
						return-object
						:light='true'
						@change='sortSelectedEvt'
					)    
				//.col
					label.btn-checkbox
						input(
							type='checkbox' 
							name='isCompany' 
							v-model='form.isCompany'
							@change='isCompanyChange'
						)
						.btn Компании

				//.col
					label.btn-checkbox
						input(
							:disabled='form.isCompany'
							type='checkbox' 
							name='isBuy' 
							v-model='form.isBuy'
							@change='isBuyChange'
						)
						.btn(
							:class="{'disabled': form.isCompany}"
						) Заявки

				.col(
					:class="colCategoryClass"
				)
					.btn.btn-category.btn-city#filterBidsCategory(
						ref='filterBidsCategory'
						@click='resetCategory'
					)
				//.col
					b-button(
						v-if='isFiltration'
						class='reset-filter'
						size='md' 
						variant='outline-primary' 
						type='button'
						@click='resetFilters'
					) Фильтры

	//- .container(v-if='!isMobile')
		.filter-row
			.col
				.btn.btn-primary.btn-category#filterBidsCategory(
					ref='filterBidsCategory'
					@click='resetCategory'
				)

</template>

<script>
import { returnStatement } from "babel-types";
// import CategorySelect from '../../GeneralComponents/components/CategorySelect'
// import CitiesSelect from '../../GeneralComponents/components/CitiesSelect'
export default {
  components: {
    // CategorySelect,
    // CitiesSelect,
  },
  data() {
    return {
      sortList: [
        { text: "Сначала новые", value: "desc" },
        { text: "Сначала старые", value: "asc" }
      ],
      form: {},
      filter: {},
      defaultFilter: {
        type_deal: "buy",
        date_created: "desc",
        isCompany: false
      },
      sort: "desc",
      date_created: null,
      type_deal: this.$route.query.type_deal || "sell"
    };
  },
  updated() {
    this.type_deal = this.$route.query.type_deal || "sell";
    this.sort = this.$route.query.date_created || "desc";
    this.date_created = this.$route.query.date_created || "desc";

    if (!this.$route.query.category) {
      this.resetCategory();
    }
  },
  computed: {
    // очередной дурацкий костыль
    colCategoryClass() {
      if (this.$route.query.category) {
        return "active";
      }
      return "";
    }
  },
  methods: {
    changeTypeDeal() {
      let query = Object.assign({}, this.$route.query);
      query.type_deal = this.type_deal;
      this.$router.replace({ query });
    },
    sortSelectedEvt(value) {
      let query = Object.assign({}, this.$route.query);
      query.date_created = value.value;
      this.$router.replace({ query });
    },
    resetCategory() {
      this.$refs.filterBidsCategory.innerHTML = "";
      let query = Object.assign({}, this.$route.query);
      delete query.category;
      this.$router.replace({ query });
    }
  },
  mounted() {
    // this.resetFilters();
  }
};
</script>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.form-search-filter {
  line-height: 1;
  color: $text-gray;
  font-size: 1.4rem;
  height: $height-search-filter;
  line-height: $height-search-filter;

  @include media-breakpoint-down(sm) {
    height: auto;
    justify-content: center;
  }

  .filter-bg {
    @include media-breakpoint-up(md) {
      background: $white;
      box-shadow: $box-shadow;
    }
  }

  .filter-row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -1.5rem;
    margin-left: -1.5rem;

    @include media-breakpoint-down(xs) {
      justify-content: center;
    }
  }
  .col {
    padding-right: 1.5rem;
    padding-left: 1.5rem;
    flex: 0 0 auto;
    width: auto;
    max-height: 100%;
    &-city {
      position: relative;
      display: flex !important;
      align-items: center;
      @include media-breakpoint-up(sm) {
        display: none !important;
      }
      .btn {
        width: 100%;
        background: transparent;
        z-index: 2;
      }
      .v-input__icon {
        position: absolute;
        right: 2.6rem;
        transform: rotate(-90deg);
        z-index: 1;
      }
    }
    &:empty {
      display: none;
    }
    &:first-child {
      @include media-breakpoint-down(sm) {
        width: 100%;
        text-align: center;
      }
    }
    &.active {
      @include media-breakpoint-up(xs) {
        border-left: 0.1rem dotted $border-color;
        padding-left: 1.5rem;
      }
      @include media-breakpoint-down(xs) {
        border-top: 0.1rem solid $light-gray;
        margin-top: 1rem;
        width: 100%;
        text-align: center;
        &.sort-col {
          border-top: none;
          margin-top: 0;
        }
      }
    }
    &:empty {
      display: none;
    }

    @include media-breakpoint-down(xs) {
      width: 100%;
    }
    &.checkboxes {
      display: flex;
      align-items: center;
      width: 260px;
      justify-content: space-between;
      @include media-breakpoint-down(xs) {
        width: 100%;
      }
      .btn-checkbox {
        @include media-breakpoint-down(xs) {
          width: 100%;
        }
      }
    }
    .label {
      margin-bottom: 0;
    }
  }
  .checklink {
    cursor: pointer;
    transition: color 0.2s ease;

    @include hover-focus {
      color: $primary;
    }
    input {
      display: none;
    }
    span {
    }
    input:checked + span {
      color: $primary;
      text-decoration: underline;
    }
  }
  .v-select.v-input {
    display: inline-block;
    vertical-align: middle;
    font-size: inherit;
    min-width: 15rem;
    @include media-breakpoint-down(xs) {
      width: 100%;
    }
    .v-input__control {
      &:focus {
        outline: none;
      }
      .v-input__slot {
        height: 2.7rem;
        line-height: 2.7rem;
        padding: 0 1rem;
        border-color: $light;
        color: $text-gray-bg;
        &:hover,
        &:focus {
          box-shadow: $box-shadow-sm;
          outline: none;
        }
        .v-select__selections {
          line-height: inherit;
          display: block;

          .v-select__selection {
            white-space: nowrap;
            margin: 0;
            display: block;
            max-width: 100%;
          }
          input {
            display: none;
          }
        }
        .v-input__append-inner {
          color: $primary;
        }
      }
    }
  }
  .btn {
    font-size: inherit;
    height: 2.7rem;
    line-height: 2.7rem;
    padding: 0 1rem;
    border-color: $primary;
    border-radius: $border-radius;
    color: $primary;
    &.reset-filter {
      border-color: $primary;

      &:hover,
      &:focus {
        box-shadow: none;
      }

      &::after {
        @include deleteIconPseudo();
      }
    }
    &:hover,
    &:focus {
      box-shadow: $box-shadow-sm;
    }
  }
  .btn-checkbox {
    margin: 0;

    input {
      display: none;
    }
    .btn {
      transition: all 0.2s ease;
      border-color: $primary;
      border-radius: $border-radius;
      color: $primary;
      min-width: 11rem;
      width: inherit;
      &.disabled {
        opacity: 0.4;
        cursor: default;
      }
    }
    input:checked + .btn {
      color: $white;
      border-color: $primary;
      background-color: $primary;
      font-weight: 500;
    }
  }
  .btn-category {
    margin: 0;
    border-color: $light-gray;
    color: $primary;
    background-color: $light-gray;

    &::after {
      @include deleteIconPseudo($color: $primary);
    }
    &:empty {
      display: none;
    }
  }
  .filter-btn-city {
    width: 200px;
    text-align: left;
    border-color: $light;
    color: $secondary;
    border-radius: 0;
    @include media-breakpoint-down(xs) {
      width: 100%;
    }
    // &::after {
    //   @include shevronDownIconPseudo($color: $light);
    // }
  }
}
</style>