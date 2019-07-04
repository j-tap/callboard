<template>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form class="row box-body" @submit="saveForm">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li :class="['pull-left', activeTab == 1 ? 'active':'']" @click="activeTab = 1">
                <a>Данные аккаунта</a>
              </li>
              <li :class="['pull-left', activeTab == 2 ? 'active':'']" @click="activeTab = 2">
                <a>Права пользователя</a>
              </li>
            </ul>
            <div class="tab-content no-padding">
              <div :class="['tab-pane row', activeTab == 1 ? 'active':'']">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div :class="['form-group', errors['user.name'] ? 'has-error' : '']">
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
                        v-if="errors['user.name']"
                        :errors="errors"
                      >{{ errors['user.name'][0] }}</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div :class="['form-group', errors['user.email'] ? 'has-error' : '']">
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
                        v-if="errors['user.email']"
                        :errors="errors"
                      >{{ errors['user.email'][0] }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div :class="['form-group', errors['user.password'] ? 'has-error' : '']">
                      <label for="password">Пароль пользователя</label>
                      <input
                        v-model="item.user.password"
                        type="password"
                        class="form-control"
                        id="password"
                        placeholder="Введите пароль"
                      >
                      <span
                        class="help-block"
                        v-if="errors['user.password']"
                        :errors="errors"
                      >{{ errors['user.password'][0] }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div :class="['form-group', errors['user.role'] ? 'has-error' : '']">
                      <label for="role">Роль учетной записи</label>
                      <select v-model="item.user.role" id="role" class="form-control">
                        <option value="administrator" selected>Администратор</option>
                        <option value="moderator">Модератор</option>
                      </select>
                      <span
                        class="help-block"
                        v-if="errors['user.role']"
                        :errors="errors"
                      >{{ errors['user.role'][0] }}</span>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div :class="['form-group', errors['user.status'] ? 'has-error' : '']">
                      <label for="status">Статус учетной записи</label>

                      <select v-model="item.user.status" id="status" class="form-control">
                        <option
                          :key="key"
                          v-for="item,key in getOrgStatusArray()"
                          :value="key"
                        >{{item}}</option>
                      </select>
                      <span
                        class="help-block"
                        v-if="errors['user.status']"
                        :errors="errors"
                      >{{ errors['user.status'][0] }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <div v-if="this.permissions" :class="['tab-pane row', activeTab == 2 ? 'active':'']">
                <div v-for="permission in this.permissions" class="col-md-12">
                  <div class="col-md-4">
                    <div class="form-group">{{permission.name}}</div>
                  </div>
                  <div class="col-md-8">
                    <div v-for="permissionEl in permission.permissions" class="col-md-12">
                      <div class="form-group">
                        <input
                          v-model="item.permissions[permission.slug][permissionEl]"
                          type="checkbox"
                        >
                        {{getPermissionLocale(permissionEl)}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 frm-buttons">
          <input class="btn btn-default pull-right" type="submit" value="Добавить">
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</template>

<script>
import ViewMixins from "../../mixins/view";

export default {
  mixins: [ViewMixins],
  data() {
    return {
      activeTab: 1,
      errors: {},
      item: {
        user: {
          name: "",
          email: "",
          password: "",
          status: "",
          role: ""
        },
        permissions: {
          kladr: {},
          dealquestion: {},
          categories: {},
          legalforms: {},
          users: {},
          clients: {},
          publications: {}
        }
      },
      permissions: {}
    };
  },
  mounted() {
    this.getPermissions();
  },
  methods: {
    saveForm(event) {
      event.preventDefault();

      axios
        .post("/admin/api/users/store", this.item)
        .then(resp => {
          this.messageCreated();
          this.$router.push({ name: "users" });
        })
        .catch(error => {
          this.handleErrorResponse();
        });
    },

    getPermissions() {
      axios.get("/admin/api/permissions").then(function(resp) {
        for (var prop in resp.data) {
          var slug = resp.data[prop].slug;
          this.item.permissions[slug] = {};
        }

        this.permissions = resp.data;

        this.$forceUpdate();
      });
    }
  }
};
</script>