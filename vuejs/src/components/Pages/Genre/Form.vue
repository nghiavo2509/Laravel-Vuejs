<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="text-right">
              <router-link to="/admin/genre" class="back">Back</router-link>
            </div>
            <form ref="anyName">
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Thể loại"
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
                    v-model="form.category_id"
                  >
                    <option value="" selected>Danh mục</option>
                    <option
                      v-bind:value="category.id"
                      v-for="category in categories"
                      v-bind:key="category.id"
                    >
                      {{ category.title }}
                    </option>
                  </select>
                </div>
                <small class="text-danger">{{ error.category_id }} </small>
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
import axios from "axios";
import Swal from "sweetalert2";

export default {
  name: "formCategory",
  data() {
    return {
      update: false,
      form: {
        title: "",
        category_id: "",
        slug: "",
        status: "",
      },
      categories: [],
      error: {
        title: "",
        category_id: "",
        slug: "",
        status: "",
      },
      id: this.$route.params.id,
    };
  },
  mounted() {
    const getCategories = async () => {
      let res = await axios.post(
        `http://127.0.0.1:8000/api/category/data/get`,
        {
          status: true,
        }
      );
      this.categories = res.data.categories;
    };
    getCategories();

    let id = this.id;
    if (this.id !== "") {
      this.update = true;
      setTimeout(() => {
        const getItem = async () => {
          let res = await axios.get(`http://127.0.0.1:8000/api/genre/${id}`);
          if (res.data.status === 200) {
            this.form = {
              title: res.data.genre.title,
              category_id: res.data.genre.category,
              slug: res.data.genre.slug,
              status: res.data.genre.status,
            };
            console.log(this.form);
          }
        };
        getItem();
      }, 399);
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
        category_id: "",
        status: "",
      };
      let res = await axios.post(`http://127.0.0.1:8000/api/genre`, this.form);
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
        category_id: "",
        status: "",
      };
      let res = await axios.put(
        `http://127.0.0.1:8000/api/genre/${this.id}`,
        this.form
      );
      console.log(res.data);
      if (res.data.VALID) {
        Swal.fire({
          title: "Updated!",
          text: res.data.TN,
          icon: "success",
          confirmButtonText: "Ok",
        });
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