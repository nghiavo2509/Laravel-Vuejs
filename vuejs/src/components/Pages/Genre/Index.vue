<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Thể loại</strong>
            <h4>Tổng : {{ total }}</h4>
          </div>
          <div class="card-body">
            <div class="mb-3 text-right">
              <router-link class="btn btn-primary" to="/admin/genre/item">
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
                  <th>Tên thể loại</th>
                  <th>Trạng thái</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(genre, key) in genres" :key="genre.id">
                  <td>{{ genre.id }}</td>
                  <td>{{ genre.title }}</td>
                  <td>{{ genre.status === 1 ? "Hiển thị" : "Ẩn" }}</td>
                  <td class="manage">
                    <router-link
                      :to="{
                        path: `/admin/genre/item/${genre.id}`,
                      }"
                      class="btn btn-info"
                    >
                      Edit
                    </router-link>
                    <button
                      type="button"
                      @click="onClickDelete(genre.id, key)"
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
  name: "IndexGenre",
  data() {
    return {
      genres: [],
      total: 0,
    };
  },
  async mounted() {
    let res = await axios.get(`http://127.0.0.1:8000/api/genre`);
    console.log(res.data.genres);
    if (res.data.genres !== "") {
      this.genres = res.data.genres;
      this.total = res.data.genres.length;
    }
  },
  methods: {
    async onClickDelete(id, key) {
      if (confirm("Are you sure?")) {
        await axios.delete(`http://127.0.0.1:8000/api/genre/${id}`);
        this.genres.splice(key, 1);
      }
    },
  },
};
</script>

<style>
</style>