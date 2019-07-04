<template lang="pug">
footer.footer
	//.height-fixator
	.footer-data
		.container
			.row.items-row
				.col.col-links
					.links-wrapper
						dl
							dt Возможности ТамТем 
							dd 
								router-link(:to="{name:'new.bid', params:{}}") Добавить объявление
							dd
								router-link(:to="{name:'tarifs'}") Тарифы
						dl
							dt Информация
							dd.disabled Блог
							dd
								a(href="/about") О сервисе
							dd
								a(href="/faq.pdf") Вопросы и ответы
							dd
								router-link(:to="{name:'paymentinfo'}") Об оплате
					p.cookie-info.desk Используя данный сайт, вы даёте согласие на использование файлов cookie, помогающих нам сделать его удобнее для вас.
				.col.col-support
					.col-support-wrap
						.inner
							.inner-phone
								b Поддержка 
								a(href='tel:+78007001476') 8&nbsp;800&nbsp;700&nbsp;14&nbsp;76
							.inner-mail
								b Email:
									a(href="mailto:team@tamtem.ru") team@tamtem.ru
		
						.share
							p ТамТем в социальных сетях
							Social
				p.cookie-info.mob Используя данный сайт, вы даёте согласие на использование файлов cookie, помогающих нам сделать его удобнее для вас.			
		.bottom-wrapper
			.container.jure-info
				.row
					.col.jure-info-data
						.jure-info-data-logo
							logoheader
							p © ООО "Акстек", 2019 ОГРН 1187847338920
						.jure-info-data-files
							p
								a( :href="fileurl+'agreement.doc'") Условия использования
							p.contacts.disabled Контакты
							p 
								a( :href="fileurl+'politic.doc'") Политика конфиденциальности
</template>

<script>
import Social from "./Social";

export default {
  components: {
    Social
  },
  data() {
    return {
      fileurl: "/files/"
    };
  },
  methods: {},
  mounted() {}
};
</script>
<style scoped lang="scss">
@import "../../../../../sass/base.scss";
.footer {
  width: 100%;

  .cookie-info {
    font-family: Roboto;
    font-size: 14px;
    text-align: left;
    color: #707070;
    padding-left: 1rem;
    @media (max-width: 540px) {
      font-size: 11px;
    }
    &.mob {
      display: none;
      @media (max-width: 600px) {
        display: block;
        padding-left: 1rem;
        padding-top: 10px;
        width: 100%;
        padding-right: 1rem;
      }
    }
    &.desk {
      display: block;
      padding-left: 0;
      @media (max-width: 600px) {
        display: none;
      }
    }
  }
  .footer-data {
    padding-top: 20px;
    background-image: linear-gradient(
      to bottom,
      rgba(241, 241, 241, 0.31),
      rgba(215, 218, 219, 0.61)
    );
  }
  .disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  .items-row {
    @media (max-width: 540px) {
      flex-direction: column;
    }
  }
  .col {
    min-height: max-content;
    .links-wrapper {
      display: flex;
      justify-content: space-between;
      max-width: 360px;
      @media (max-width: 540px) {
        max-width: 100%;
      }
      dl {
        font-family: Roboto;
        font-size: 14px;
        font-weight: normal;
        text-align: left;
        color: #010101;
        dt {
          font-weight: 500;
        }
        dd {
          margin-top: 10px;
          margin-bottom: 0;
          a {
            color: inherit;
          }
        }
      }
    }
    &-links {
      flex-direction: column;
      display: flex;
      justify-content: space-between;
      @media (max-width: 540px) {
        margin-bottom: 20px;
      }
    }
    &-support {
      max-width: max-content;
      @media (max-width: 540px) {
        max-width: 100%;
      }
      &-wrap {
        @media (max-width: 540px) {
          display: flex;
          justify-content: space-between;
        }
        .inner {
          font-family: Roboto;
          font-size: 14px;
          font-weight: normal;
          font-style: normal;
          font-stretch: normal;
          text-align: left;
          color: #010101;
          margin-bottom: 15px;
          @media (max-width: 540px) {
            font-size: 12px;
          }
          b {
            font-weight: 500;
          }
          &-phone {
            a {
              color: inherit;
              display: block;
              margin-top: 5px;
              margin-bottom: 5px;
            }
          }
          &-mail {
            b {
              a {
                color: #0071bc;
                margin-left: 5px;
                font-weight: 400;
              }
            }
          }
        }
        .share {
          font-family: Roboto;
          font-size: 14px;
          text-align: left;
          color: #010101;
          p {
            margin-bottom: 5px;
            @media (max-width: 540px) {
              display: none;
            }
          }
        }
      }
    }
  }
  .bottom-wrapper {
    margin-top: 5px;
    background: #e6e9ec;
    .jure-info {
      &-data {
        padding-top: 7px;
        padding-bottom: 7px;
        display: flex;
        @media (max-width: 700px) {
          display: block;
        }
        &-logo {
          display: flex;
          align-items: flex-end;
          width: 100%;
          /deep/ svg {
            width: 102px;
          }
          @media (max-width: 860px) {
            display: block;
            max-width: max-content;
            /deep/ svg {
              width: 80px;
            }
          }
          p {
            line-height: normal;
            font-family: Roboto;
            font-size: 14px;
            text-align: left;
            color: #707070;
            margin-left: 10px;
            @media (max-width: 860px) {
              display: block;
              margin-left: 0;
              margin-top: 5px;
            }
          }
        }
        &-files {
          width: 100%;
          display: flex;
          align-items: flex-end;
          font-family: Roboto;
          font-size: 12px;
          font-weight: normal;
          text-align: left;
          color: #707070;
          a {
            color: inherit;
          }
          .contacts {
            padding-left: 5px;
            padding-right: 5px;
            margin-left: 5px;
            margin-right: 5px;
            border-left: 1px solid #707070;
            border-right: 1px solid #707070;
          }
          @media (max-width: 860px) {
            justify-content: end;
          }
          @media (max-width: 700px) {
            justify-content: left;
            margin-top: 5px;
          }
          @media (max-width: 500px) {
            display: block;
            margin-top: 15px;
            .contacts {
              padding: 0;
              margin: 0;
              border: none;
            }
          }
        }
      }
    }
  }
}
</style>