<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="text-right">
              <router-link to="/admin/category" class="back">Back</router-link>
            </div>
            <form ref="anyName">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Danh mục"
                  v-model="form.title"
                  @keyup="onKeyUp($event)"
                />
                <small class="text-danger">{{ error.title }} </small>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Slug"
                  v-model="form.slug"
                />
                <small class="text-danger">{{ error.slug }} </small>
              </div>
              <div class="form-group">
                <div class="input-group mb-3">
                  <select
                    class="custom-select"
                    id="inputGroupSelect01"
                    v-model="form.status"
                  >
                    <option value="" selected>Trạng thái</option>
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                  </select>
                </div>
                <small class="text-danger">{{ error.status }} </small>
              </div>

              <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="onClickSave"
                v-if="update != true"
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
import Swal from "sweetalert2";
import axios from "axios";
export default {
  name: "formCategory",
  data() {
    return {
      update: false,
      form: {
        title: "",
        slug: "",
        status: "",
      },
      error: {
        title: "",
        slug: "",
        status: "",
      },
      id: this.$route.params.id,
    };
  },
  mounted() {
    let id = this.id;
    if (this.id !== "") {
      this.update = true;
      const getItem = async () => {
        let res = await axios.get(`http://127.0.0.1:8000/api/category/${id}`);
        if (res.data.status === 200) {
          this.form = res.data.category;
        }
      };
      getItem();
    }
  },
  methods: {
    onKeyUp(event) {
      let str = event.target.value;
      let res = this.stringToSlug(str);
      return (this.form.slug = res);
    },
    async onClickSave() {
      this.error = {
        title: "",
        slug: "",
        status: "",
      };
      let res = await axios.post(
        `http://127.0.0.1:8000/api/category`,
        this.form
      );
      if (res.data.VALID) {
        Swal.fire({
          title: "Created!",
          text: res.data.TN,
          icon: "success",
          confirmButtonText: "Ok",
        });
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
        status: "",
      };
      let res = await axios.put(
        `http://127.0.0.1:8000/api/category/${this.id}`,
        this.form
      );
      if (res.data.VALID) {
        Swal.fire({
          title: "Updated!",
          text: res.data.TN,
          icon: "success",
          confirmButtonText: "Ok",
        });
        this.$router.push({ path: "/admin/category" });
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
.back:hover {
  text-decoration: underline;
  color: blue;
  opacity: 0.5;
}
</style>