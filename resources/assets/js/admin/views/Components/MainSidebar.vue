<template>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li>
          <router-link to="/admin/dashboard">
            <i class="fa fa-tachometer"></i>
            <span>Главная</span>
          </router-link>
        </li>
        <!-- <li>
          <router-link :to="{name: 'system'}">
            <i class="fa fa-rocket"></i>
            <span>Система</span>
          </router-link>
        </li>-->
        <li>
          <router-link :to="{name: 'analytics'}">
            <i class="fa fa-truck"></i>
            <span>Аналитика</span>
          </router-link>
        </li>
        <li v-if="this.$root.profile.permissions.adservice.show">
          <router-link :to="{name: 'ad.services'}">
            <i class="fa fa-credit-card"></i>
            <span>Платные услуги</span>
          </router-link>
        </li>

        <li>
          <router-link :to="{name: 'deals'}">
            <i class="fa fa-bank"></i>
            <span>Сделки</span>
          </router-link>
        </li>

        <li>
          <router-link :to="{name: 'deals.moderation'}">
            <i class="fa fa-bank"></i>
            <span>Модерация</span>
          </router-link>
        </li>
        <li class="treeview">
          <a href>
            <i class="fa fa-table"></i>
            <span>Справочники</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <router-link
                v-if="this.$root.profile.permissions.kladr.show"
                :to="{name: 'kladr.list'}"
              >
                <i class="fa fa-circle-o"></i>КЛАДР
              </router-link>
            </li>
            <li>
              <router-link
                v-if="this.$root.profile.permissions.dealquestion.show"
                :to="{name: 'deals.questions'}"
              >
                <i class="fa fa-circle-o"></i>Вопросы к сделкам
              </router-link>
            </li>
            <li>
              <router-link
                v-if="this.$root.profile.permissions.legalforms.show"
                :to="{name: 'orgs.legalforms'}"
              >
                <i class="fa fa-circle-o"></i>Формы организаций
              </router-link>
            </li>
            <li>
              <router-link
                v-if="this.$root.profile.permissions.categories.show"
                :to="{name: 'rubricator'}"
              >
                <i class="fa fa-circle-o"></i>Рубрикатор
              </router-link>
            </li>
          </ul>
        </li>

        <li class="treeview">
          <router-link v-if="this.$root.profile.permissions.clients.show" :to="{name: 'clients'}">
            <i class="fa fa-circle-o"></i>Клиенты
          </router-link>
        </li>
        <li v-if="this.$root.profile.permissions.publications.show" class="treeview">
          <a href>
            <i class="fa fa-edit"></i>
            <span>Размещения</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!--<li>-->
            <!--<router-link :to="{name: 'deals'}"><i class="fa fa-circle-o"></i>Сделки</router-link>-->
            <!--</li>-->
            <li>
              <router-link :to="{name: 'news.list'}">
                <i class="fa fa-circle-o"></i>Новости
              </router-link>
            </li>
            <li>
              <router-link :to="{name: 'stock.list'}">
                <i class="fa fa-circle-o"></i>Акции
              </router-link>
            </li>
          </ul>
        </li>
        <li v-if="this.$root.profile.permissions.feedback.show" class="treeview">
          <a href>
            <i class="fa fa-paper-plane"></i>
            <span>Обращения</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="counter-item">
              <router-link :to="{name: 'feedback.reports'}">
                <i class="fa fa-circle-o"></i>Жалобы
              </router-link>
              <span class="label label-primary sub-item--counter">{{this.$root.feedcount.report}}</span>
            </li>
            <li class="counter-item">
              <router-link :to="{name: 'feedback.messages'}">
                <i class="fa fa-circle-o"></i>Обращения
              </router-link>
              <span class="label label-primary sub-item--counter">{{this.$root.feedcount.feed}}</span>
            </li>
          </ul>
        </li>
        <li>
          <router-link v-if="this.$root.profile.permissions.users.show" :to="{name: 'users'}">
            <i class="fa fa-circle-o"></i>Сотрудники
          </router-link>
        </li>
        <li>
          <router-link v-if="this.$root.profile.permissions.users.show" :to="{name: 'users.ticket'}">
            <i class="fa fa-circle-o"></i>Создать тикет
          </router-link>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
export default {
  name: "MainSidebar",
  mounted() {
    //$('ul').tree();
    $(window).trigger("resize");
    $(window).trigger("load");
  }
};
</script>

<style scoped>
.sub-item--counter {
  position: absolute;
  top: 9px;
  right: 0px;
}
.counter-item {
  position: relative;
}
</style>
