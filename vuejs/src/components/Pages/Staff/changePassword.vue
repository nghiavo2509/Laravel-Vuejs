<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="text-right">
              <router-link to="/admin/staff" class="back">Back</router-link>
            </div>
            <form ref="anyName">
              <div class="form-group">
                <input
                  type="password"
                  class="form-control"
                  placeholder="Password"
                  v-model="form.password"
                />
                <small class="text-danger">{{ error.password }} </small>
              </div>

              <div class="form-group">
                <input
                  type="password"
                  class="form-control"
                  placeholder="Password Comfirmation"
                  v-model="form.password_confirmation"
                />
                <small class="text-danger"
                  >{{ error.password_confirmation }}
                </small>
              </div>

              <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="onClickUpdate"
              >
                Update
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";
export default {
  name: "changePassword",
  data() {
    return {
      form: {
        password: "",
        password_confirmation: "",
      },
      error: { password: "", password_confirmation: "" },
      id: this.$route.params.id,
    };
  },
  methods: {
    async onClickUpdate() {
      let res = await axios.post(
        `http://127.0.0.1:8000/api/user/changePassword/${this.id}`,
        this.form
      );
      if (res.data.status === 200) {
        Swal.fire({
          title: "Updated!",
          text: res.data.message,
          icon: "success",
          confirmButtonText: "Ok",
        });
      }
      if (res.data.errors !== "") {
        let data = res.data.errors;
        for (let x in data) {
          for (let y in this.error) {
            if (x === y) {
              this.error[y] = data[y];
            }
          }
        }
      }
    },
  },
};
</script>

<style>
</style>