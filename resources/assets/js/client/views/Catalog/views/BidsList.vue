<template lang="pug">
.bids-search
	.bids-search-filter#bidsFilter(ref='bidsFilter')
		FilterBids(@filterUpdate='filterUpdate')

	.bids-search-list
		.container
			ul.row.row-small.list-unstyled(
				v-if='bids.items && bids.items.length || companies.items && companies.items.length'
			)
				li.col-xl-4.col-md-6.mb-4(
					v-for='bid in bids.items'
				)
					BidCardShort(:bid='bid')
					
				li.col-xl-4.col-md-6.mb-4(
					v-for='company in companies.items'
				)
					CompanyCardShort(:company='company')

			.mb-5(v-else) 
				p Ничего не найдено

			.text-center.mb-5(v-if='bids ? !!bids.hasMore : false')
				b-button(
					variant='outline-primary'
					@click='getMore()'
				) 
					span(v-if='isLoadingMore') Загрузка...
					span(v-else) Загрузить ещe

</template>

<script>
import Aside from "../../GeneralComponents/components/Aside";
import FilterBids from "../components/FilterBids";
import BidCardShort from "../../GeneralComponents/components/BidCardShort";
import CompanyCardShort from "../../GeneralComponents/components/CompanyCardShort";

export default {
  components: {
    BidCardShort,
    CompanyCardShort,
    Aside,
    FilterBids
  },
  data() {
    return {
      bids: {},
      companies: {},
      fieldsAllBids: {
        type_deal: null, // 'buy'| 'sell'
        "categories[]": null,
        "cities[]": null,
        date_created: null,
        date_deadline: null,
        with_photo: null,
        deal_name: null,
        budget_from: null,
        budget_to: null,
        // city: $route.params.city,
        finish: null,
        user_id: null
      },
      fieldsAllCompanies: {
        "categories[]": null,
        "cities[]": null,
        search: null
      },
      filterUpd: {},
      filter: {
        type_deal: "sell"
      },
      nextPage: 2,
      isLoadingMore: false
    };
  },
  computed: {
    apiUrl() {
      if (this.filterUpd.isCompany) return "/api/v1/filter/organization";
      else return "/api/v1/filter/deals";
    }
  },
  methods: {
    loadItems() {
      this.bids = [];
      this.companies = [];

      if (this.filterUpd.isCompany) {
        this.initFilterCompanies();
        this.loadCompanies();
      } else {
        this.initFilterBids();
        this.loadBids();
      }
    },
    loadBids() {
      this.$store.commit("setLoading", true);
      axios
        .get(this.apiUrl, { params: this.filter })
        .then(resp => {
          this.bids = resp.data.data;
        })
        .catch(error => {
          this.printErrorOnConsole(error);
        })
        .then(() => {
          this.$store.commit("setLoading", false);
        });
    },
    loadCompanies() {
      this.$store.commit("setLoading", true);
      axios
        .get(this.apiUrl, { params: this.filter })
        .then(resp => {
          this.companies = resp.data.data;
        })
        .catch(error => {
          this.printErrorOnConsole(error);
        })
        .then(() => {
          this.$store.commit("setLoading", false);
        });
    },
    getMore() {
      this.isLoadingMore = true;
      axios
        .get(this.apiUrl + "?page=" + this.nextPage, { params: this.filter })
        .then(resp => {
          if (this.filterUpd.isCompany) {
            this.companies.items = this.companies.items.concat(
              resp.data.data.items
            );
            this.companies.hasMore = resp.data.data.hasMore;
          } else {
            this.bids.items = this.bids.items.concat(resp.data.data.items);
            this.bids.hasMore = resp.data.data.hasMore;
          }
          this.nextPage++;
        })
        .catch(error => {
          this.printErrorOnConsole(error);
        })
        .then(() => {
          this.isLoadingMore = false;
        });
    },
    resetFilter() {
      this.filter = {};
    },
    addQueryParams() {
      let params = this.$route.query;
    },
    initFilterBids() {
      this.resetFilter();
      for (let field in this.fieldsAllBids) {
        switch (field) {
          case "categories[]":
            if (this.$route.query["category"]) {
              this.filter[field] = this.$route.query["category"];
            }
            break;
          case "cities[]":
            if (this.$route.query["city"]) {
              this.filter[field] = this.$route.query["city"];
            }
            break;
          case "deal_name":
            if (this.$route.query["search"]) {
              this.filter[field] = this.$route.query["search"];
            }
            break;
          default:
            if (this.$route.query[field]) {
              this.filter[field] = this.$route.query[field];
            }
            if (this.filterUpd[field]) {
              this.filter[field] = this.filterUpd[field];
            }
            break;
        }
      }
    },
    initFilterCompanies() {
      this.resetFilter();
      for (let field in this.fieldsAllCompanies) {
        switch (field) {
          case "categories[]":
            if (this.$route.query["category"]) {
              this.filter[field] = this.$route.query["category"];
            }
            break;
          case "cities[]":
            if (this.$route.query["city"]) {
              this.filter[field] = this.$route.query["city"];
            }
            break;
          default:
            if (this.$route.query[field]) {
              this.filter[field] = this.$route.query[field];
            }
            if (this.filterUpd[field]) {
              this.filter[field] = this.filterUpd[field];
            }
            break;
        }
      }
    },

    filterUpdate(filterUpd) {
      this.filterUpd = filterUpd;
      this.loadItems();
    }
  },
  watch: {
    "$route.query": function() {
      this.loadItems();
    }
  },
  mounted() {
    this.loadItems();
  }
};
</script>

<style lang="scss" scope>
@import "../../../../../sass/base.scss";

.height-gift ~ .main {
  .bids-search-filter {
    top: ($height-header + $height-gift-height);

    @include media-breakpoint-down(sm) {
      top: ($height-header-sm + $height-gift-height-sm);
    }
  }
}

.bids-search {
  &-filter {
    position: fixed;
    top: $height-header;
    left: 0;
    right: 0;
    z-index: 900;

    @include media-breakpoint-down(sm) {
      top: $height-header-sm;
      overflow: hidden;
      transition: max-height 0.2s ease;
      max-height: 0;
      background: $white;
      box-shadow: $box-shadow;
    }
    &.active {
      @include media-breakpoint-down(sm) {
        max-height: 99rem;
      }
    }
  }
  &-list {
  }
}
</style>