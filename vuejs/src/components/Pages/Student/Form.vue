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
                />
                <small class="text-danger">{{ error.title }} </small>
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
export default {
  name: "formCategory",
  data() {
    return {
      update: false,
      form: {
        title: "",
        category_id: "",
        status: "",
      },
      categories: [],
      error: {
        title: "",
        category_id: "",
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
              status: res.data.genre.status,
            };
          }
        };
        getItem();
      }, 399);
    }
  },
  methods: {
    async onClickSave() {
      this.error = {
        title: "",
        category_id: "",
        status: "",
      };
      let res = await axios.post(`http://127.0.0.1:8000/api/genre`, this.form);
      if (res.data.VALID) {
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