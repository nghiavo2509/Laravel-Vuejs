<template>
  <div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
      <div class="login-content">
        <div class="login-form">
          <form @submit.prevent="onLogin">
            <div class="form-group">
              <label>Email address</label>
              <input
                type="email"
                autocomplete="username"
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
                autocomplete="current-password"
                v-model="form.password"
              />
              <small class="text-danger">{{ error.password }} </small>
            </div>

            <button
              type="submit"
              class="btn btn-success btn-flat m-b-30 m-t-30"
            >
              Sign in
            </button>

            <div class="register-link m-t-15 text-center">
              <p>
                Don't have account ?
                <router-link to="/register"> Sign Up Here </router-link>
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
  name: "LoginComponent",
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      error: {
        email: "",
        password: "",
      },
    };
  },
  methods: {
    async onLogin() {
      this.error = [];
      let res = await axios.post(
        `http://127.0.0.1:8000/api/user/login`,
        this.form
      );
      if (res.data.status === 200) {
        let data = res.data;
        localStorage.setItem("auth_token", data.token);
        localStorage.setItem("auth_role", data.role);
        localStorage.setItem("auth_name", data.username);
        if (data.role !== true) {
          this.$router.push({ path: "/" });
        } else {
          this.$router.push({ path: "/admin" });
        }
      }
      if (res.data.status === 422) {
        this.error = res.data.errors;
      } else if (res.data.status === 401) {
        this.error.email = res.data.message;
      }
    },
  },
};
</script>

<style >
.sufee-login {
  position: absolute;
  left: 50%;
  min-width: 600px;
  transform: translateX(-50%) translateY(25%);
}
</style>