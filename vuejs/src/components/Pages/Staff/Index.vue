<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Nhân viên</strong>
          </div>
          <div class="card-body">
            <div class="mb-3 text-right">
              <router-link class="btn btn-primary" to="/admin/staff/item">
                Thêm nhân viên
              </router-link>
            </div>
            <table
              id="bootstrap-data-table"
              class="table table-striped table-bordered"
            >
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên</th>
                  <th>Email</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="staff in staffs" v-bind:key="staff.id">
                  <td>{{ staff.id }}</td>
                  <td>{{ staff.name }}</td>
                  <td>{{ staff.user.email }}</td>

                  <td class="manage">
                    <router-link
                      :to="{
                        path: `/admin/staff/item/${staff.user.id}/change`,
                      }"
                      class="btn btn-info"
                    >
                      Đổi mật khẩu
                    </router-link>
                    <!-- <button
                      type="button"
                      @click="onClickDelete(staff.id, key)"
                      class="btn btn-danger"
                    >
                      Delete
                    </button> -->
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
      staffs: [],
    };
  },
  async mounted() {
    let res = await axios.get(`http://127.0.0.1:8000/api/staff`);
    if (res.data.staffs !== "") {
      this.staffs = res.data.staffs;
    }
  },
  methods: {
    // async onClickDelete(id, key) {
    //   if (confirm("Are you sure?")) {
    //     await axios.delete(`http://127.0.0.1:8000/api/genre/${id}`);
    //     this.genres.splice(key, 1);
    //   }
    // },
  },
};
</script>

<style>
</style>