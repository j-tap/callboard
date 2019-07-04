<template>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <!-- /.box-header -->
      <!-- <datatable
        ref="datatable"
        :columns="[
                      {name: 'ID', key: 'id', sort: true},
                      {name: 'Название', key: 'org_name', sort: true, link: true, itemLink: this.getItemLink},
                      {name: 'Email', key: 'owner.email'},
                      {name: 'Телефон', key: 'phone'},
                      {name: 'ИНН', key: 'org_inn', sort: true},
                      {name: 'Город', key: 'city.name', sort: true, sort_key: 'org_city_id'},
                      {name: 'Статус', key: 'org_status', sort: true, values: getOrgStatusArray()},
                ]"
        :dataUrl="dataUrl"
        :createRoute="{name: 'clients.create'}"
        :createText="'Создать организацию'"
        :paginate="true"
        :search="true"
        :searchId="'org_name'"
      ></datatable>-->
      <div class="tablesettings">
        <div class="search-client--wrapper">
          <p class="search-client-info">Поиск клиента по личному идентификатору:</p>
          <input class="search-input" v-model="searchClient" type="text">
          <button class="search-button" v-on:click="setSearch">Искать</button>
          <button class="resetsearch-button" v-on:click="resetSearch">Сбросить</button>
        </div>
        <div class="showblock-wrapper">
          <label for="blockedUsers" class="search-client-info blockedUsers">
            <input
              id="blockedUsers"
              type="checkbox"
              v-on:click="changeBlocked()"
              v-model="showBlocked"
            >
            Показывать заблокированных
          </label>
        </div>
      </div>
      <mytable
        ref="usertable"
        :eventPrefix="eventPrefix"
        :tabledata="tabledata"
        :tablekey="key"
        :fields="tablecols"
        :nodata="nodata"
        :activesort="queryParams.sort"
        :isFixedHead="isfixedhead"
      >
        <!-- <template slot="preloader">
        <tr class="empty-tr">
          <td class="empty-td" :colspan="tablecols.length">
            <preload lineFgColor="#f16821" />
          </td>
        </tr>
        </template>-->
      </mytable>
      <pagination
        v-if="tabledata.length>0"
        :eventPrefix="eventPrefix"
        :paginationsettings="paginationsettings"
        :hasnext="pagination.hasnext"
        :hasprev="pagination.hasprev"
        :firstPage="pagination.firstPage"
        :lastPage="pagination.lastPage"
        :total="pagination.total"
        :perPage="pagination.perPage"
        :currentPage="queryParams.page"
      ></pagination>
      <div class="addnewClient-wrap">
        <router-link class="create-client" :to="{name: 'clients.create'}">Создать клиента</router-link>
      </div>
      <!-- /.box-body -->
    </div>
  </section>
  <!-- /.content -->
</template>

<script>
import { Component, Prop, Vue } from "vue-property-decorator";
import ViewMixins from "../../mixins/view";
import mytable from "../Components/mytable";
import pagination from "../Components/pagination";

Vue.component("mytable", mytable);
Vue.component("pagination", pagination);

Vue.component("userlinks", {
  template: `
    <router-link :to="propert.link || '' ">
                       {{propert.name}}
                    </router-link>
  `,
  props: {
    propert: {
      type: Object
    }
  }
});

let tablefields = [
  {
    name: "id",
    title: "Номер",
    disabled: true,
    visible: true,
    sortable: false
  },
  {
    name: "unique_id",
    title: "Идентификатор",
    disabled: true,
    visible: true,
    sortable: false
  },
  {
    name: "__component:userlinks",
    title: "Название",
    disabled: true,
    visible: true,
    sortable: false
  },
  {
    name: "email",
    title: "E-mail",
    disabled: false,
    visible: true,
    sortable: false
  },
  {
    name: "phone",
    title: "Телефон",
    disabled: false,
    visible: true,
    sortable: false
  },
  {
    name: "inn",
    title: "ИНН",
    settings_title: "Наличие",
    disabled: false,
    visible: true,
    sortable: false
  },
  {
    name: "status",
    title: "Статус",
    disabled: true,
    visible: true,
    sortable: false
  },
  {
    name: "created_at",
    title: "Дата регистрации",
    disabled: true,
    visible: true,
    sortable: true
  },
];

export default {
  mixins: [ViewMixins],
  watch: {
    $route(to, from) {
      this.updateData();
    }
  },
  data() {
    return {
      eventPrefix: "users:",
      tabledata: [],
      key: "id",
      searchClient: "",
      tablecols: tablefields,
      isfixedhead: true,
      nodata: "Нет данных",
      queryParams: {
        page: 1,
        perPage: 10,
        sort: "id|asc"
      },
      searchField: "",
      showBlocked: false,
      pagination: {
        hasprev: "",
        hasnext: "",
        perPage: 10,
        total: 0,
        firstPage: "",
        lastPage: "",
        currentPage: ""
      },
      paginationsettings: {
        viewcount: true,
        viewperpage: true,
        viewpagination: true,
        elemsname: "клиент"
      }
    };
  },
  created() {
    this.addEventListeners();
    this.getdataforTable();
  },
  beforeDestroy() {
    this.removeEventListeners();
  },
  methods: {
    changeBlocked() {
      this.showBlocked = !this.showBlocked;
      this.queryParams.page = 1;
      this.getdataforTable();
    },
    addEventListeners() {
      this.$root.$on(this.eventPrefix + "changeperpage", payload => {
        let fr = 0;
        fr = (this.queryParams.page - 1) * this.queryParams.perPage + 1;
        this.queryParams.page = Math.ceil(fr / payload);
        this.queryParams.perPage = payload;
        this.getdataforTable();
      });
      // изменение страницы
      this.$root.$on(this.eventPrefix + "newpage", payload => {
        if (
          this.queryParams.page != payload &&
          payload > 0 &&
          payload <= this.pagination.lastPage
        ) {
          this.queryParams.page = +payload;

          this.getdataforTable();
        } else {
          this.queryParams.page = 1;

          this.getdataforTable();
        }
      });
    },
    removeEventListeners() {
      let events = [
        this.eventPrefix + "changeperpage",
        this.eventPrefix + "newpage"
      ];

      for (let item of events) {
        this.$root.$off(item);
      }
    },
    setSearch() {
      if (this.searchClient.length < 7) {
        this.showError("Минимальная длина идентификатора 7 символов");
        return false;
      } else {
        this.getdataforTable();
      }
    },
    resetSearch() {
      this.searchClient = "";
      this.getdataforTable();
    },
    serializeData(obj, prefix) {
      var str = [],
        p;
      for (p in obj) {
        if (obj.hasOwnProperty(p)) {
          var k = prefix ? prefix + "[" + p + "]" : p,
            v = obj[p];
          str.push(
            v !== null && typeof v === "object"
              ? this.serializeData(v, k)
              : encodeURIComponent(k) + "=" + encodeURIComponent(v)
          );
        }
      }
      return str.join("&");
    },
    getdataforTable() {
      this.tabledata = [];
      let params = {
        page: this.queryParams.page,
        per_page: this.queryParams.perPage,
        blocked: this.showBlocked
      };
      if (this.searchClient != "") {
        params.search = this.searchClient;
        this.queryParams.page = 1;
        params.page = 1;
      }

      let uri = this.serializeData(params);
      axios
        .get("/admin/api/clients/get/user?" + uri)
        .then(resp => {
          // подготавливаем данные для таблицы
          this.processdata(resp.data.data);
          // подготавливаем данные для пагинации
          this.getpaginationdata(resp);
        })
        .catch(error => {
          this.messageLoadError();
        });
    },
    processdata(data) {
      for (let i in data) {
        this.tabledata.push(data[i]);
        this.tabledata[i].link = "/admin/clients/edit/" + data[i].id;
        this.tabledata[i].status = this.getOrgStatus(data[i].status);
      }
    },
    getpaginationdata(response) {
      this.pagination.currentPage = response.data.current_page;
      this.pagination.perPage = response.data.per_page;
      this.pagination.total = response.data.total;
      this.pagination.firstPage = 1;
      this.pagination.lastPage = response.data.last_page;
      this.pagination.hasnext =
        response.data.next_page_url == null ? false : true;
      this.pagination.hasprev =
        response.data.prev_page_url == null ? false : true;
    },
    updateData() {
      this.setTitle(this.$route.meta.title);
      this.setBreadcrumbs(this.$route.meta.breadcrumbs);
      this.$refs.datatable.apiUrl = this.dataUrl;
      this.$refs.datatable.updateData();
    },

    getItemLink(item) {
      if (!this.$root.profile.permissions.clients.edit) return {};

      return { name: "clients.view", params: { id: item.id } };
    }
  },
  computed: {
    dataUrl() {
      return "/admin/api/clients/" + this.$route.meta.props.client_type;
    }
  }
};
</script>

<style scoped>
.no-bg {
  background: transparent !important;
}
.addnewClient-wrap {
  padding-top: 10px;
  padding-left: 5px;
}
.create-client {
  border: 1px solid #908e8e;
  border-radius: 2px;
  padding: 5px;
  display: inline-block;
  margin-bottom: 10px;
}
.search-client--wrapper {
  margin: 5px;
}
.search-client-info {
  /*! margin-left: 5px; */
  /*! margin-top: 5px; */
  font-size: 15px;
  margin-bottom: 5px;
}
.search-input {
  border-radius: 2px;
  border: 1px solid;
  width: 200px;
}
.search-button {
  border-radius: 2px;
  border: 1px solid #7a7a7a;
  width: 80px;
}
.resetsearch-button {
  border-radius: 2px;
  border: 1px solid #7a7a7a;
  width: 80px;
}
.blockedUsers {
  font-weight: 500;
}
.tablesettings {
  display: flex;
  justify-content: space-between;
}
.showblock-wrapper {
  align-self: end;
  margin-right: 5px;
}
</style>
