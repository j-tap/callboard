<template>
  <section class="container">
    <div class="row">
      <div class="col-lg-3 d-none d-lg-block" v-if="$root.profile">
        <Aside>
          <lkNavigation />
        </Aside>
      </div>
      <div
        :class="{'public':!$root.profile}"
        class="col-md-12 col-lg-9 col-content position-relative"
      >
        <div class="card">
          <div class="information">
            <h3>Платёжная информация</h3>
            <v-expansion-panel>
              <v-expansion-panel-content expand-icon="expand_more">
                <template v-slot:header>
                  <h6>Данные о юридическом лице Предприятия</h6>
                </template>
                <v-card>
                  <v-card-text>
                    <p>
                      <span>Наименование:</span> Общество с ограниченной отвественностью «Акстек»
                    </p>
                    <p>
                      <span>ИНН/КПП:</span> 7842166070/784201001
                    </p>
                    <p>
                      <span>ОГРН:</span> 1187847338920
                    </p>
                    <p>
                      <span>Юридический адрес:</span> 191124, г. Санкт-Петербург, ул. Новгородская, д. 19, лит. А, пом. 3Н, оф.8.
                    </p>
                    <p>
                      <span>Контактный номер телефона:</span>
                      <a href="tel:+78007001476">8 800 700 14 76</a>
                    </p>
                    <p>
                      <span>Контактный e-mail:</span>
                      <a href="mailto:itf@tamtem.ru">itf@tamtem.ru</a>
                    </p>
                  </v-card-text>
                </v-card>
              </v-expansion-panel-content>
              <v-expansion-panel-content expand-icon="expand_more">
                <template v-slot:header>
                  <h6>Регистрационная форма для клиента</h6>
                </template>
                <v-card>
                  <v-card-text>
                    <div class="item">
                      <p>Клиент в строке адреса браузера вводит наименование сайта: https://tamtem.ru и в верхней части сайта нажимает левой кнопкой мыши на кнопку с названием "Регистрация/Войти", изображенную на рис. 1.</p>
                      <figure>
                        <img src="/images/payment-info/1.png" alt />
                        <figcaption>Рис.1 Регистрация/Войти</figcaption>
                      </figure>
                    </div>
                    <div class="item">
                      <p>При нажатии на кнопку "Регистрация/Войти" пользователю отображается форма с выбором "Войдите" или "Зарегистрируйтесь», изображенной на рис. 2.</p>
                      <figure>
                        <img src="/images/payment-info/2.png" alt />
                        <figcaption>Рис. 2 Форма "Войдите"/"Зарегистрироваться"</figcaption>
                      </figure>
                    </div>
                    <div class="item">
                      <p>При нажатии на кнопку "Зарегистрируйтесь" пользователю отображается форма заполнения полей регистрации, изображенная на рис. 3. Пользователь заполняет поля: Имя, E-mail, телефон, пароль и щелчком мыши по переключателю выражает свое согласие и принимает условия регистрации и нажимает «Зарегистрироваться».</p>
                      <figure>
                        <img src="/images/payment-info/3.png" alt />
                        <figcaption>Рис. 3 Форма регистрации пользователя.</figcaption>
                      </figure>
                    </div>
                    <div class="item">
                      <p>Далее на почту приходит письмо с подтверждением регистрации, изображенное на рис. 4.</p>
                      <figure>
                        <img src="/images/payment-info/4.png" alt />
                        <figcaption>Рис. 4 Подтверждение регистрации</figcaption>
                      </figure>
                    </div>
                    <div class="item">
                      <p>При нажатии на ссылку в письме происходит переадресация на главный сайт и приветствие об успешном подтверждении почтового адреса, изображенного на рис.5.</p>
                      <figure>
                        <img src="/images/payment-info/5.png" alt />
                        <figcaption>Рис. 5 Подтверждение регистрации</figcaption>
                      </figure>
                    </div>
                  </v-card-text>
                </v-card>
              </v-expansion-panel-content>
              <v-expansion-panel-content expand-icon="expand_more">
                <template v-slot:header>
                  <h6>Цена Услуги</h6>
                </template>
                <v-card>
                  <v-card-text>
                    <p>
                      Стоимость тарифов и услуг доступна по ссылке
                      <span>
                        <a href="https://tamtem.ru/tarifs">https://tamtem.ru/tarifs</a>
                      </span>
                    </p>
                  </v-card-text>
                </v-card>
              </v-expansion-panel-content>
              <v-expansion-panel-content expand-icon="expand_more">
                <template v-slot:header>
                  <h6>Способ оплаты услуги</h6>
                </template>
                <v-card>
                  <v-card-text>
                    <p>На сайте предусмотрена оплата услуги безналичным банковским переводом.</p>
                  </v-card-text>
                </v-card>
              </v-expansion-panel-content>
              <v-expansion-panel-content expand-icon="expand_more">
                <template v-slot:header>
                  <h6>Порядок проведения оплаты</h6>
                </template>
                <v-card>
                  <v-card-text>
                    <p>На сайте пользователь регистрируется, затем авторизуется и переходит в личный кабинет в раздел «Кошелек», изображенный на рис. 6. Далее вводит необходимую сумму для пополнения баланса, выбирает платежную систему. Оплачивает и мы зачисляем ему денежные средства на его лицевой счет. На данный момент доступен только безналичный расчет. Денежные средства на его кошельке увеличиваются на сумму внесенной оплаты.</p>
                    <figure>
                      <img src="/images/payment-info/6.png" alt />
                      <figcaption>Рис. 6 Кошелек пользователя</figcaption>
                    </figure>
                  </v-card-text>
                </v-card>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import Aside from "./components/Aside";
import lkNavigation from "../LK/components/LkNavigation";

export default {
  name: "paymentinfo",
  components: {
    Aside,
    lkNavigation
  }
};
</script>
<style scoped lang="scss">
@import "../../../../sass/base.scss";

.main {
  background-color: #ffffff;
}
.public {
  max-width: 768px;
  margin: 0 auto;
}
.col-content {
  h3 {
    font-family: Roboto;
    font-size: 2rem;
    padding-bottom: 1rem;
    color: $secondary;
    margin-bottom: 2rem;
    border-bottom: 0.2rem dotted $gray;
  }
  h6 {
    font-family: Roboto;
    font-size: 1.8rem;
  }
  .card {
    $border-radius: $border-radius;
    padding: 1.5rem;
  }
  p {
    font-family: Roboto;
    font-size: 1.4rem;
    margin-bottom: 1rem;
    span {
      font-weight: 600;
    }
  }
  .information /deep/ .v-expansion-panel .v-expansion-panel__container {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    border-top: 0.15rem dotted;
    border-color: $secondary;
    background: white !important;

    .v-card__text {
      padding-left: 0px;
      .item {
        margin-top: 3rem;
        margin-bottom: 3rem;
      }
    }
    h6 {
      color: $secondary;
      font-size: 1.6rem;
    }
    .v-icon {
      color: $secondary;
      transform: rotate(-90deg);
    }
    &--active {
      h6 {
        font-size: 1.8rem;
        color: #010101;
      }
      .v-icon {
        color: #010101;
        transform: none;
      }
    }
    figure {
      display: flex;
      flex-direction: column;
      align-items: center;
      img {
        max-width: 100%;
      }
      figcaption {
        font-size: 1.2rem;
      }
    }
  }
}
</style>
