import MainView from "./views/MainView";
import NotFound from "./views/NotFound";
import System from "./views/System";
import Analytics from "./views/Analytics";

import DealsQuestions from "./views/Deals/Questions/DealsQuestions";
import DealsQuestionsCreate from "./views/Deals/Questions/DealsQuestionsCreate";
import DealsQuestionsEdit from "./views/Deals/Questions/DealsQuestionsEdit";

import LegalForms from "./views/LegalForms/LegalForms";
import LegalFormsCreate from "./views/LegalForms/LegalFormsCreate";
import LegalFormsEdit from "./views/LegalForms/LegalFormsEdit";

import Rubricator from "./views/Rubricator/Rubricator";
import RubricatorCreate from "./views/Rubricator/RubricatorCreate";
import RubricatorEdit from "./views/Rubricator/RubricatorEdit";

import UsersClients from "./views/Users/UsersClients";
import UsersClientsEdit from "./views/Users/UsersClientsEdit";
import Users from "./views/Users/Users";
import UsersCreate from "./views/Users/UsersCreate";
import UsersEdit from "./views/Users/UsersEdit";


import Clients from "./views/Clients/Clients";
import ClientsCreate from "./views/Clients/ClientsCreate";
import ClientsView from "./views/Clients/ClientsView";
import ClientsEdit from "./views/Clients/ClientsEdit";

import Kladr from "./views/Kladr/Kladr";
import KladrCreate from "./views/Kladr/KladrCreate";
import KladrEdit from "./views/Kladr/KladrEdit";

import News from "./views/News/News";
import NewsCreate from "./views/News/NewsCreate";
import NewsEdit from "./views/News/NewsEdit";

import Feedback from "./views/Feedback/Feed";
import FeedbackView from "./views/Feedback/FeedView";

import AdServices from "./views/AdService";

import Deals from "./views/Deals/Deals";
import DealsView from "./views/Deals/DealsView";
import ModerationDeals from "./views/Deals/ModerationDeals";
import ModerationDealsView from "./views/Deals/ModerationDealsView";
import SendTicket from "./views/Users/SendTicket";

const routes = [
    {
        path: "/admin/",
        name: "redirect.home",
        redirect: "/admin/dashboard"
    },
    {
        path: "/admin/dashboard",
        name: "home",
        component: MainView,
        meta: {
            title: "Dashboard"
        }
    },
    // {
    //   path: "/admin/system",
    //   name: "system",
    //   component: System,
    //   meta: {
    //     title: "Система",
    //     breadcrumbs: [{ name: "Система" }]
    //   }
    // },
    {
        path: "/admin/analytics",
        name: "analytics",
        component: Analytics,
        meta: {
            title: "Аналитика",
            breadcrumbs: [{name: "Аналитика"}]
        }
    },
    //
    {
        path: "/admin/deals/questions",
        name: "deals.questions",
        meta: {
            title: "Вопросы к сделкам",
            breadcrumbs: [{name: "Вопросы к сделкам"}],
            permission: "dealquestion.show"
        },
        component: DealsQuestions
    },
    {
        path: "/admin/deals/questions/create",
        name: "deals.questions.create",
        meta: {
            title: "Новый вопрос",
            breadcrumbs: [
                {name: "Вопросы к сделкам", path: "deals.questions"},
                {name: "Новый вопрос"}
            ],
            permission: "dealquestion.create"
        },
        component: DealsQuestionsCreate
    },
    {
        path: "/admin/deals/questions/edit/:id",
        name: "deals.questions.edit",
        meta: {
            title: "Редактирование вопроса",
            breadcrumbs: [
                {name: "Вопросы к сделкам", path: "deals.questions"},
                {name: "Редактирование вопроса"}
            ],
            permission: "dealquestion.edit"
        },
        component: DealsQuestionsEdit
    },
    //
    {
        path: "/admin/legalforms",
        name: "orgs.legalforms",
        meta: {
            title: "Правовые формы организаций",
            breadcrumbs: [{name: "Правовые формы организаций"}],
            permission: "legalforms.show"
        },
        component: LegalForms
    },
    {
        path: "/admin/legalforms/create",
        name: "orgs.legalforms.create",
        meta: {
            title: "Новая форма",
            breadcrumbs: [
                {name: "Правовые формы организаций", path: "orgs.legalforms"},
                {name: "Новая форма"}
            ],
            permission: "legalforms.create"
        },
        component: LegalFormsCreate
    },
    {
        path: "/admin/legalforms/edit/:id",
        name: "orgs.legalforms.edit",
        meta: {
            title: "Редактирование формы",
            breadcrumbs: [
                {name: "Правовые формы организаций", path: "orgs.legalforms"},
                {name: "Редактирование формы"}
            ],
            permission: "legalforms.edit"
        },
        component: LegalFormsEdit
    },
    //
    {
        path: "/admin/rubricator",
        name: "rubricator",
        meta: {
            title: "Рубрикатор",
            breadcrumbs: [{name: "Рубрикатор"}],
            permission: "categories.show"
        },
        component: Rubricator
    },
    {
        path: "/admin/rubricator/create/:id?",
        name: "rubricator.create",
        meta: {
            title: "Новая рубрика",
            breadcrumbs: [
                {name: "Рубрикатор", path: "rubricator"},
                {name: "Новая рубрика"}
            ],
            permission: "categories.create"
        },
        component: RubricatorCreate
    },
    {
        path: "/admin/rubricator/edit/:id",
        name: "rubricator.edit",
        meta: {
            title: "Редактирование рубрики",
            breadcrumbs: [
                {name: "Рубрикатор", path: "rubricator"},
                {name: "Редактирование рубрики"}
            ],
            permission: "categories.edit"
        },
        component: RubricatorEdit
    },
    //
    {
        path: "/admin/users",
        name: "users",
        meta: {
            title: "Сотрудники",
            breadcrumbs: [{name: "Сотрудники"}],
            permission: "users.show"
        },
        component: Users
    },

    {
        path: "/admin/users/ticket/create",
        name: "users.ticket",
        meta: {
            title: "Создание тикета",
            breadcrumbs: [{name: "Создание тикета"}],
            permission: "users.show"
        },
        component: SendTicket
    },
    // {
    //   path: "/admin/users/clients",
    //   name: "users.clients",
    //   meta: {
    //     title: "Пользователи клиентов",
    //     breadcrumbs: [{ name: "Пользователи клиентов" }],
    //     permission: "users.show"
    //   },
    //   component: UsersClients
    // },
    {
        path: "/admin/users/create",
        name: "users.create",
        meta: {
            title: "Новый сотрудник",
            breadcrumbs: [
                {name: "Сотрудники", path: "users"},
                {name: "Новый сотрудник"}
            ],
            permission: "users.create"
        },
        component: UsersCreate
    },
    {
        path: "/admin/users/edit/:id",
        name: "users.edit",
        meta: {
            title: "Редактирование сотрудника",
            breadcrumbs: [
                {name: "Сотрудники", path: "users"},
                {name: "Редактирование"}
            ],
            permission: "users.edit"
        },
        component: UsersEdit
    },
    // {
    //   path: "/admin/users/clients/edit/:id",
    //   name: "users.clients.edit",
    //   meta: {
    //     title: "Редактирование сотрудника клиента",
    //     breadcrumbs: [
    //       { name: "Пользователи клиентов", path: "users.clients" },
    //       { name: "Редактирование" }
    //     ],
    //     permission: "users.edit"
    //   },
    //   component: UsersClientsEdit
    // },
    //
    {
        path: "/admin/clients",
        name: "clients",
        meta: {
            title: "Клиенты",
            breadcrumbs: [{name: "Клиенты"}],
            props: {
                client_type: "seller"
            },
            permission: "clients.show"
        },
        component: Clients
    },
    // {
    //   path: "/admin/clients/customers",
    //   name: "clients.customers",
    //   meta: {
    //     title: "Пользователи покупатели",
    //     breadcrumbs: [{ name: "Пользователи покупатели" }],
    //     props: {
    //       client_type: "buyer"
    //     },
    //     permission: "clients.show"
    //   },
    //   component: Clients
    // },
    {
        path: "/admin/clients/create",
        name: "clients.create",
        meta: {
            title: "Новый клиент",
            breadcrumbs: [
                {name: "Клиенты", path: "clients"},
                {name: "Новый клиент"}
            ],
            permission: "clients.create"
        },
        component: ClientsCreate
    },
    // {
    //   path: "/admin/clients/view/:id",
    //   name: "clients.view",
    //   meta: {
    //     title: "Данные клиента - организации",
    //     breadcrumbs: [{ name: "Данные организации" }],
    //     permission: "clients.view"
    //   },
    //   component: ClientsView
    // },
    {
        path: "/admin/clients/edit/:id",
        name: "clients.edit",
        meta: {
            title: "Редактирование клиента",
            breadcrumbs: [
                {name: "Клиенты", path: "clients"},
                {name: "Редактирование клиента"}
            ],
            permission: "clients.edit"
        },
        component: ClientsEdit
    },
    //
    {
        path: "/admin/kladr/items/:country?/:region?",
        name: "kladr.list",
        meta: {
            title: "КЛАДР",
            breadcrumbs: [{name: "КЛАДР", path: "kladr.list"}],
            permission: "kladr.show"
        },
        component: Kladr
    },
    {
        path: "/admin/kladr/create/:country?/:region?",
        name: "kladr.create",
        meta: {
            title: "Новый элемент КЛАДРа",
            breadcrumbs: [{name: "КЛАДР", path: "kladr.list"}],
            permission: "kladr.create"
        },
        component: KladrCreate
    },
    {
        path: "/admin/kladr/edit/:country?/:region?/:city?",
        name: "kladr.edit",
        meta: {
            title: "Редактирование элемента КЛАДРа",
            breadcrumbs: [{name: "КЛАДР", path: "kladr.list"}],
            permission: "kladr.edit"
        },
        component: KladrEdit
    },

    {
        path: "/admin/news",
        name: "news.list",
        meta: {
            title: "Новости",
            breadcrumbs: [{name: "Новости", path: "news.list"}],
            permission: "publications.show"
        },
        component: News
    },
    {
        path: "/admin/stock",
        name: "stock.list",
        meta: {
            title: "Акции",
            breadcrumbs: [{name: "Акции", path: "stock.list"}],
            props: {
                stock: true
            },
            permission: "publications.show"
        },
        component: News
    },
    {
        path: "/admin/news/create",
        name: "news.create",
        meta: {
            title: "Новая новость",
            breadcrumbs: [
                {name: "Новости", path: "news.list"},
                {name: "Новая новость"}
            ],
            permission: "publications.create"
        },
        component: NewsCreate
    },
    {
        path: "/admin/stock/create",
        name: "stock.create",
        meta: {
            title: "Новая акция",
            breadcrumbs: [
                {name: "Новости", path: "stock.list"},
                {name: "Новая акция"}
            ],
            props: {
                stock: true
            },
            permission: "publications.create"
        },
        component: NewsCreate
    },
    {
        path: "/admin/news/edit/:id",
        name: "news.edit",
        meta: {
            title: "Редактирование новости",
            breadcrumbs: [
                {name: "Новости", path: "news.list"},
                {name: "Радактирование новости"}
            ],
            permission: "publications.edit"
        },
        component: NewsEdit
    },
    {
        path: "/admin/stock/edit/:id",
        name: "stock.edit",
        meta: {
            title: "Редактирование акции",
            breadcrumbs: [
                {name: "Новости", path: "stock.list"},
                {name: "Радактирование акции"}
            ],
            props: {
                stock: true
            },
            permission: "publications.edit"
        },
        component: NewsEdit
    },
    {
        path: "/admin/feedback/view/:id",
        name: "feedback.view",
        meta: {
            title: "Обращение",
            breadcrumbs: [{name: "Обращение в поддержку"}, {name: "Обращение"}],
            permission: "feedback.show"
        },
        component: FeedbackView
    },
    {
        path: "/admin/feedback/reports",
        name: "feedback.reports",
        meta: {
            title: "Жалобы",
            breadcrumbs: [{name: "Жалобы"}],
            props: {
                reports: true
            },
            permission: "feedback.show"
        },
        component: Feedback
    },
    {
        path: "/admin/feedback/messages",
        name: "feedback.messages",
        meta: {
            title: "Обращения",
            breadcrumbs: [{name: "Обращения"}],
            props: {
                reports: false
            },
            permission: "feedback.show"
        },
        component: Feedback
    },
    {
        path: "/admin/ad/services",
        name: "ad.services",
        meta: {
            title: "Платные услуги",
            breadcrumbs: [{name: "Платные услуги"}],
            permission: "adservice.show"
        },
        component: AdServices
    },
    {
        path: "/admin/deals",
        name: "deals",
        meta: {
            title: "Сделки",
            breadcrumbs: [{name: "Сделки"}],
            permission: "publications.show"
        },
        component: Deals
    },
    {
        path: "/admin/deals/:id",
        name: "deals.view",
        meta: {
            title: "Сделка",
            breadcrumbs: [{name: "Сделки", path: "deals"}, {name: "Сделка"}],
            permission: "publications.show"
        },
        component: DealsView
    },

    {
        path: "/admin/deals/show/moderation",
        name: "deals.moderation",
        meta: {
            title: "Модерация сделок",
            breadcrumbs: [{name: "Модерация сделок", path: "deals"}, {name: "Сделка"}],
            permission: "publications.show"
        },
        component: ModerationDeals
    },
    {
        path: "/admin/deals/show/moderation/:id",
        name: "deals.moderation.view",
        meta: {
            title: "Модерация сделки",
            breadcrumbs: [{name: "Модерация сделки", path: "deals"}, {name: "Сделка"}],
            permission: "publications.show"
        },
        component: ModerationDealsView
    },


    // 404
    {
        path: "*",
        name: "notfound",
        meta: {
            title: "404 - Not Found",
            breadcrumbs: [{name: "404"}]
        },
        component: NotFound
    }
];

export default routes;
