<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title"
              >Quản lý sinh viên mượn - trả sách</strong
            >
            <h4>Tổng : {{ total }}</h4>
          </div>
          <div class="card-body">
            <div class="mb-3 text-right">
              <router-link class="btn btn-primary" to="/admin/borrow/item">
                Thêm mới
              </router-link>
            </div>
            <table
              id="bootstrap-data-table"
              class="table table-striped table-bordered"
            >
              <thead>
                <tr>
                  <th>Mã sinh viên</th>
                  <th>Tên sách</th>
                  <th>Số lượng</th>
                  <!-- <th>Nhân viên</th> -->
                  <th>Trạng thái</th>
                  <th>Manage</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="borrow in borrows" v-bind:key="borrow.id">
                  <td>{{ borrow.user_code }}</td>
                  <td>{{ borrow.product.title }}</td>
                  <td>{{ borrow.quantity }}</td>
                  <!-- <td>NULL</td> -->
                  <td>{{ handingStatus(borrow.status) }}</td>

                  <td class="manage">
                    <router-link
                      :to="{
                        path: `/admin/borrow/item/${borrow.id}`,
                        query: {},
                      }"
                      class="btn btn-info"
                    >
                      Edit
                    </router-link>
                    <button
                      type="button"
                      @click="onClickDelete(borrow.id, key)"
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
  name: "IndexBorrow",
  data() {
    return {
      borrows: [],
      total: 0,
    };
  },
  async mounted() {
    let res = await axios.get(`http://127.0.0.1:8000/api/borrow`);
    if (res.data.borrows !== "") {
      this.borrows = res.data.borrows;
      this.total = res.data.borrows.length;
    }
  },
  methods: {
    handingStatus(status) {
      if (status === "dang_muon") {
        status = "Đang mượn";
      } else if (status === "da_tra") {
        status = "Đã trả";
      } else {
        status = "Hủy";
      }
      return status;
    },

    async onClickDelete(id, key) {
      if (confirm("Are you sure?")) {
        await axios.delete(`http://127.0.0.1:8000/api/borrow/${id}`);
        this.borrows.splice(key, 1);
      }
    },
  },
};
</script>

<style>
</style>