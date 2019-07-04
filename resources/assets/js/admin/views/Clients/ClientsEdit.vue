<template>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form class="row box-body" @submit="saveForm">
        <div class="col-md-12">
          <h3>Данные учётной записи</h3>
          <p class="current-status">
            Текущий статус :
            <b class="client-status">{{getOrgStatus(item.user.status)}}</b>
          </p>
          <div class="unique_id--wrapper">
            <p class="current-status">
              Идентификатор пользователя:
              <b class="client-status">{{item.user.unique_id}}</b>
              <!-- <button
                type="button"
                class="btn create-new-id"
                title="Сгенерировать новый идентификатор"
                v-on:click="generateNewID()"
              >
                <i class="fa fa-refresh" aria-hidden="true"></i>
              </button>-->
            </p>
          </div>
          <div class="userdata--wrapper clearfix">
            <div class="col-md-3">
              <div :class="['form-group', errors['name'] ? 'has-error' : '']">
                <label for="name">Логин пользователя</label>
                <input
                  v-model="item.user.name"
                  type="text"
                  class="form-control"
                  id="name"
                  placeholder="Введите логин"
                >
                <span
                  class="help-block"
                  v-if="errors['name']"
                  :errors="errors"
                >{{ errors['name'][0] }}</span>
              </div>
            </div>
            <div class="col-md-3">
              <div :class="['form-group', errors['email'] ? 'has-error' : '']">
                <label for="email">Email пользователя</label>
                <input
                  v-model="item.user.email"
                  type="email"
                  class="form-control"
                  id="email"
                  placeholder="Введите email"
                >
                <span
                  class="help-block"
                  v-if="errors['email']"
                  :errors="errors"
                >{{ errors['email'][0] }}</span>
              </div>
            </div>
            <div class="col-md-3">
              <div :class="['form-group', errors['phone'] ? 'has-error' : '']">
                <label for="phone">Телефон пользователя</label>
                <input
                  v-model="item.user.phone"
                  type="text"
                  class="form-control"
                  id="text"
                  placeholder="Введите телефон"
                >
                <span
                  class="help-block"
                  v-if="errors['phone']"
                  :errors="errors"
                >{{ errors['phone'][0] }}</span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Генерация нового пароля</label>
                <button type="button" class="btn create-new-id" v-on:click="generateNewPassword(item.user.unique_id)">
                  <i class="fa fa-refresh" aria-hidden="true"></i>
                  Сгенерировать новый пароль
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <h3>Данные организации</h3>
          <div class="col-md-4">
            <div :class="['form-group', errors['organization.org_inn'] ? 'has-error' : '']">
              <label for="org_inn">ИНН</label>
              <input
                v-model="item.organization.org_inn"
                type="text"
                class="form-control"
                id="org_inn"
                placeholder="Введите ИНН"
              >
              <span
                class="help-block"
                v-if="errors['organization.org_inn']"
                :errors="errors"
              >{{ errors['organization.org_inn'][0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div :class="['form-group', errors['organization.org_kpp'] ? 'has-error' : '']">
              <label for="org_kpp">КПП</label>
              <input
                v-model="item.organization.org_kpp"
                type="text"
                class="form-control"
                id="org_kpp"
                placeholder="Введите КПП"
              >
              <span
                class="help-block"
                v-if="errors['organization.org_kpp']"
                :errors="errors"
              >{{ errors['organization.org_kpp'][0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div :class="['form-group', errors['organization.org_name'] ? 'has-error' : '']">
              <label for="org_name">Название организации/ЮР лица</label>
              <input
                v-model="item.organization.org_name"
                type="text"
                class="form-control"
                id="org_name"
                placeholder="Введите название"
              >
              <span
                class="help-block"
                v-if="errors['organization.org_name']"
                :errors="errors"
              >{{ errors['organization.org_name'][0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div :class="['form-group', errors.categories ? 'has-error' : '']">
              <label for="categories">Категории</label>
              <treeselect
                v-model="item.organization.categories"
                instanceId="categories"
                :multiple="true"
                :options="categories"
                :normalizer="getNode"
              />
              <span
                class="help-block"
                v-if="errors.categories"
                :errors="errors"
              >{{ errors.categories[0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div
              :class="['form-group', errors['organization.org_legal_form_id'] ? 'has-error' : '']"
            >
              <label for="legal_form">Правовая форма</label>
              <select
                v-model="item.organization.org_legal_form_id"
                :disabled="legalForms.length == 0"
                name="legal_form"
                class="form-control"
              >
                <option
                  :key="option.id"
                  v-for="option in legalForms"
                  v-bind:value="option.id"
                >{{option.name}}</option>
              </select>
              <span
                class="help-block"
                v-if="errors['organization.org_legal_form_id']"
                :errors="errors"
              >{{ errors['organization.org_legal_form_id'][0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div :class="['form-group', errors['organization.org_director'] ? 'has-error' : '']">
              <label for="org_director">ФИО директора</label>
              <input
                v-model="item.organization.org_director"
                type="text"
                class="form-control"
                id="org_director"
                placeholder="Введите ФИО генерального директора"
              >
              <span
                class="help-block"
                v-if="errors['organization.org_director']"
                :errors="errors"
              >{{ errors['organization.org_director'][0] }}</span>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-4">
            <div :class="['form-group', errors['organization.org_address'] ? 'has-error' : '']">
              <label for="org_address">Юридический адрес</label>
              <input
                v-model="item.organization.org_address"
                type="text"
                class="form-control"
                id="org_address"
                placeholder="Введите юридический адрес"
              >
              <span
                class="help-block"
                v-if="errors['organization.org_address']"
                :errors="errors"
              >{{ errors['organization.org_address'][0] }}</span>
            </div>
          </div>
          <div class="col-md-4">
            <div :class="['form-group', errors['organization.phone'] ? 'has-error' : '']">
              <label for="phone">Телефон компании</label>
              <input
                v-model="item.organization.phone"
                type="text"
                class="form-control"
                id="text"
                placeholder="Введите телефон"
              >
              <span
                class="help-block"
                v-if="errors['phone']"
                :errors="errors"
              >{{ errors['organization.phone'][0] }}</span>
            </div>
          </div>
          <div class="col-md-12">
            <div :class="['form-group', errors['organization.org_description'] ? 'has-error' : '']">
              <label for="org_description">Описание компании</label>
              <textarea
                v-model="item.organization.org_description"
                type="text"
                class="form-control textarea-description"
                id="org_description"
              ></textarea>
              <span
                class="help-block"
                v-if="errors['organization.org_description']"
                :errors="errors"
              >{{ errors['organization.org_description'][0] }}</span>
            </div>
          </div>
        </div>
        <!-- <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                                <li :class="['pull-left', activeTab == 1 ? 'active':'']" @click="activeTab = 1"><a>Данные аккаунта</a></li>
                                <li :class="['pull-left', activeTab == 2 ? 'active':'']" @click="activeTab = 2"><a>Данные компании</a></li>
                            </ul>
                            <div class="tab-content no-padding">
                                <div :class="['tab-pane row', activeTab == 1 ? 'active':'']">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div :class="['form-group', errors['user.name'] ? 'has-error' : '']">
                                                <label for="name">Логин пользователя</label>
                                                <input v-model="item.user.name" type="text" class="form-control" id="name" placeholder="Введите логин">
                                                <span v-for class="help-block" v-if="errors['user.name']" :errors="errors">
                                                    {{ errors['user.name'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div :class="['form-group', errors['user.email'] ? 'has-error' : '']">
                                                <label for="email">Email пользователя</label>
                                                <input v-model="item.user.email" type="email" class="form-control" id="email" placeholder="Введите email">
                                                <span v-for class="help-block" v-if="errors['user.email']" :errors="errors">
                                                    {{ errors['user.email'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div :class="['form-group', errors['user.password'] ? 'has-error' : '']">
                                                <label for="password">Пароль пользователя</label>
                                                <input v-model="item.user.password" type="password" class="form-control" id="password" placeholder="Введите пароль">
                                                <span v-for class="help-block" v-if="errors['user.password']" :errors="errors">
                                                    {{ errors['user.password'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div :class="['tab-pane row', activeTab == 2 ? 'active':'']">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div :class="['form-group', errors['organization.org_type'] ? 'has-error' : '']">
                                                <label for="org_type">Тип организации</label>
                                                <select v-model="item.organization.org_type" name="org_type" class="form-control">
                                                    <option value="buyer" selected>Покупатель</option>
                                                    <option value="seller">Продавец</option>
                                                </select>
                                                <span v-for class="help-block" v-if="errors['organization.org_type']" :errors="errors">
                                                    {{ errors['organization.org_type'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div :class="['form-group', errors['organization.org_name'] ? 'has-error' : '']">
                                                <label for="org_name">Название организации/ЮР лица</label>
                                                <input v-model="item.organization.org_name" type="text" class="form-control" id="org_name" placeholder="Введите название">
                                                <span v-for class="help-block" v-if="errors['organization.org_name']" :errors="errors">
                                                    {{ errors['organization.org_name'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div :class="['form-group', errors['organization.org_inn'] ? 'has-error' : '']">
                                                <label for="org_inn">ИНН</label>
                                                <input v-model="item.organization.org_inn" type="text" class="form-control" id="org_inn" placeholder="Введите ИНН">
                                                <span v-for class="help-block" v-if="errors['organization.org_inn']" :errors="errors">
                                                    {{ errors['organization.org_inn'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div :class="['form-group', errors['organization.first_name'] ? 'has-error' : '']">
                                                <label for="first_name">Имя пользователя</label>
                                                <input v-model="item.organization.first_name" type="text" class="form-control" id="fisrt_name" placeholder="Введите имя пользователя">
                                                <span v-for class="help-block" v-if="errors['organization.first_name']" :errors="errors">
                                                    {{ errors['organization.first_name'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div :class="['form-group', errors['organization.second_name'] ? 'has-error' : '']">
                                                <label for="second_name">Фамилия пользователя</label>
                                                <input v-model="item.organization.second_name" type="text" class="form-control" id="second_name" placeholder="Введите фамилию пользователя">
                                                <span v-for class="help-block" v-if="errors['organization.second_name']" :errors="errors">
                                                    {{ errors['organization.second_name'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div :class="['form-group', errors['organization.middle_name'] ? 'has-error' : '']">
                                                <label for="middle_name">Отчество пользователя</label>
                                                <input v-model="item.organization.middle_name" type="text" class="form-control" id="middle_name" placeholder="Введите отчество пользователя">
                                                <span v-for class="help-block" v-if="errors['organization.middle_name']" :errors="errors">
                                                    {{ errors['organization.middle_name'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div :class="['form-group', errors['organization.phone'] ? 'has-error' : '']">
                                                <label for="phone">Номер телефона</label>
                                                <input v-model="item.organization.phone" type="text" class="form-control" id="phone" placeholder="Введите номер телефона">
                                                <span v-for class="help-block" v-if="errors['organization.phone']" :errors="errors">
                                                    {{ errors['organization.phone'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div :class="['form-group', errors['organization.org_city_id'] ? 'has-error' : '']">
                                                <label for="country">Страна</label>
                                                <select v-model="kladr.country" :disabled="kladr.countries.length == 0" v-on:change="getRegions()" name="country" class="form-control">
                                                    <option v-for="option in kladr.countries" v-bind:value="option.id">{{option.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div v-show="kladr.regions.length" class="col-md-4">
                                            <div :class="['form-group', errors['organization.org_city_id'] ? 'has-error' : '']">
                                                <label for="region">Регион/Область</label>
                                                <select v-model="kladr.region" :disabled="kladr.regions.length == 0" v-on:change="getCities()" name="region" class="form-control">
                                                    <option v-for="option in kladr.regions" v-bind:value="option.id">{{option.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div v-show="kladr.cities.length" class="col-md-4">
                                            <div :class="['form-group', errors['organization.org_city_id'] ? 'has-error' : '']">
                                                <label for="city">Город</label>
                                                <select v-model="item.organization.org_city_id" :disabled="kladr.cities.length == 0" name="city" class="form-control">
                                                    <option v-for="option in kladr.cities" v-bind:value="option.id">{{option.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-show="item.organization.org_type == 'seller'">
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div :class="['form-group', errors['organization.org_legal_form_id'] ? 'has-error' : '']">
                                                    <label for="legal_form">Правовая форма</label>
                                                    <select v-model="item.organization.org_legal_form_id" :disabled="legalForms.length == 0" name="legal_form" class="form-control">
                                                        <option v-for="option in legalForms" v-bind:value="option.id">{{option.name}}</option>
                                                    </select>
                                                    <span v-for class="help-block" v-if="errors['organization.org_legal_form_id']" :errors="errors">
                                                        {{ errors['organization.org_legal_form_id'][0] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div :class="['form-group', errors['organization.org_director'] ? 'has-error' : '']">
                                                    <label for="org_director">ФИО директора</label>
                                                    <input v-model="item.organization.org_director" type="text" class="form-control" id="org_director" placeholder="Введите ФИО генерального директора">
                                                    <span v-for class="help-block" v-if="errors['organization.org_director']" :errors="errors">
                                                        {{ errors['organization.org_director'][0] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div :class="['form-group', errors['organization.org_site'] ? 'has-error' : '']">
                                                    <label for="org_site">Веб сайт компании</label>
                                                    <input v-model="item.organization.org_site" type="text" class="form-control" id="org_site" placeholder="Введите URL на сайт компании">
                                                    <span v-for class="help-block" v-if="errors['organization.org_site']" :errors="errors">
                                                        {{ errors['organization.org_site'][0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div :class="['form-group', errors['organization.org_address'] ? 'has-error' : '']">
                                                    <label for="org_address">Юридический адрес</label>
                                                    <input v-model="item.organization.org_address" type="text" class="form-control" id="org_address" placeholder="Введите юридический адрес">
                                                    <span v-for class="help-block" v-if="errors['organization.org_address']" :errors="errors">
                                                        {{ errors['organization.org_address'][0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div :class="['form-group', errors['organization.org_address_legal'] ? 'has-error' : '']">
                                                    <label for="org_address_legal">Физический адрес</label>
                                                    <input v-model="item.organization.org_address_legal" type="text" class="form-control" id="org_address_legal" placeholder="Введите физический адрес">
                                                    <span v-for class="help-block" v-if="errors['organization.org_address_legal']" :errors="errors">
                                                        {{ errors['organization.org_address_legal'][0] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div :class="['form-group', errors['organization.org_description'] ? 'has-error' : '']">
                                                <label for="org_description">Описание компании</label>
                                                <textarea v-model="item.organization.org_description" type="text" class="form-control" id="org_description"></textarea>
                                                <span v-for class="help-block" v-if="errors['organization.org_description']" :errors="errors">
                                                    {{ errors['organization.org_description'][0] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>-->
        <div class="col-md-12 frm-buttons">
          <button
                  type="button"
                  v-on:click="showBalance=true"
                  class="btn btn-default"
          >Пополнить баланс пользователя</button>
          <completion-purse v-if="showBalance" @closecomponent="showBalance=false" :user="item.user"></completion-purse>

          <button
            type="button"
            class="btn btn-default"
            v-on:click="showScore=true"
          >Сформировать счёт</button>
          <scoreform :user="item.user" v-if="showScore" @closecomponent="showScore=false"/>
          <input class="btn btn-default" type="submit" value="Сохранить">



          <button
            type="button"
            v-on:click="showBlock=true"
            class="btn btn-default pull-right"
          >Изменить статус пользователя</button>
          <userblock v-if="showBlock" @closecomponent="showBlock=false" :user="item.user"></userblock>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</template>

<script>
import ViewMixins from "../../mixins/view";
import Treeselect from "@riophae/vue-treeselect";
import CompletionPurse from "../Components/completionPurse";

export default {
  mixins: [ViewMixins],
  components: {CompletionPurse, Treeselect },
  data() {
    return {
      categories: [],
      showBlock: false,
      showScore: false,
      showBalance: false,
      activeTab: 1,
      legalForms: [],
      kladr: {
        country: "",
        region: "",
        countries: [],
        regions: [],
        cities: []
      },
      item: {
        user: {
          name: "",
          email: "",
          phone: ""
        },
        organization: {
          categories: null,
          phone: "",
          org_name: "",
          org_inn: "",
          org_kpp: "",
          org_address: "",
          org_legal_form_id: "",
          org_director: "",
          org_type: "buyer",
          org_description: "",
          offices: [],
          stores: []
          //          org_address_legal: "",
          //          org_city_id: "",
          //          org_site: "",
          //          org_description: "",
          //          first_name: "",
          //          second_name: "",
          //          middle_name: "",
        }
      }
    };
  },
  mounted() {
    this.getUser();
    this.getCountries();
    this.getLegalForms();
    this.getCategories();
  },
  methods: {
    generateNewPassword(unique_id) {
      let params = { unique_id: unique_id, email: this.item.user.email };
      axios
        .post("/admin/api/clients/generate/user/password", { params })
        .then(resp => {
          if (resp.data.result === true) {
            this.messageSaved();
          } else {
            this.showError("Ошибка, попробуйте ещё раз");
          }
        });
    },
    generateNewID() {
      let params = { unique_id: this.item.user.unique_id };
      axios
        .post("/admin/api/clients/generate/user/uniqueid", { params })
        .then(resp => {
          if (resp.data.result === true) {
            this.messageSaved();
            this.item.user.unique_id = resp.data.unique_id;
          } else {
            this.showError("Ошибка сохранения, попробуйте ещё раз");
          }
        });
    },
    getNode(node) {
      return {
        id: node.id,
        label: node.name,
        children: node.items
      };
    },
    getCategories() {
      axios.get("/admin/api/categories").then(resp => {
        this.categories = resp.data;
      });
    },
    getLegalForms() {
      axios.get("/admin/api/orgs/legalforms").then(resp => {
        this.legalForms = resp.data;
      });
    },

    getCountries() {
      this.kladr.region = "";
      this.kladr.regions = [];
      this.item.organization.org_city_id = "";
      this.kladr.cities = [];

      axios.get("/admin/api/kladr/countries").then(resp => {
        this.kladr.countries = resp.data;
      });
    },

    getRegions() {
      this.kladr.region = "";
      this.kladr.regions = [];
      this.item.organization.org_city_id = "";
      this.kladr.cities = [];

      axios.get("/admin/api/kladr/regions/" + this.kladr.country).then(resp => {
        this.kladr.regions = resp.data;
      });
    },

    getCities() {
      this.item.organization.org_city_id = "";

      axios.get("/admin/api/kladr/cities/" + this.kladr.region).then(resp => {
        this.kladr.cities = resp.data;
      });
    },

    getUser() {
      axios
        .get("/admin/api/clients/edit/user/" + this.$route.params.id)
        .then(resp => {
          this.item = resp.data;
        })
        .catch(this.handleErrorResponse);
    },
    saveForm(event) {
      event.preventDefault();
      if(this.item.user.email==''){
        this.showError('Заполните E-mail')
      }else{
        axios
                .post("/admin/api/clients/update/user/" + this.$route.params.id, {
                  body: this.item
                })
                .then(resp => {
                  this.messageSaved();
                  this.$router.push({ name: "clients" });
                });
      }

    }
  }
};
</script>
<style>
.textarea-description {
  resize: vertical;
  height: 120px;
}
.client-status {
  text-transform: uppercase;
}
</style>
