<template>
  <div
    class="card m-2"
    style="width: 18rem"
    v-for="product in products"
    v-bind:key="product.id"
  >
    <a href="#!"
      ><img
        class="card-img-top"
        src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg"
        alt="..."
    /></a>
    <div class="card-body">
      <h3 class="card-title text-center text-title">{{ product.title }}</h3>

      <form
        @submit.prevent="handleBorrow(form.quantity, product.id)"
        v-bind:class="'item-' + product.id"
      >
        <input type="hidden" v-model="product.id" />
        <input type="number" class="form-control m-2" v-model="form.quantity" />
        <div class="text-center">
          <button class="btn btn-primary">Mượn ngay</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import { getUser } from "@/constants";

export default {
  name: "FCategory",
  data() {
    return {
      form: {
        quantity: 1,
        product: "",
      },
      products: [],
      slug: "",
      id: this.$route.params.id,
    };
  },

  methods: {
    async getItem() {
      let res = await axios.get(
        `http://127.0.0.1:8000/api/product/get/${this.id}`
      );
      this.products = res.data.products;
    },
    async handleBorrow(qty, product_id) {
      let user = await getUser();
      let res = await axios.post(`http://127.0.0.1:8000/api/borrow/book`, {
        user_id: user.id,
        quantity: qty,
        product_id: product_id,
        staff: "NULL",
      });
      if (res.data.VALID) {
        Swal.fire({
          title: "Thành công!",
          text: res.data.TN,
          icon: "success",
          confirmButtonText: "Ok",
        });
      } else {
        Swal.fire({
          title: "Thất bại",
          text: res.data.TN,
          icon: "danger",
          confirmButtonText: "Ok",
        });
      }
    },
  },
  watch: {
    "$route.params": {
      immediate: true,
      handler(newValue) {
        this.id = newValue.id;
        this.getItem();
      },
    },
  },
};
</script>

<style>
.text-title {
  display: -webkit-box;
  max-height: 2.6em;
  overflow: hidden;
  height: 70px;
  text-overflow: ellipsis;
  white-space: normal;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>