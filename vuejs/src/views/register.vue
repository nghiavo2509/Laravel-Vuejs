<template>
  <div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
      <div class="login-content">
        <div class="login-form">
          <form>
            <div class="d-flex justify-content-between">
              <div class="form-group">
                <label>First Name</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="First Name"
                  v-model="form.first_name"
                />
                <small class="text-danger">{{ error.first_name }} </small>
              </div>
              <div class="form-group">
                <label>Last Name</label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="Last Name"
                  v-model="form.last_name"
                />
                <small class="text-danger">{{ error.last_name }} </small>
              </div>
            </div>
            <div class="form-group">
              <label>Your phone</label>
              <input
                type="text"
                class="form-control"
                placeholder="Phone"
                v-model="form.phone"
              />
              <small class="text-danger">{{ error.phone }} </small>
            </div>
            <div class="form-group">
              <label>Email address</label>
              <input
                type="email"
                class="form-control"
                placeholder="Email"
                v-model="form.email"
              />
              <small class="text-danger">{{ error.email }} </small>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="form.password"
              />
              <small class="text-danger">{{ error.password }} </small>
            </div>
            <div class="form-group">
              <label>Password Confirmation</label>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="form.password_confirmation"
              />
              <small class="text-danger"
                >{{ error.password_confirmation }}
              </small>
            </div>
            <button
              type="button"
              class="btn btn-primary btn-flat m-b-30 m-t-30"
              @click="onSubmit"
            >
              Register
            </button>
            <div class="register-link m-t-15 text-center">
              <p>
                Already have account ?
                <router-link to="/admin/login"> Sign in </router-link>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "RegisterComponent",
  data() {
    return {
      form: {
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      error: {
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {
    async onSubmit() {
      let res = await axios.post(
        `http://127.0.0.1:8000/api/user/student`,
        this.form
      );

      if (res.data.status === 200) {
        let data = res.data;
        localStorage.setItem("auth_token", data.token);
        localStorage.setItem("auth_role", false);
        localStorage.setItem("auth_name", data.name);
        this.$router.push({ path: "/" });
      }
      if (res.data.status === 422) {
        this.error = res.data.errors;
        console.log(this.error);
      }
    },
  },
};
</script>

<style>
</style>