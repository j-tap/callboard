// ToDo - add api routes

var mixins = {
  created() {},
  methods: {
    getPermissionLocale(permission) {
      switch (permission) {
        case "buy":
          return "Покупка";
        case "add":
          return "Добавление";
        case "show":
          return "Просмотр";
        case "view":
          return "Просмотр записи";
        case "create":
          return "Создание";
        case "edit":
          return "Редактирование";
        case "delete":
          return "Удаление";
        case "moderate":
          return "Премодерация";
        default:
          break;
      }
    },

    getRoleArray() {
      return {
        administrator: "Администратор",
        moderator: "Модератор",
        client: "Клиент",
        client_worker: "Работник"
      };
    },

    getOrgStatusArray() {
      return {
        approve: "Подтвержден",
        archive: "Архивный",
        register: "Зарегистрирован",
        banned: "Заблокирован"
      };
    },

    getOrgStatus(status) {
      switch (status) {
        case "register":
          return "Зарегистрирован";
        case "approve":
          return "Подтвержден";
        case "archive":
          return "Архивный";
        case "banned":
          return "Заблокирован";
        default:
          break;
      }

      return "";
    },

    getOrgType(status) {
      switch (status) {
        case "seller":
          return "Поставщик";
        case "buyer":
          return "Покупатель";
        default:
          break;
      }

      return "";
    }
  }
};

export default mixins;
