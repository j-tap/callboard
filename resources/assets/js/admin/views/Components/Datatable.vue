<template>

    <div class="box-body dataTables_wrapper">

      <div class="row" v-if="!items.data">
      <div class="col-md-6">
        <i class="fa fa-refresh fa-spin"></i>
        Загрузка данных...
      </div>
      </div>
        <div class="row" v-if="items.data">
            <div v-if="paginate" class="col-sm-6">
                <div class="dataTables_length" id="example1_length">
                    <label>Показать <select v-model="perPage" v-on:change="updateData()" name="example1_length" class="form-control input-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        </select> записей</label>
                </div>
            </div>
            <div v-if="search" class="col-sm-6">
                <div id="example1_filter" class="dataTables_filter">
                    <label>Поиск:<input v-model="searchString" v-on:keyup="updateData()" type="search" class="form-control input-sm" placeholder="" aria-controls="example1"></label>
                </div>
            </div>
        </div>

        <table id="table" class="table table-bordered table-striped dataTable">
            <thead>
            <tr>
                <th v-for="col in columns" :class="[col.sort && sortKey == colSortKey(col) ? (sortOrders[colSortKey(col)] > 0 ? 'sorting_asc' : 'sorting_desc') : (col.sort ? 'sorting' : '')]" @click="col.sort ? sortBy(colSortKey(col)) : ''">{{col.name}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items.data">
                <td v-for="col in columns">
                    <router-link v-if="col.link" :to="col.itemLink(item)">
                        {{getProperty(col, item)}}
                    </router-link>
                    <router-link v-else-if="col.button" :to="col.buttonLink(item)">
                        {{col.buttonLabel}}
                    </router-link>
                    <span v-else>{{getProperty(col, item)}}</span>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="box-footer clearfix">
            <router-link v-if="createRouteShow" :to="createRoute" class="btn btn-default">{{createText}}</router-link>

            <paginate
                v-if="paginate"
                v-model="items.current_page"
                :page-count="items.last_page"
                :container-class="'pagination no-margin pull-right'"
                :prev-text="'Назад'"
                :next-text="'Вперед'"
                :click-handler="updateData">
            </paginate>
        </div>
    </div>
</template>

<script>
   /* :columns = columns
    * :dataUel = data sourse url
    * :createText = Create button text
    * :createRoute = Create button route
    *
    * columns: {name: '', key: '', sort: bool, link: bool, itemLink: function(item), button: bool, buttonLink: function(item)}
    *   name: column name
    *   key: data source id
    *
    * :search
    * :searchId
    */

    import Paginate from 'vuejs-paginate';

    export default {
        mixins: [],
        components: {
            Paginate: Paginate
        },
        props: {
            columns: Array,
            dataUrl: String,
            paginate: false,
            createText: '',
            createRoute: {},
            search: false,
            searchId: '',
        },
        data() {
            var sortOrders = {}
            this.columns.forEach(function (col) {
                sortOrders[col.sort_key || col.key] = 1
            });

            return {
                items: {
                    current_page: 1,
                    last_page: 0,
                    data: null,
                },
                sortKey: '',
                sortOrders: sortOrders,
                sortOrder: '',
                perPage: 10,
                searchString: '',
                apiUrl: '',
            }
        },
        mounted() {
            this.apiUrl = this.dataUrl;
            this.updateData();
        },
        methods: {
            updateData(page) {
                var url = this.getQuery(page);

                this.$root.$nprogress.start();
                axios.get(url).then(
                    (resp) => {
                        if (this.paginate) {
                            this.items = resp.data;
                        } else {
                            this.items.data = resp.data
                        }
                        this.$root.$nprogress.done();
                    }).catch(
                    (error) => {
                        this.messageLoadError();
                        this.$root.$nprogress.done();
                    });
            },

            sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;

                if (this.sortKey) {
                    this.sortOrder = (this.sortOrders[key] > 0) ? 'asc' : 'desc';
                }

                this.updateData(this.items.current_page);
            },

            colSortKey(col) {
                return col.sort_key || col.key;
            },

            getQuery(page) {
                var params = {};
                if (page) params.page = page;
                if (this.sortKey) {
                    params.sort_key = this.sortKey;
                    params.sort_order = this.sortOrder;
                }
                if (this.perPage && this.paginate) params.per_page = this.perPage;
                if (this.searchString) {
                    params.search_string = this.searchString;
                    params.search_id = this.searchId;
                }

                return this.apiUrl + '?' + Object.keys(params).map((key) => {
                    return key + '=' + params[key]
                }).join('&');
            },

            getProperty(column, object) {
                var parts = column.key.split( "." ),
                    length = parts.length,
                    i,
                    property = object || this;

                for (i = 0; i < length; i++) {
                    if (!property) return '-';

                    property = property[parts[i]];
                }

                if (column.values) {
                    property = column.values[property];
                }

                return property;
            }
        },
        computed: {
            createRouteShow() {
                if (this.createRoute == null)
                    return false;

                return true;
            }
        }
    }
</script>
