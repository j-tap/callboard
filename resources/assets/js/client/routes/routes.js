// Main Router
import RegisterRoutes from "./routes.auth";
import LkRoutes from "./routes.lk";
import BidsRoutes from "./routes.bids";
import UsersRoutes from "./routes.users";
import CompaniesRoutes from "./routes.companies";
import Login from "../views/Auth/Login";
import Home from "../views/Home/Home";
import Register from "../views/Auth/Register";
import Lk from "../views/LK/Lk";
import Bids from "../views/Catalog/Bids";
import NewBid from "../views/NewDeal/NewBid";
import Users from "../views/Users/Users";
import Companies from "../views/Companies/Companies";
import paymentinfo from "../views/GeneralComponents/paymentinfo.vue";
import Page404 from "../views/Page404";
import Tarifs from "../views/Tarifs";

const routes = [
  {
    path: "/about",
    name: "home",
    component: Home,
    meta: {
      title: `${APPNAME} - О нас`,
      metaTags: [
        {
          name: "description",
          content: "Сервис tamtem"
        },
        {
          property: "og:description",
          content: "Сервис tamtem"
        }
      ]
    }
  },
  {
    path: "/auth/login",
    name: "login",
    component: Login,
    meta: {
      title: `${APPNAME} - Авторизация администратора`
    }
  },
  {
    path: "/signup",
    name: "register",
    redirect: "signup",
    component: Register,
    meta: {
      breadcrumb: false,
      title: `${APPNAME} - Регистрация`,
      auth: false
    },
    children: RegisterRoutes
  },
  {
    path: "/lk",
    name: "lk",
    component: Lk,
    redirect: "lk/profile",
    meta: {
      breadcrumb: false,
      title: `${APPNAME} - Личный кабинет`,
      auth: true
    },
    children: LkRoutes
  },
  {
    path: "/",
    name: "bids",
    redirect: "bids.list",
    component: Bids,
    meta: {
      title: `${APPNAME} - Заявки`
    },
    children: BidsRoutes
  },
  {
    path: "/newbid",
    name: "new.bid",
    component: NewBid,
    meta: {
      title: `${APPNAME} - Новая заявка`,
      auth: true
    }
  },
  {
    path: "/users",
    name: "users",
    redirect: "users.list",
    component: Users,
    meta: {
      title: `${APPNAME} - Пользователи`,
      breadcrumb: false
    },
    children: UsersRoutes
  },
  {
    path: "/companies",
    name: "companies",
    redirect: "companies.list",
    component: Companies,
    meta: {
      title: `${APPNAME} - Компании`,
      breadcrumb: false
    },
    children: CompaniesRoutes
  },
  {
    path: "/paymentinfo",
    name: "paymentinfo",
    component: paymentinfo,
    meta: {
      title: `${APPNAME} - Платежная информация`,
      breadcrumb: false
    }
  },
  {
    path: "/tarifs",
    name: "tarifs",
    component: Tarifs,
    meta: {
      title: `${APPNAME} - Тарифы и услуги`,
      breadcrumb: false
    }
  },
  {
    path: "/404",
    name: "page404",
    component: Page404,
    meta: {
      title: `${APPNAME} - Страница не найдена`
    }
  },
  {
    path: "*",
    redirect: "/404"
  }
];

export default routes;
