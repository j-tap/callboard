<template lang="pug">
form.form-search(
	id='formSearch'
	@submit.prevent='beforeSubmit'
)
	.input-group
		.form-control-search
			input#search.form-control(
				:class="{'m-empty': !search}"
				type='search' 
				placeholder='' 
				aria-label='Поиск заявок' 
				aria-describedby='buttonSearch'
				name='search'
				v-model='search' 
			)
			feather(type='search')

		.input-group-append

			.d-flex
				b-btn(
					variant='light' 
					class='search-btn-city d-none d-sm-block' 
					v-b-toggle="'collapseCity'"
					:title='city'
					v-model='cityId'
				)
					span {{city}}
					feather(type='map-pin')

				b-btn(
					id='buttonSearch' 
					type='submit' 
					class='search-btn-submit' 
					variant='primary'
				)
					.sr-only Искать
					feather(type='search')

	b-collapse(
		id='collapseCity' 
		class='header-collapse' 
		v-click-outside='clickOutsideCity' 
		v-model='isCityCollapse'
		ref='collapseCity'
	)
		div
			RegionsList(@cityUpdate='cityUpdate')

</template>

<script>
import RegionsList from "./RegionsList";
import Vue from "vue";

export default {
  components: {
    RegionsList
  },
  data() {
    return {
      search: this.$route.query.search || null,
      isCityCollapse: false,
      city: "Город",
      cityId: null,
      geo: {}
    };
  },
  watch: {
    "$route.query.search"(newVal, oldVal) {
      newVal != oldVal ? (this.search = newVal) : "";
    }
  },
  updated() {
    this.search = this.$route.query.search || this.search;
  },
  methods: {
    beforeSubmit() {
      this.$router.push({
        name: "bids.list",
        query: {
          city: this.cityId,
          type_deal: this.$route.query.type_deal || "sell",
          date_created: this.$route.query.date_created || "desc",
          category: this.$parent.categoryId,
          search: this.search
        }
      });
    },
    clickOutsideCity(evt, el) {
      if (
        this.isCityCollapse &&
        el.classList.contains("show") &&
        !$(evt.target).closest(".search-btn-city").length
      ) {
        this.isCityCollapse = false;
      }
    },
    cityUpdate(city) {
      this.city = city.name;
      this.cityId = city.id;
      this.setCookie("user_city", city.name, { expires: 3600 });
      this.setCookie("user_city_id", city.id, { expires: 3600 });
      this.$store.commit("setCity", city);
      this.isCityCollapse = false;
      if (document.getElementById("filterBtnCity"))
        document.getElementById("filterBtnCity").innerHTML = city.name;
      if (this.$route.name == "bids.list") this.beforeSubmit();
      // this.$router.push({name: 'bids.list', query: {city: this.cityId}})
    },
    setCity() {
      // if (this.$root.profile) {
      // 	this.city = this.$root.profile.company.city.name // TODO: replace to city user
      // } else {
      let cookieCity = this.getCookie("user_city");
      let cookieCityId = this.getCookie("user_city_id");

      if (cookieCityId === "null") cookieCityId = null;
      if (cookieCity && (cookieCityId || cookieCityId === null)) {
        this.city = cookieCity;
        this.cityId = cookieCityId;
        this.cityUpdate({ id: this.cityId, name: this.city });
      } else {
        this.yandexCity().then(cityYandex => {
          this.kladrLocation(cityYandex).then(geo => {
            if (typeof geo === "object") {
              this.geo = geo;
              this.cityUpdate(geo);
            }
          });
        });
      }
      // }
    },
    kladrLocation(str) {
      return new Promise((resolve, reject) => {
        if (str.length) {
          axios
            .get("/api/v1/kladr/place?query=" + str)
            .then(resp => {
              const result = resp.data.data ? resp.data.data.cities[0] : "";
              resolve(result);
            })
            .catch(error => {
              this.printErrorOnConsole(error);
              reject(error);
            });
        } else {
          axios
            .get("/api/v1/kladr/position")
            .then(resp => {
              const result = resp.data.data ? resp.data.data.city : "";
              resolve(result);
            })
            .catch(error => {
              this.printErrorOnConsole(error);
              reject(error);
            });
        }
      });
    },
    yandexCity() {
      return new Promise((resolve, reject) => {
        if (typeof ymaps === "undefined") {
          resolve("");
        } else {
          ymaps.ready(() => {
            ymaps.geolocation
              .get({
                provider: "auto" //'yandex' 'browser'
              })
              .then(
                resp => {
                  const geo = resp.geoObjects.get(0);
                  const city = geo.getLocalities()[0];
                  resolve(city);
                },
                error => {
                  this.printErrorOnConsole(error);
                  resolve(false);
                }
              );
          });
        }
      });
    }
  },
  mounted: function() {
    this.setCity();
  }
};
</script>

<style scoped lang="scss">
@import "../../../../../sass/base";

.form-search {
  display: flex;
  margin-left: 1rem;

  .input-group {
    flex-wrap: nowrap;

    .search-btn-submit {
      border-top-left-radius: 0;
    }
    .form-control-search {
      width: 100%;
      line-height: 3rem;
      position: relative;
      z-index: 3;

      .form-control {
        max-width: 28rem;
        border-radius: $border-radius 0 0 $border-radius;

        &::-moz-placeholder {
          line-height: 3rem;
        }
        &.m-empty {
          & + i.feather {
            opacity: 1;
          }
        }
        @include media-breakpoint-down(xs) {
          border-radius: $border-radius;
        }
      }
      i.feather {
        width: 1.6rem;
        height: 1.6rem;
        position: absolute;
        top: 50%;
        margin-top: -0.8rem;
        left: 0.8rem;
        color: $gray;
        opacity: 0;
      }
    }
  }
  .btn {
    span {
      line-height: 1;
      padding-right: 0.5rem;
      vertical-align: middle;
    }
    .feather {
      width: 1.8rem;
      height: 1.8rem;
      vertical-align: middle;
      color: $text-gray;

      &--map-pin {
        width: 1.6rem;
        height: 1.6rem;
      }
      &--search {
        color: $white;
      }
    }
  }
  .search-btn-city {
    border-radius: 0;
    background: $white;
    border-left: 0.1rem solid $light-gray;
    padding-right: 3rem;
    width: 14rem;
    color: $text-gray;
    text-align: left;

    &:hover,
    &:focus,
    &:active {
      background: $white;
    }

    span {
      position: relative;
      max-width: 10rem;
      display: inline-block;
      overflow: hidden;
      white-space: nowrap;
      padding-right: 1rem;

      &::after {
        content: "";
        position: absolute;
        top: 0;
        right: -0.8rem;
        bottom: 0;
        width: 2rem;
        background: linear-gradient(
          to right,
          rgba($white, 0) 0%,
          rgba($white, 1) 100%
        );
      }
    }
  }
  .search-btn-submit {
    border: none;
    position: relative;
    z-index: 3;
    margin-left: -1rem;

    i.feather {
      svg {
        stroke-width: 0.2rem;
      }
    }
  }
  .row-icon {
    & > .feather:last-child {
      margin-left: 0.2rem;
    }
  }
}
</style>
