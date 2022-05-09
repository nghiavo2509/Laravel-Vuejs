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
                  type="text"
                  class="form-control"
                  placeholder="First Name"
                  v-model="form.first_name"
                />
                <small class="text-danger">{{ error.first_name }} </small>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Last Name"
                  v-model="form.last_name"
                />
                <small class="text-danger">{{ error.last_name }} </small>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Email"
                  v-model="form.email"
                />
                <small class="text-danger">{{ error.email }} </small>
              </div>

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
                @click.prevent="onClickSave"
                v-if="isUpdate != true"
              >
                Thêm
              </button>
              <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="onClickUpdate"
                v-else
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
import axios from "axios";
export default {
  name: "formCategory",
  data() {
    return {
      isUpdate: false,
      form: {
        email: "",
        first_name: "",
        last_name: "",
        password: "",
        password_confirmation: "",
      },
      error: {
        email: "",
        first_name: "",
        last_name: "",
        password: "",
        password_confirmation: "",
      },
      id: this.$route.params.id,
    };
  },
  async mounted() {
    // let res = await axios.get(
    //   `http://127.0.0.1:8000/api/user/staff/${this.id}`
    // );
    // console.log(res);
  },

  methods: {
    async onClickSave() {
      this.error = {
        email: "",
        first_name: "",
        last_name: "",
        password: "",
      };
      let res = await axios.post(
        `http://127.0.0.1:8000/api/user/staff`,
        this.form
      );
      if (res.data.status === 200) {
        this.$refs.anyName.reset();
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

    async onClickUpdate() {
      this.error = {
        title: "",
        category_id: "",
        status: "",
      };
      let res = await axios.put(
        `http://127.0.0.1:8000/api/genre/${this.id}`,
        this.form
      );
      if (res.data.VALID) {
        this.$router.push({ path: "/admin/genre" });
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
.back {
  color: blue;
  font-size: 18px;
  font-weight: 600;
}
</style>