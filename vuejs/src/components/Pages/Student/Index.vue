<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Sinh viên</strong>
          </div>
          <div class="card-body">
            <div class="mb-3 text-right">
              <router-link class="btn btn-primary" to="/admin/student">
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
                  <th>Mã sinh viên</th>
                  <th>Tên</th>
                  <th>Số điện thoại</th>
                  <th>Đang mượn</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(student, key) in students" :key="student.id">
                  <td>{{ student.id }}</td>
                  <td>{{ student.student_code }}</td>
                  <td>{{ student.name }}</td>
                  <td>{{ student.phone }}</td>
                  <td>{{ student.borrow.length }}</td>
                  <td class="manage">
                    <router-link
                      :to="{
                        path: `/admin/student/item/${student.id}`,
                      }"
                      class="btn btn-info"
                    >
                      Edit
                    </router-link>
                    <button
                      type="button"
                      @click="onClickDelete(student.id, key)"
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
      students: [],
    };
  },
  async mounted() {
    let res = await axios.get(`http://127.0.0.1:8000/api/student`);
    if (res.data.students !== "") {
      this.students = res.data.students;
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