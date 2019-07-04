<template>
  <div class="pagination-info">
    <template v-if="paginationsettings.viewcount">
      <div class="count" v-html="counttotal(total)"></div>
    </template>
    <template v-if="paginationsettings.viewpagination">
      <div class="pagination">
        <div class="pagination__controls">
          <button
            class="pagination__control"
            :disabled="!hasprev"
            :class="{'disabled': !hasprev}"
            title="В начало"
            v-on:click.prevent="updatepage(firstPage)"
            aria-role="В начало"
          >
            <svg class="pagination__control-icon" viewBox="0 0 24 24" width="24" height="24">
              <path d="M18.4 16.6L13.8 12l4.6-4.6L17 6l-6 6 6 6 1.4-1.4M6 6h2v12H6V6z"></path>
            </svg>
          </button>
          <button
            class="pagination__control"
            :disabled="!hasprev"
            :class="{'disabled': !hasprev}"
            title="Предыдущая страница"
            v-on:click.prevent="updatepage(currentPage, 'decrement')"
            aria-role="Предыдущая страница"
          >
            <svg class="pagination__control-icon" viewBox="0 0 24 24" width="24" height="24">
              <path d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z"></path>
            </svg>
          </button>
        </div>

        <ul class="pagination__list">
          <template v-if="hasitems">
            <li
              v-for="n in visiblepages"
              :title="addTitle(startPage+n-1)"
              class="pagination__item"
              :key="n"
              :disabled="startPage+n-1==currentPage"
              :class="{'pagination__item--active' : startPage+n-1==currentPage }"
            >
              <a class="pagination__link" v-on:click="updatepage(startPage+n-1)">{{startPage+n-1}}</a>
            </li>
            <li class="pagination__slide-line"></li>
          </template>
          <template v-else>
            <li
              v-for="n in lastPage"
              :key="n"
              :title="addTitle(startPage+n-1)"
              class="pagination__item"
              :disabled="startPage+n-1==currentPage"
              :class="{'pagination__item--active' : startPage+n-1==currentPage }"
            >
              <a class="pagination__link" v-on:click="updatepage(startPage+n-1)">{{startPage+n-1}}</a>
            </li>
          </template>
        </ul>

        <div class="pagination__controls">
          <button
            class="pagination__control"
            :disabled="!hasnext"
            :class="{'disabled': !hasnext}"
            title="Следующая страница"
            v-on:click.prevent="updatepage(currentPage, 'increment')"
            aria-role="Следующая страница"
          >
            <svg class="pagination__control-icon" viewBox="0 0 24 24" width="24" height="24">
              <path d="M8.6 16.6l4.6-4.6-4.6-4.6L10 6l6 6-6 6-1.4-1.4z"></path>
            </svg>
          </button>
          <button
            class="pagination__control"
            :disabled="!hasnext"
            :class="{'disabled': !hasnext}"
            title="В конец"
            v-on:click.prevent="updatepage(lastPage)"
            aria-role="В конец"
          >
            <svg class="pagination__control-icon" viewBox="0 0 24 24" width="24" height="24">
              <path d="M5.6 7.4l4.6 4.6-4.6 4.6L7 18l6-6-6-6-1.4 1.4M16 6h2v12h-2V6z"></path>
            </svg>
          </button>
        </div>
      </div>
    </template>
    <template v-if="paginationsettings.viewperpage">
      <div class="per_page--wrap">
        <p>
          <span class="elems-per-page">{{paginationsettings.elemsname|getname}}</span> на страницу:
        </p>
        <select v-on:change="changeperpage($event.target.value)" :value="perPage">
          <option v-for="item in itemsArray" :key="item" :value="item">{{item}}</option>
        </select>
      </div>
    </template>
  </div>
</template>
<script>
export default {
  name: "pagination",
  props: {
    eventPrefix: {
      type: String,
      required: true
    },
    paginationsettings: {
      type: Object
    },
    hasprev: {
      type: Boolean
    },
    hasnext: {
      type: Boolean
    },
    currentPage: {
      type: [String, Number]
    },
    firstPage: {
      type: [String, Number]
    },
    lastPage: {
      type: [String, Number]
    },
    perPage: {
      type: [String, Number],
      default: 10
    },
    total: {
      type: [String, Number]
    },
    count: {
      type: [String, Number],
      default: 2
    }
  },
  data() {
    return {
      nodata: "Нет данных для отображения",
      itemsArray: [10, 25, 50, 100, 150, 200]
    };
  },
  computed: {
    // проверяем есть ли данные для пагинации
    hasitems() {
      return this.lastPage > this.count + 4;
    },
    latest() {
      return this.lastPage > 1 ? this.lastPage - 1 : this.lastPage;
    },
    // первая страница слева
    startPage() {
      if (this.currentPage <= this.count) {
        return 1;
      } else if (this.currentPage >= this.lastPage - this.count + 1) {
        if (this.lastPage - this.count * 2 > 0) {
          return this.lastPage - this.count * 2;
        } else {
          return 1;
        }
      } else {
        return this.currentPage - this.count;
      }
    },
    // количество видимых страниц
    visiblepages() {
      return this.count * 2 + 1;
    }
  },
  filters: {
    // формируем строку количества элементов (выпадающий список)
    getname(name) {
      var result;
      if (name) {
        result = name + "ов";
      } else {
        var result = "элементов";
      }
      return result;
    }
  },
  methods: {
    // добавляем title к страницам
    addTitle(page) {
      return "На страницу " + page;
    },
    // меняем страницу
    updatepage(value, operand) {
      if (!+value || value < 0 || value > this.lastPage) {
        return false;
      } else {
        if (operand != undefined) {
          operand == "decrement"
            ? this.$root.$emit(this.eventPrefix + "newpage", --value)
            : this.$root.$emit(this.eventPrefix + "newpage", ++value);
        } else {
          this.$root.$emit(this.eventPrefix + "newpage", value);
        }
      }
    },
    // меняем количество на страницу
    changeperpage(newValue) {
      var app = this;
      app.$root.$emit(this.eventPrefix + "changeperpage", newValue);
    },
    // подсчитываем общее количество
    counttotal(count) {
      var n = count;
      var elem = this.paginationsettings.elemsname || "элемент";
      return n % 10 == 1 && n % 100 != 11
        ? "Найден " + n + " " + elem
        : n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20)
        ? "Найдено " + n + " " + elem + "а"
        : "Найдено " + n + " " + elem + "ов";
    }
  }
};
</script>
<style lang="css" scoped>
*:active {
  outline: none !important;
}
.elems-per-page {
  text-transform: capitalize;
}
.no-pagination-data__wrap {
  padding: 10px;
  text-align: center;
}
.pagination-info {
  color: #2f3943;
  margin-top: 5px;
  background: white;
  text-align: left;
  display: inline-flex;
  width: 100%;
  align-items: center;
}
.count {
  padding: 1rem;
  display: inline-block;
  text-align: left;
  width: auto;
  font-size: 13px;
}
/* пагинация */
/* pagination start */
.pagination {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  margin: 5px 0;
}

.pagination__controls {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  border-radius: 4px;
  border: 1px solid #eeeeee;
  overflow: hidden;
}

.pagination__control {
  display: block;
  padding: 8px;
  text-decoration: none;
  color: #212121;
  background-color: #f5f5f5;
  border: none;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  outline: none;
  -webkit-transition-duration: 0.4s;
  transition-duration: 0.4s;
  cursor: pointer;
}

.pagination__control:hover,
.pagination__control:focus {
  color: #212121;
  background-color: #eeeeee;
}

.pagination__control:active {
  color: #212121;
  background-color: #e0e0e0;
}

.pagination__control-icon {
  display: block;
  fill: currentColor;
}

.pagination__list {
  position: relative;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-item-align: stretch;
  align-self: stretch;
  margin: 0;
  padding: 0;
  list-style: none;
}

.pagination__item {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}

.pagination__link {
  position: relative;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  padding: 8px;
  width: 42px;
  text-align: center;
  color: #212121;
  text-decoration: none;
  overflow: hidden;
}

.pagination__link:hover,
.pagination__link:focus {
  background-color: #fafafa;
}

.pagination__item--active .pagination__link {
  cursor: default;
  pointer-events: none;
}

.pagination__item--active .pagination__link::before {
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  height: 4px;
  background-color: rgba(15, 41, 129, 0.39);
}

/* pagination end */

.per_page--wrap {
  width: 390px;
  padding-left: 10px;
  vertical-align: inherit;
  display: inline-flex;
  align-items: center;
  margin-left: 10px;
}
.per_page--wrap p {
  display: inline-block;
  font-size: 13px;
  margin-bottom: 0;
}
select {
  height: 38px;
  width: 52px;
  margin-left: 5px;
  border: 1px solid #d4d4d5;
  border-radius: 1px;
}
select:focus {
  outline: none !important;
  border: 1px solid #d4d4d5;
}
select:active {
  outline: none !important;
  border: 1px solid #d4d4d5;
}
.active {
  font-weight: 900;
  font-size: 17px;
}
</style>