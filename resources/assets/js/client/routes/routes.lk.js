import LkProfile from "../views/LK/views/LkProfile";
import LkProfileEdit from "../views/LK/views/LkProfileEdit";
import LkPassword from "../views/LK/views/LkPassword";
import MyBids from "../views/LK/views/MyBids";
import MyBidsEdit from "../views/LK/views/MyBidsEdit";
import LkCompany from "../views/LK/views/LkCompany";
import LkCompanyEdit from "../views/LK/views/LkCompanyEdit";
import LkCompanyCreate from "../views/LK/views/LkCompanyCreate";
import LkDialogs from "../views/LK/views/LkDialogs";
import LkDialogPrivate from "../views/LK/views/LkDialogPrivate";
import MyFavorites from "../views/LK/views/MyFavorites";
import LkDeleted from "../views/LK/views/Deleted";
import LkWallet from "../views/LK/views/LkWallet";
import LkWalletHistory from "../views/LK/views/LkWalletHistory";
import LkTarifs from "../views/LK/views/LkTarifs";
import LkTarifsCheckout from "../views/LK/views/LkTarifsCheckout";

const routes = [
  {
    path: "/lk/profile",
    name: "lk.profile",
    component: LkProfile,
    meta: {
      title: "Профиль"
    }
  },
  {
    path: "/lk/profile/edit",
    name: "lk.profile.edit",
    component: LkProfileEdit,
    meta: {
      title: "Изменить профиль"
    }
  },
  {
    path: "/lk/profile/password",
    name: "lk.profile.password",
    component: LkPassword,
    meta: {
      title: "Изменить пароль"
    }
  },
  {
    path: "/lk/bids",
    name: "lk.deals",
    component: MyBids,
    meta: {
      title: "Мои заявки"
    }
  },
  {
    path: "/lk/bids/:id",
    name: "lk.deals.edit",
    component: MyBidsEdit,
    meta: {
      title: "Редактировать заявку"
    }
  },
  {
    path: "/lk/company",
    name: "lk.company",
    component: LkCompany,
    meta: {
      title: "Моя компания"
    }
  },
  {
    path: "/lk/wallet",
    name: "lk.wallet",
    component: LkWallet,
    meta: {
      title: `${APPNAME} - Мой кошелёк`
    }
  },
  {
    path: "/lk/wallet/history",
    name: "lk.wallet.history",
    component: LkWalletHistory,
    meta: {
      title: `${APPNAME} - История платежей`
    }
  },
  {
    path: "/lk/tarifs",
    name: "lk.tarifs",
    component: LkTarifs,
    meta: {
      title: `${APPNAME} - Тарифы и услуги`
    }
  },
  {
    path: "/lk/tarifs/:id",
    name: "lk.tarifs.checkout",
    component: LkTarifsCheckout,
    meta: {
      title: `${APPNAME} - Оплата`
    },
    props: route => ({ id: route.params.id })
  },

  {
    path: "/lk/company/edit",
    name: "lk.company.edit",
    component: LkCompanyEdit,
    meta: {
      title: `${APPNAME} - Редактирование компании`
    }
  },
  {
    path: "/lk/company/create",
    name: "lk.company.create",
    component: LkCompanyCreate,
    meta: {
      title: `${APPNAME} - Создание компании`
    }
  },
  {
    path: "/lk/dialogs",
    name: "lk.dialogs",
    component: LkDialogs,
    meta: {
      title: `${APPNAME} - Диалоги`
    }
  },
  {
    path: "/lk/dialogs/:id",
    name: "lk.dialogs.private",
    component: LkDialogPrivate,
    meta: {
      title: `${APPNAME} - Сообщения`
    }
  },
  {
    path: "/lk/favorites",
    name: "lk.favorites",
    component: MyFavorites,
    meta: {
      title: `${APPNAME} - Избранные заявки`
    }
  },
  {
    path: "/lk/deleted",
    name: "lk.deleted",
    component: LkDeleted,
    meta: {
      title: `${APPNAME} - Завершённые заявки`
    }
  }
]

export default routes;
