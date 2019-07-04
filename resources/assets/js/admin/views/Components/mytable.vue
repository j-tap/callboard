<template>
  <div class="hello">
    <table class="my__table">
      <thead :class="[{fixed : isFixedHead}, {noslot: !tableheadslot}]">
        <template v-for="col in fields">
          <template v-if="col.sortable">
            <th
              :key="col.name"
              :class="col.additional_header_class"
              class="sortable"
              v-on:click="issortable(col.sortable,col.name)"
              v-if="col.visible==true"
            >
              <div v-html="getColData(col)"></div>
            </th>
          </template>
          <template v-else>
            <template v-if="extractName(col.name)==true">
              <th :key="col.name" :class="col.additional_header_class" v-if="col.visible==true">
                <template v-if="col.headcomponent">
                  <component
                    :is="col.headcomponentname"
                    :parentprops="$props.subprops"
                    :eventPrefix="eventPrefix"
                  ></component>
                </template>
                <template v-else>
                  <div
                    :class="col.additional_item_class"
                    v-on:click="issortable(col.sortable,col.name)"
                    v-if="col.visible==true"
                    v-html="getColData(col)"
                  ></div>
                </template>
              </th>
            </template>
            <template v-else>
              <th
                :key="col.name"
                :class="col.additional_header_class"
                v-on:click="issortable(col.sortable,col.name)"
                v-if="col.visible==true"
                v-html="getColData(col)"
              ></th>
            </template>
          </template>
        </template>
      </thead>
      <tbody>
        <template v-if="preloader">
          <tr class="empty-tr">
            <td :colspan="fields.length" class="empty-td">
              <!-- <div class="loader-container arc-scale">
                <div class="loader">
                  <div class="arc"></div>
                </div>
              </div>-->
            </td>
          </tr>
        </template>
        <template v-else>
          <template v-if="empty">
            <tr class="empty-tr">
              <td :colspan="fields.length" class="empty-td">{{nodata}}</td>
            </tr>
          </template>
          <template v-else>
            <tr :key="itm[tablekey]" v-on:dblclick="trclick(itm)" v-for="itm in tabledata">
              <template v-for="col in fields">
                <template v-if="col.visible==true">
                  <template v-if="extractName(col.name)">
                    <td v-on:click="tdclick(itm,col.name)" :class="col.additional_item_class">
                      <component
                        :is="extractComponent(col.name)"
                        :parentprops="$props.subprops"
                        :propert="itm"
                        :eventPrefix="eventPrefix"
                      ></component>
                    </td>
                  </template>
                  <template v-else>
                    <td
                      :class="col.additional_item_class"
                      v-on:click="tdclick(itm,col.name)"
                      v-html="transform(itm,col.name)"
                    ></td>
                  </template>
                </template>
              </template>
            </tr>
          </template>
        </template>
      </tbody>
    </table>
  </div>
</template>
<script>
import axios from "axios";
import vue from "vue";

// описание входных параметров таблицы
// props: {
//     eventPrefix: {               --  префикс эвента ( часть названия эвента улавливаемого родителем, необходим для разделения эвентов от разных компонентов-таблиц ), обязательный параметр
//       type: String,
//       required: true
//     },
//     fields: {                    --  массив полей таблицы
//       type: Array
//     },
//     tabledata: {                 --  массив строк таблицы
//       type: Array
//     },
//     tableheadslot: {             --  флаг, показывающий, нужно ли рендерить слот над таблицей, необязательный параметр, при установке в true, компонент передаётся через слот tableheadslot
//       type: Boolean,
//       default: false
//     },
//     tablebodytopslot: {          --  флаг, показывающий, нужно ли рендерить слот под между шапкой таблицы и полями таблицы, необязательный параметр, при установке в true, компонент передаётся через слот tablebodytopslot
//       type: Boolean,
//       default: false
//     },
//     tablebodybottomslot: {       --  флаг, показывающий, нужно ли рендерить слот после вывода массива строк таблицы, необязательный параметр, при установке в true, компонент передаётся через слот tablebodybottomslot
//       type: Boolean,
//       default: false
//     },
//     preloader:{                  --  флаг, показывающий, нужно ли использовать прелоадер, необязательный параметр, при установке в true, компонент передаётся через слот preloader
//       type: Boolean,
//       default: false
//     },
//     tablekey:{                   --  параметр (поле), по которому отслеживается уникальность строки таблицы, необязательный параметр, значение по умолчанию 'id'
//       type: String,
//       default: 'id'
//     },
//     nodata: {
//       type: String,              --  строка, выводимая, если нет данных (массив tabledata - пустой), значение по умолчанию - 'Нет данных'
//       default: 'Нет данных'
//     },
//     isFixedHead: {               --  флаг, показывающий фиксируется ли шапка таблицы (и слот над ней), по умолчанию - true
//       type: Boolean,
//       default: true
//     },
//     subprops:{}                  --  объект свойств для дочерних компонентов (если они есть) (пока не используется, в дочерние компоненты в качестве входных параметров передаётся вся строка таблицы)
//   },

export default {
  name: "mytable",
  props: {
    eventPrefix: {
      type: String,
      required: true
    },
    fields: {
      type: Array
    },
    tabledata: {
      type: Array
    },
    preloader: {
      type: Boolean,
      default: false
    },
    tablekey: {
      type: String,
      default: "id"
    },
    nodata: {
      type: String,
      default: "Нет данных"
    },
    activesort: {
      type: String
    },
    isFixedHead: {
      type: Boolean,
      default: true
    },
    tableheadslot: {
      type: Boolean,
      default: false
    },
    subprops: {}
  },
  created() {
    // проверяем на пустоту
    // this.empty = this.tabledata.length < 1;
  },
  updated() {
    // обновляем активную сортировку
    this.activesort ? (this.sort = this.activesort) : "";
    // проверяем на пустоту
    // this.empty = this.tabledata.length < 1;
  },
  data() {
    return {
      // empty: true,
      active_sort_icon: '<i class="active"></i>',
      passive_sort_icon: '<i class="passive"></i>',
      sort: "id"
    };
  },
  computed: {
    // ассив результатов
    results() {
      return this.tabledata;
    },
    empty() {
      return this.results.length < 1;
    }
  },
  methods: {
    // клик по tr
    trclick(item) {
      this.$root.$emit(this.eventPrefix + "trdblclick", item);
    },
    // клик по td
    tdclick(item, colname) {
      var params = {};
      params.name = colname;
      params.item = item;
      this.$root.$emit(this.eventPrefix + "tdclick", params);
    },
    // проверяем, сортируемое ли поле
    issortable(sortable, name) {
      if (sortable) {
        this.changesort(name);
      }
    },
    // смена сортировки
    changesort(colname) {
      var currentsort = this.sort;
      var direction = "";
      if (currentsort.indexOf(colname) != -1) {
        direction =
          colname + "|" + (currentsort.indexOf("asc") != -1 ? "desc" : "asc");
      } else {
        direction = colname + "|" + "desc";
      }

      if (direction != currentsort) {
        this.sort = direction;
      }
      this.$root.$emit(this.eventPrefix + "changesort", this.sort);
    },
    // собираем данные заголовка
    getColData(col) {
      var sort = "";
      var title = col.title;
      var active_sort = this.sort;
      var sort_direction = active_sort.indexOf("desc") != -1 ? "down" : "up";
      if (col.sortable) {
        if (active_sort.indexOf(col.name) != -1) {
          sort = this.active_sort_icon.replace(
            "active",
            "active " + sort_direction
          );
        } else {
          sort = this.passive_sort_icon.replace("passive", "passive down");
        }
      }
      return title + sort;
    },
    // берем название столбца
    getTitle(col) {
      return col.title;
    },
    // возвращаем pos-тый элемент массива line
    transform(line, pos) {
      return line[pos];
    },
    // проверяем, является ли столбец столбцом компонентов
    extractName(name) {
      return name.indexOf("__component") != -1;
    },
    // извлекаем имя компонента
    extractComponent(name) {
      return name.replace("__component:", "");
    }
  }
};
</script>

<style scoped>
.hello {
  width: 100%;
  display: block;
  margin: 0;
  transition: all ease 0.5s;
}

.my__table {
  border: 1px solid #d4d4d5;
  border-spacing: 0px;
  width: 100%;
  background-color: white;
  color: #2f3943;
}

.sortable {
  cursor: pointer;
}
.sortable div {
  padding-right: 14px;
}
.my__table thead th {
  background: #f9fafb;
  text-align: inherit;
  color: #2f3943;
  padding: 0.92857143em 0.78571429em;
  vertical-align: middle;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0 rgba(0, 0, 0, 0.14), 0 1px 3px 0 rgba(0, 0, 0, 0.12);
  font-size: 14px;
  font-weight: 600;
  text-align: left;
}
.my__table thead.fixed th {
  position: sticky;
  top: 30px;
  z-index: 2;
}
.my__table thead.fixed.noslot th {
  position: sticky;
  top: 0px;
  z-index: 2;
}
.my__table tbody tr {
  height: 46px;
}
.my__table tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.05);
}

.my__table tbody td {
  padding: 0 10px !important;
  height: 39px;
  vertical-align: middle;
  font-size: 13px;
  min-width: auto !important;
  width: auto;
  text-align: left;
  border-top: 1px solid rgba(34, 36, 38, 0.1);
}

thead >>> i {
  float: right;
  position: relative;
  /*right: 10px;*/
}

thead >>> i.passive {
  color: #c1c2c3;
}

thead >>> i.down:before {
  position: absolute;
  right: -15px;
  top: 65%;
  color: #999;
  margin-top: 7px;
  border-style: solid;
  border-width: 5px 5px 0;
  border-color: #999 transparent transparent;
  content: "";
}

thead >>> i.up:before {
  position: absolute;
  right: -15px;
  top: 65%;
  color: #999;
  margin-top: 7px;
  border-style: solid;
  border-width: 5px 5px 0;
  border-color: #999 transparent transparent;
  content: "";
  transform: rotate(180deg);
}

thead >>> i.active:before {
  /*color: #f16821;*/
  color: #f16821;
  border-color: #f16821 transparent transparent;
}
.empty-tr {
  display: table-row;
}

.empty-td {
  text-align: center !important;
  padding: 10px;
  font-size: 18px !important;
  font-weight: 500;
}
</style>
