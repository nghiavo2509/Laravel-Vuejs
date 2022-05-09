<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 w-100">
          <li class="nav-item">
            <router-link to="/" class="nav-link active"> Home </router-link>
          </li>
          <li
            class="nav-item parent"
            v-for="category in categories"
            v-bind:key="category.id"
          >
            <span class="nav-link nav-parent" @click="goToCategory(category)">
              {{ category.title }}
            </span>

            <span class="arrow" v-if="category.count_genre > 0">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path
                  d="M310.6 246.6l-127.1 128C176.4 380.9 168.2 384 160 384s-16.38-3.125-22.63-9.375l-127.1-128C.2244 237.5-2.516 223.7 2.438 211.8S19.07 192 32 192h255.1c12.94 0 24.62 7.781 29.58 19.75S319.8 237.5 310.6 246.6z"
                />
              </svg>
            </span>
            <ul class="child" v-if="category.count_genre > 0">
              <li v-for="genre in category.genres" v-bind:key="genre.id">
                <router-link
                  :to="{
                    path: `/the-loai/${genre.slug}.html`,
                  }"
                >
                  {{ genre.title }}
                </router-link>
              </li>
            </ul>
          </li>

          <!-- <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#">Blog</a>
          </li> -->
          <li class="nav-item">
            <router-link class="nav-link" to="/login" v-if="auth !== true">
              Login
            </router-link>
            <a href="javascript:void(0)" v-else @click="onLogout"> Logout </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import axios from "axios";
export default {
  name: "NavBar",
  data() {
    return {
      categories: [],
      auth: localStorage.getItem("auth_token") ? true : false,
    };
  },
  mounted() {
    const getCategory = async () => {
      let res = await axios.get(`http://127.0.0.1:8000/api/category`);
      this.categories = res.data.categories;
    };
    getCategory();
  },
  methods: {
    onLogout() {
      localStorage.removeItem("auth_token");
      localStorage.removeItem("auth_name");
      this.$router.push({ path: "/login" });
    },
    goToCategory(category) {
      let slug = category.slug;
      return this.$router.push({
        name: "FCategory",
        params: { category: slug, id: category.id },
      });
    },
  },
};
</script>

<style scoped>
.navbar {
  display: block;
  padding: 20px 0;
}
.navbar .navbar-nav {
  align-items: baseline;
  justify-content: space-between;
}
.navbar .navbar-nav li > a {
  font-size: 17px;
}
.navbar .navbar-nav > li {
  padding-left: 15px;
  padding-right: 15px;
}
.navbar .navbar-nav li {
  width: auto;
}
.child .nav-item {
  padding: 5px 20px;
}
.parent {
  position: relative;
}

.parent .arrow {
  position: absolute;
  top: 15px;
  width: 13px;
  right: 5px;
}
li.parent:hover > .child {
  opacity: 1;
}
.parent .child {
  opacity: 0;
  position: absolute;
  top: 45px;
  left: 25px;
  width: 200px;
  background: #fff;
  list-style-type: none;
  box-shadow: 3px 3px 6px 0px #3a3a42;
  z-index: 999;
  padding: 15px 10px;
  text-align: center;
}
.nav-parent:hover {
  cursor: pointer;
}
</style>