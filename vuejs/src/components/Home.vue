<template>
  <div class="row">
    <!-- Blog entries-->
    <div class="col-lg-8">
      <!-- Nested row for non-featured blog posts-->
      <div class="row">
        <div
          class="col-lg-6"
          v-for="product in products"
          v-bind:key="product.id"
        >
          <!-- Blog post-->
          <div class="card mb-4">
            <a href="#!"
              ><img
                class="card-img-top"
                src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg"
                alt="..."
            /></a>
            <div class="card-body">
              <!-- <div class="small text-muted">January 1, 2022</div> -->
              <h2 class="card-title h4">{{ product.title }}</h2>

              <button class="btn btn-primary" @click="handleBorrow(product.id)">
                Mượn ngay →
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- Pagination-->
      <!-- <Pagination /> -->
    </div>
    <!-- Side widgets-->
    <Sidebar />
  </div>
</template>

<script>
import axios from "axios";
// import Pagination from "../layouts/Frontend/Pagination.vue";
import Sidebar from "../layouts/Frontend/Sidebar.vue";
import { getUser } from "@/constants";
import Swal from "sweetalert2";

export default {
  name: "HomeComponent",

  components: { Sidebar },
  data() {
    return {
      products: [],
      auth: localStorage.getItem("auth_token") ? true : false,
    };
  },
  mounted() {
    const getItem = async () => {
      let res = await axios.get(`http://127.0.0.1:8000/api/product`);
      this.products = res.data.products;
    };
    getItem();
  },
  methods: {
    async handleBorrow(product_id) {
      let user = await getUser();
      let res = await axios.post(`http://127.0.0.1:8000/api/borrow/book`, {
        user_id: user.id,
        quantity: 1,
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
};
</script>

<style>
</style>