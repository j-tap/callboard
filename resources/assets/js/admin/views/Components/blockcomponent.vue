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
        <p class="blockcomponent--title">Сменить статус</p>
        <label for="org_type">Статус</label>
        <select v-model="status" name="org_type" class="form-control">
          <option :key="key" v-for="item,key in getOrgStatusArray()" :value="key">{{item}}</option>
        </select>
        <span class="block-reason">Причина</span>
        <textarea v-model="reason" required class="blockreason--textarea"></textarea>
        <button
          type="button"
          class="btn btn-default center-block savebutton"
          v-on:click="changestatus()"
        >Сохранить</button>
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
      status: this.user.status,
      reason: ""
    };
  },
  methods: {
    changestatus() {
      if (this.reason.length < 3) {
        this.showError("Укажите причину");
        return false;
      }
      // axios
      let params = {
        reason: this.reason,
        status: this.status
      };
      axios
        .post("/admin/api/clients/banned/user/" + this.user.id, {
          params
        })
        .then(resp => {
          if (resp.data.result === true) {
            this.messageSaved();
          } else {
            this.showError("Ошибка");
          }
        })
        .catch(this.handleErrorResponse);
    }
  }
};
</script>
<style scoped>
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
.blockreason--textarea {
  resize: none;
  width: 100%;
  height: 100px;
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
.savebutton {
  margin-top: 10px;
  margin-bottom: -2px;
}
</style>
