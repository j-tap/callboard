<template>
  <div class="shadow">
    <div class="blockcomponent--wrapper">
      <div class="closeform--wrapper">
        <button
          type="button"
          v-on:click="$emit('closecomponent')"
          class="btn pull-right closebutton"
        >X</button>
      </div>
      <div class="blockcomponent--body">
        <p class="blockcomponent--title">Сформировать счёт</p>
        <form v-on:submit.prevent="createScore()" action="javascript:void(0);">
          <div class="form-group">
            <label for="summ">Введите сумму</label>
            <input
              required
              v-model="summ"
              type="text"
              class="form-control"
              id="summ"
              placeholder="Введите сумму"
              @keypress="isNumber($event)"
            >
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-default">Выставить счёт</button>
          </div>
        </form>
        <form v-on:submit.prevent="sendScore()" action="javascript:void(0:">
          <div v-if="scoreCreate" class="form-group">
            <button class="form-group btn btn-default" v-on:click="downloadScore()">Скачать счёт</button>
            <label for="usermail">Отправить счёт на электронную почту</label>
            <input
              required
              v-model="usermail"
              type="text"
              class="form-control"
              id="usermail"
              placeholder="Введите адрес электронной почты"
            >
            <button type="submit" class="center-block btn btn-default">Отправить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import ViewMixins from "../../mixins/view";
export default {
  mixins: [ViewMixins],
  props: {
    user: {
      type: [Array, Object]
    }
  },
  data() {
    return {
      summ: "",
      scoreCreate: false,
      usermail: this.user.email,
      scorelink: null,
      scoreNumber: null
    };
  },
  methods: {

    isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    },

    createScore() {
      let params = {
        unique_id: this.user.unique_id,
        summ: Number(this.summ).toFixed(2)
      };
      if (isNaN(params.summ)) {
        this.showError("Сумма должна быть числом");
        return false;
      }
      axios.post("/admin/api/clients/score/create", { params }).then(resp => {
        if (resp.data.result && resp.data.result === true) {
          this.showAlert("Счёт сформирован");
          this.scorelink = resp.data.link;
          this.scoreCreate = true;
          this.scoreNumber = resp.data.scoreNumber;
        } else {
          this.showError("Произошла ошибка, попробуйте позднее");
        }
      });
      //.catch(this.handleErrorResponse);
    },
    downloadScore() {
      var link = document.createElement("a");
      link.href = this.scorelink;
      link.target = "__blank";
      link.dispatchEvent(
        new MouseEvent(`click`, {
          bubbles: true,
          cancelable: true,
          view: window
        })
      );
    },
    sendScore() {
      let params = {
        unique_id: this.user.unique_id,
        link: this.scorelink,
        usermail: this.usermail
      };

      axios
        .post("/admin/api/clients/score/send", { params })
        .then(resp => {
          if (resp.data.result === true) {
            this.showAlert("Счёт отправлен");
          } else {
            this.showError("Произошла ошибка, попробуйте позднее");
          }
        })
        .catch(this.handleErrorResponse);
    }
  }
};
</script>
<style scoped>
button.form-group {
  margin-bottom: 15px !important;
}
button.center-block {
  margin-top: 10px;
}
.shadow {
  position: fixed;
  width: 100%;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  z-index: 10;
  background: #0006;
}
.blockcomponent--wrapper {
  width: 400px;
  position: fixed;
  left: calc(50% - 200px);
  top: 30%;
  background: white;
  padding: 15px;
}
.blockcomponent--title {
  font-weight: 600;
}
.closebutton {
  padding: 0;
  background: transparent;
  font-weight: 600;
  line-height: 0;
  cursor: pointer;
  height: 11px;
}
</style>
