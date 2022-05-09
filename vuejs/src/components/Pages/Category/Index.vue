<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Danh sách danh mục</strong>
            <h4>Tổng : {{ total }}</h4>
          </div>
          <div class="card-body">
            <div class="mb-3 text-right">
              <router-link class="btn btn-primary" to="/admin/category/item">
                Thêm mới
              </router-link>
            </div>
            <table
              id="bootstrap-data-table"
              class="table table-striped table-bordered"
            >
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên danh mục</th>
                  <th>Trạng thái</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(category, key) in categories" v-bind:key="key">
                  <td>{{ category.id }}</td>
                  <td>{{ category.title }}</td>
                  <td>{{ category.slug }}</td>
                  <td>{{ category.status === 1 ? "Hiển thị" : "Ẩn" }}</td>
                  <td class="manage">
                    <router-link
                      :to="{
                        path: `/admin/category/item/${category.id}`,
                      }"
                      class="btn btn-info"
                    >
                      Edit
                    </router-link>
                    <button
                      type="button"
                      @click="onClickDelete(category.id, key)"
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
  name: "IndexCategory",
  data() {
    return {
      categories: [],
      total: 0,
    };
  },
  async mounted() {
    let res = await axios.get(`http://127.0.0.1:8000/api/category`);
    console.log(res.data.categories.length);
    if (res.data.categories !== "") {
      this.categories = res.data.categories;
      this.total = res.data.categories.length;
    }
  },
  methods: {
    async onClickDelete(id, key) {
      if (confirm("Are you sure?")) {
        await axios.delete(`http://127.0.0.1:8000/api/category/${id}`);
        this.categories.splice(key, 1);
      }
    },
  },
};
</script>

<style>
.manage {
  display: flex;
  justify-content: center;
  gap: 10px;
}
</style>