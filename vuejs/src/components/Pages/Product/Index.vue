<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Kho sách</strong>
            <h4>Tổng : {{ total }}</h4>
          </div>
          <div class="card-body">
            <div class="mb-3 text-right">
              <router-link class="btn btn-primary" to="/admin/product/item">
                Thêm mới
              </router-link>
            </div>
            <table
              id="bootstrap-data-table"
              class="table table-striped table-bordered"
            >
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Tên sách</th>
                  <th>Danh mục</th>
                  <th>Kho</th>
                  <th>Đã cho mượn</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, key) in products" v-bind:key="product.id">
                  <td>{{ product.id }}</td>
                  <td>{{ product.title }}</td>
                  <td>{{ product.category.title }}</td>
                  <td>{{ product.quantity }}</td>
                  <td>{{ total }}</td>
                  <td class="manage">
                    <router-link
                      :to="{
                        path: `/admin/product/item/${product.id}`,
                        query: {
                          cate: product.category.id,
                        },
                      }"
                      class="btn btn-info"
                    >
                      Edit
                    </router-link>
                    <button
                      type="button"
                      @click="onClickDelete(product.id, key)"
                      class="btn btn-danger"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- .animated -->
</template>

<script>
import axios from "axios";
export default {
  name: "IndexProduct",
  data() {
    return {
      products: [],
      total: 0,
    };
  },
  async mounted() {
    let res = await axios.get(`http://127.0.0.1:8000/api/product`);
    console.log(res.data.products);
    if (res.data.products !== "") {
      this.products = res.data.products;
      this.total = res.data.products.length;
    }
  },
  methods: {
    async onClickDelete(id, key) {
      if (confirm("Are you sure?")) {
        await axios.delete(`http://127.0.0.1:8000/api/product/${id}`);
        this.products.splice(key, 1);
      }
    },
  },
};
</script>

<style>
</style>