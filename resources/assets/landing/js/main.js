function navtoggle() {
  let item = document.getElementById("mobnav");
  if (item.classList.contains("visible")) {
    item.classList.remove("visible");
  } else {
    item.classList.add("visible");
  }
}

// смена отображаемой стороны в секции с формой заявки
function changeside() {
  let sect = document.getElementById("third");

  if (sect.classList && sect.classList.contains("righted")) {
    sect.classList.remove("righted");
  } else {
    sect.classList.add("righted");
  }
}

// переход на тамтем в поиск
function submitSearchForm(event) {
  event.preventDefault();
  event.stopPropagation();
  let query = event.target["searchString"].value;
  let type_deal = event.target["isbuying"].checked ? "buy" : "sell";

  let url =
    "?search=" +
    query +
    "&city&category&type_deal=" +
    type_deal +
    "&date_created=desc";
  let link = document.createElement("a");
  link.href = url;
  link.dispatchEvent(
    new MouseEvent(`click`, { bubbles: true, cancelable: true, view: window })
  );
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener("click", function(e) {
    e.preventDefault();

    document.querySelector(this.getAttribute("href")).scrollIntoView({
      behavior: "smooth"
    });
  });
});

// оставить заявку без регистрации
function additem(event) {
  event.preventDefault();
  event.stopPropagation();

  let data = {
    text: event.target["description"].value,
    email: event.target["email"].value,
    phone: event.target["phone"].value
      .replace(new RegExp(/['+','\-',' ','(',')']/, "g"), "")
      .replace("7", ""),
    agreement: event.target["agreement"].checked
  };

  // оставить заявку
  let url = "/api/v1/landingorder";

  axios
    .post(url, { data: data })
    .then(response => {
      // console.log(response);
      if (response.data && response.data.result == true) {
        showNotification("success", "Спасибо за заявку");
      } else {
        let text = "Данный E-mail уже зарегистрирован";
        if (response.data.error == text) {
          showNotification(
            "error",
            " Вы уже зарегистрированы на сайте. Войдите под своей учетной записью."
          );
        } else {
          showNotification("error", "Произошла ошибка, попробуйте позднее");
        }
      }
    })
    .catch(e => {
      console.log(e);
      showNotification("error", "Произошла ошибка, попробуйте позднее");
    });
}

// заказ обратного звонка
function callback(event) {
  event.preventDefault();
  event.stopPropagation();

  if (event.target["name"].value != "") {
    return false;
  } else {
    let phone = event.target["phone"].value;

    phone = phone
      .replace(new RegExp(/['+','\-',' ','(',')']/, "g"), "")
      .replace("7", "");

    let url = "/api/v1/user/callme";

    axios
      .post(url, { phone: phone })
      .then(response => {
        console.log(response);
        if (response.data && response.data.result == true) {
          showNotification("success", "Спасибо, мы вам перезвоним");
        } else {
          showNotification("error", "Произошла ошибка, попробуйте позднее");
        }
      })
      .catch(e => {
        console.log(e);
        showNotification("error", "Произошла ошибка, попробуйте позднее");
      });
  }
}
// маска телефона (при изменении)
function phoneMasking(input) {
  let phone = "";

  let digitalise = input.value.replace(/[^0-9]/gi, "");
  if (digitalise.length > 10) {
    phone = digitalise.slice(1, 11);
  }
  let res = "";

  res = phone.replace(/^(\d{3})(\d{3})(\d{2})(\d{2})$/, "+7 ($1) $2-$3-$4");

  input.value = res;
}

// маска email (при изменении)
function emailMasking(input) {
  let email = input.value;

  let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  let result = re.test(String(email).toLowerCase());
  if (result === false) {
    input.value = "";
  }
}
// клик на чекбокс согласия (обьрабатывается отдельно, т. к. чекбокс сделан через css)
function agreementTest(checkbox) {
  let res = checkbox.checked;
  let parent = checkbox.parentNode;
  if (!res) {
    parent.classList.add("error");
  } else {
    parent.classList.remove("error");
  }
}

function showNotification(type, text) {
  let container = document.getElementById("notification");
  let visibilityClass = "visible-notification";
  let newClass =
    type == "error" ? "notification-error" : "notification-success";

  if (!container) {
    return false;
  } else {
    let textContainer = document.getElementById("notification-text");

    container.classList.add(visibilityClass);
    container.classList.add(newClass);
    textContainer.textContent = text;
    setTimeout(() => {
      container.classList.remove(visibilityClass);
      container.classList.remove(newClass);
      textContainer.textContent = "";
    }, 2000);
  }
}
