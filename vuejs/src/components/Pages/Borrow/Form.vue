<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="text-right">
              <router-link to="/admin/borrow" class="back">Back</router-link>
            </div>
            <form>
              <div class="form-group">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Mã sinh viên"
                  v-model="form.user_code"
                />
                <small class="text-danger">{{ error.user_code }} </small>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  list="films"
                  class="form-control"
                  v-model="form.product"
                  placeholder="Tên sách"
                />
                <datalist id="films">
                  <option v-for="product in products" v-bind:key="product.id">
                    {{ product.title }}
                  </option>
                </datalist>
                <small class="text-danger">{{ error.product }} </small>
              </div>
              <div class="form-group">
                <input
                  type="number"
                  class="form-control"
                  placeholder="Số lượng"
                  v-model="form.quantity"
                />
                <small class="text-danger">{{ error.quantity }} </small>
              </div>

              <div class="form-group" v-if="isUpdate">
                <div class="input-group mb-3">
                  <select
                    class="custom-select"
                    id="inputGroupSelect01"
                    v-model="form.status"
                  >
                    <option value="" selected>Trạng thái</option>
                    <option value="dang_muon">Đang mượn</option>
                    <option value="da_tra">Trả</option>
                    <option value="huy_bo">Hủy</option>
                  </select>
                </div>
                <small class="text-danger">{{ error.status }} </small>
              </div>
              <div class="form-group" v-else>
                <input
                  type="text"
                  class="form-control"
                  value="Sinh viên mượn"
                  disabled
                />
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
import Swal from "sweetalert2";
import { getUser } from "@/constants";

import axios from "axios";
export default {
  name: "formCategory",
  data() {
    return {
      update: false,
      form: {
        user_code: "",
        quantity: "",
        product: "",
        staff_id: "",
        status: "",
      },
      products: [],
      error: { user_code: "", quantity: "", product: "", status: "" },
      id: this.$route.params.id,
      isUpdate: false,
    };
  },
  mounted() {
    if (this.$route.params.id) {
      const getItem = async () => {
        let res = await axios.get(
          `http://127.0.0.1:8000/api/borrow/${this.id}`
        );
        this.form = {
          user_code: res.data.user_code,
          quantity: res.data.quantity,
          product: res.data.product.title,
          status: res.data.status,
        };
        this.isUpdate = true;
      };
      getItem();
    }
    const getProduct = async () => {
      let res = await axios.post(`http://127.0.0.1:8000/api/product/data/get`, {
        status: true,
      });
      this.products = res.data.products;
    };
    getProduct();
  },
  methods: {
    async onClickSave() {
      this.error = {
        user_code: "",
        quantity: "",
        product: "",
      };
      let user = await getUser();
      this.form.staff_id = user.id;
      let res = await axios.post(`http://127.0.0.1:8000/api/borrow`, this.form);
      if (res.data.VALID !== true) {
        this.error.product = res.data.TN;
      } else if (res.data.VALID) {
        Swal.fire({
          title: "Created!",
          text: res.data.TN,
          icon: "success",
          confirmButtonText: "Ok",
        });
        this.form = {
          user_code: "",
          quantity: "",
          product: "",
        };
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
      let res = await axios.put(
        `http://127.0.0.1:8000/api/borrow/${this.id}`,
        this.form
      );
      if (res.data.VALID) {
        Swal.fire({
          title: "Updated!",
          text: res.data.TN,
          icon: "success",
          confirmButtonText: "Ok",
        });
        this.$router.push({ path: "/admin/borrow" });
      } else if (res.data.VALID !== true) {
        this.error.product = res.data.TN;
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